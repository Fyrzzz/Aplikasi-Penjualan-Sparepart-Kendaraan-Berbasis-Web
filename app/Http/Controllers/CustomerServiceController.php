<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CustomerServiceController extends Controller
{
    public function status(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $search = trim($validated['search'] ?? '');

        return view('bengkel.cek-servis', [
            'search' => $search,
            'workOrders' => $this->workOrders($request->user(), $search, $search === ''),
        ]);
    }

    public function history(Request $request): View
    {
        return view('bengkel.riwayat', [
            'workOrders' => $this->workOrders($request->user(), includeStandaloneSales: true),
        ]);
    }

    /**
     * @return Collection<int, object>
     */
    private function workOrders(
        User $user,
        string $search = '',
        bool $activeOnly = false,
        bool $includeStandaloneSales = false,
    ): Collection {
        $email = $this->customerEmail($user->email);
        $phoneCandidates = $this->phoneCandidates($user->phone);

        return Tenant::query()
            ->get()
            ->filter(fn (Tenant $tenant): bool => $tenant->isActive())
            ->flatMap(function (Tenant $tenant) use ($user, $email, $phoneCandidates, $search, $activeOnly, $includeStandaloneSales): Collection {
                return $tenant->run(function () use ($tenant, $user, $email, $phoneCandidates, $search, $activeOnly, $includeStandaloneSales): Collection {
                    $customerIds = DB::table('customers')
                        ->where(function (Builder $query) use ($user, $email, $phoneCandidates): void {
                            $query->where('central_user_id', $user->getKey())
                                ->orWhere(function (Builder $query) use ($email, $phoneCandidates): void {
                                    $query->whereNull('central_user_id')
                                        ->where(function (Builder $query) use ($email, $phoneCandidates): void {
                                            if ($email !== null) {
                                                $query->whereRaw('LOWER(email) = ?', [$email]);
                                            } elseif ($phoneCandidates !== []) {
                                                $this->wherePhoneMatches($query, $phoneCandidates);
                                            } else {
                                                $query->whereRaw('1 = 0');
                                            }
                                        });
                                });
                        })
                        ->pluck('id');

                    if ($customerIds->isEmpty()) {
                        return collect();
                    }

                    $workOrders = DB::table('work_orders')
                        ->join('customers', 'customers.id', '=', 'work_orders.customer_id')
                        ->join('vehicles', 'vehicles.id', '=', 'work_orders.vehicle_id')
                        ->leftJoin('employees', 'employees.id', '=', 'work_orders.mechanic_id')
                        ->whereIn('work_orders.customer_id', $customerIds)
                        ->when($activeOnly, fn (Builder $query) => $query->whereIn('work_orders.status', ['waiting', 'in_progress']))
                        ->when($search !== '', function (Builder $query) use ($search): void {
                            $query->where(function (Builder $query) use ($search): void {
                                $query->where('work_orders.work_order_number', 'like', "%{$search}%")
                                    ->orWhere('vehicles.license_plate', 'like', "%{$search}%");
                            });
                        })
                        ->latest('work_orders.created_at')
                        ->limit(50)
                        ->get([
                            'work_orders.id',
                            'work_orders.work_order_number',
                            'work_orders.status',
                            'work_orders.complaint',
                            'work_orders.created_at',
                            'work_orders.estimated_completion_at',
                            'customers.name as customer_name',
                            'vehicles.license_plate',
                            'vehicles.brand as vehicle_brand',
                            'vehicles.model as vehicle_model',
                            'vehicles.year as vehicle_year',
                            'employees.name as mechanic_name',
                        ]);

                    $workOrderIds = $workOrders->pluck('id');
                    $servicesByOrder = collect();
                    $salesByOrder = collect();

                    if ($workOrderIds->isNotEmpty()) {
                        $servicesByOrder = DB::table('work_order_services')
                            ->whereIn('work_order_id', $workOrderIds)
                            ->get(['work_order_id', 'service_name', 'subtotal'])
                            ->groupBy('work_order_id');
                        $salesByOrder = DB::table('sales')
                            ->whereIn('work_order_id', $workOrderIds)
                            ->select('work_order_id')
                            ->selectRaw('SUM(total) as total')
                            ->groupBy('work_order_id')
                            ->get()
                            ->keyBy('work_order_id');
                    }

                    $entries = $workOrders->map(function (object $workOrder) use ($tenant, $servicesByOrder, $salesByOrder): object {
                        $services = $servicesByOrder->get($workOrder->id, collect());
                        $saleTotal = $salesByOrder->get($workOrder->id)?->total;
                        $workOrder->entry_type = 'work_order';
                        $workOrder->tenant_name = $tenant->getAttribute('tenant_name');
                        $workOrder->service_summary = $services->pluck('service_name')->join(', ');
                        $workOrder->total = $saleTotal ?? $services->sum('subtotal');
                        $workOrder->status_label = match ($workOrder->status) {
                            'waiting' => 'Menunggu antrean',
                            'in_progress' => 'Sedang dikerjakan',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                            default => ucfirst(str_replace('_', ' ', $workOrder->status)),
                        };

                        return $workOrder;
                    });

                    if (! $includeStandaloneSales) {
                        return $entries;
                    }

                    $sales = DB::table('sales')
                        ->whereIn('customer_id', $customerIds)
                        ->whereNull('work_order_id')
                        ->latest('sold_at')
                        ->latest('created_at')
                        ->limit(50)
                        ->get(['id', 'invoice_number', 'status', 'total', 'sold_at', 'created_at']);
                    $saleItems = DB::table('sale_items')
                        ->whereIn('sale_id', $sales->pluck('id'))
                        ->get(['sale_id', 'item_name'])
                        ->groupBy('sale_id');

                    $transactions = $sales->map(function (object $sale) use ($tenant, $saleItems): object {
                        $sale->entry_type = 'sale';
                        $sale->tenant_name = $tenant->getAttribute('tenant_name');
                        $sale->work_order_number = $sale->invoice_number;
                        $sale->service_summary = $saleItems->get($sale->id, collect())->pluck('item_name')->join(', ');
                        $sale->created_at = $sale->sold_at ?? $sale->created_at;
                        $sale->status_label = match ($sale->status) {
                            'completed' => 'Transaksi selesai',
                            'pending' => 'Menunggu pembayaran',
                            'cancelled' => 'Transaksi dibatalkan',
                            default => ucfirst(str_replace('_', ' ', $sale->status)),
                        };

                        return $sale;
                    });

                    return $entries->concat($transactions);
                });
            })
            ->sortByDesc('created_at')
            ->take(50)
            ->values();
    }

    private function customerEmail(?string $email): ?string
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || str_ends_with(mb_strtolower((string) $email), '@accounts.amahay.invalid')) {
            return null;
        }

        return mb_strtolower($email);
    }

    /**
     * @return list<string>
     */
    private function phoneCandidates(?string $phone): array
    {
        $digits = preg_replace('/\D+/', '', $phone ?? '');

        if ($digits === '') {
            return [];
        }

        $candidates = [$digits];
        if (str_starts_with($digits, '62')) {
            $candidates[] = '0'.substr($digits, 2);
        } elseif (str_starts_with($digits, '0')) {
            $candidates[] = '62'.substr($digits, 1);
        }

        return array_values(array_unique($candidates));
    }

    /**
     * @param  list<string>  $phoneCandidates
     */
    private function wherePhoneMatches(Builder $query, array $phoneCandidates): void
    {
        $phoneDigits = "REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '+', ''), '(', ''), ')', '')";
        $placeholders = implode(', ', array_fill(0, count($phoneCandidates), '?'));

        $query->whereRaw("{$phoneDigits} IN ({$placeholders})", $phoneCandidates);
    }
}
