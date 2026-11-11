<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OwnerOperationsController extends Controller
{
    public function queue(): View
    {
        $tenant = $this->currentTenant();

        $data = $tenant->run(function (): array {
            $statusCounts = DB::table('work_orders')
                ->select('status')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            $ordersByStatus = [];
            foreach (['waiting', 'in_progress', 'completed'] as $status) {
                $ordersByStatus[$status] = DB::table('work_orders')
                    ->join('customers', 'customers.id', '=', 'work_orders.customer_id')
                    ->join('vehicles', 'vehicles.id', '=', 'work_orders.vehicle_id')
                    ->leftJoin('employees', 'employees.id', '=', 'work_orders.mechanic_id')
                    ->where('work_orders.status', $status)
                    ->latest('work_orders.created_at')
                    ->limit(50)
                    ->get([
                        'work_orders.id',
                        'work_orders.work_order_number',
                        'work_orders.status',
                        'work_orders.complaint',
                        'work_orders.created_at',
                        'work_orders.completed_at',
                        'customers.name as customer_name',
                        'vehicles.license_plate',
                        'vehicles.brand as vehicle_brand',
                        'vehicles.model as vehicle_model',
                        'employees.name as mechanic_name',
                    ]);
            }

            return compact('statusCounts', 'ordersByStatus');
        });

        return view('tenant.antrean', [
            'tenantName' => $tenant->getAttribute('tenant_name'),
            ...$data,
        ]);
    }

    public function pos(): View
    {
        $tenant = $this->currentTenant();

        $data = $tenant->run(fn (): array => [
            'parts' => DB::table('spare_parts')
                ->where('is_active', true)
                ->orderBy('name')
                ->limit(100)
                ->get(['id', 'sku', 'name', 'stock', 'price', 'unit']),
            'services' => DB::table('service_catalog')
                ->where('is_active', true)
                ->orderBy('name')
                ->limit(100)
                ->get(['id', 'service_code', 'name', 'price', 'estimated_duration_minutes']),
            'customers' => DB::table('customers')
                ->orderBy('name')
                ->limit(100)
                ->get(['id', 'name', 'phone']),
            'recentSales' => DB::table('sales')
                ->leftJoin('customers', 'customers.id', '=', 'sales.customer_id')
                ->latest('sales.created_at')
                ->limit(10)
                ->get([
                    'sales.invoice_number',
                    'sales.status',
                    'sales.total',
                    'sales.sold_at',
                    'customers.name as customer_name',
                ]),
        ]);

        return view('tenant.kasir', [
            'tenantName' => $tenant->getAttribute('tenant_name'),
            ...$data,
        ]);
    }

    public function checkout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => ['nullable', 'integer'],
            'payment_method' => ['required', Rule::in(['cash', 'transfer', 'qris'])],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            'parts' => ['nullable', 'array', 'max:40'],
            'parts.*' => ['integer'],
            'part_quantities' => ['nullable', 'array'],
            'part_quantities.*' => ['integer', 'between:1,1000'],
            'services' => ['nullable', 'array', 'max:40'],
            'services.*' => ['integer'],
        ]);
        $tenant = $this->currentTenant();

        $invoiceNumber = $tenant->run(function () use ($validated, $request): string {
            return DB::transaction(function () use ($validated, $request): string {
                $selectedParts = [];
                foreach ($validated['parts'] ?? [] as $partId) {
                    $selectedParts[$partId] = ($selectedParts[$partId] ?? 0)
                        + (int) ($validated['part_quantities'][(string) $partId] ?? 1);
                }
                $selectedServices = array_unique($validated['services'] ?? []);

                if ($selectedParts === [] && $selectedServices === []) {
                    throw ValidationException::withMessages([
                        'parts' => 'Pilih minimal satu sparepart atau jasa servis.',
                    ]);
                }

                $customerId = $validated['customer_id'] ?? null;
                if ($customerId !== null && ! DB::table('customers')->where('id', $customerId)->exists()) {
                    throw ValidationException::withMessages([
                        'customer_id' => 'Pelanggan tidak ditemukan di bengkel ini.',
                    ]);
                }

                $lineItems = [];
                foreach ($selectedParts as $partId => $quantity) {
                    $part = DB::table('spare_parts')
                        ->where('id', $partId)
                        ->where('is_active', true)
                        ->lockForUpdate()
                        ->first();

                    if ($part === null || (int) $part->stock < $quantity) {
                        throw ValidationException::withMessages([
                            'parts' => 'Sparepart tidak tersedia atau stoknya tidak mencukupi.',
                        ]);
                    }

                    $lineItems[] = [
                        'type' => 'part',
                        'id' => $part->id,
                        'name' => $part->name,
                        'sku' => $part->sku,
                        'quantity' => $quantity,
                        'unit_price' => (float) $part->price,
                    ];
                }

                foreach ($selectedServices as $serviceId) {
                    $service = DB::table('service_catalog')
                        ->where('id', $serviceId)
                        ->where('is_active', true)
                        ->first();

                    if ($service === null) {
                        throw ValidationException::withMessages([
                            'services' => 'Jasa servis yang dipilih tidak tersedia.',
                        ]);
                    }

                    $lineItems[] = [
                        'type' => 'service',
                        'id' => $service->id,
                        'name' => $service->name,
                        'sku' => $service->service_code,
                        'quantity' => 1,
                        'unit_price' => (float) $service->price,
                    ];
                }

                $total = round(array_sum(array_map(
                    fn (array $item): float => $item['unit_price'] * $item['quantity'],
                    $lineItems,
                )), 2);
                $amountPaid = round((float) $validated['amount_paid'], 2);

                if ($amountPaid < $total
                    || ($validated['payment_method'] !== 'cash' && $amountPaid !== $total)) {
                    throw ValidationException::withMessages([
                        'amount_paid' => $validated['payment_method'] === 'cash'
                            ? 'Jumlah pembayaran tunai kurang dari total transaksi.'
                            : 'Untuk transfer dan QRIS, jumlah pembayaran harus sama dengan total transaksi.',
                    ]);
                }

                $now = now();
                $invoiceNumber = 'INV-'.Str::upper((string) Str::ulid());
                $saleId = DB::table('sales')->insertGetId([
                    'invoice_number' => $invoiceNumber,
                    'customer_id' => $customerId,
                    'status' => 'completed',
                    'subtotal' => $total,
                    'discount' => 0,
                    'tax' => 0,
                    'total' => $total,
                    'amount_paid' => $amountPaid,
                    'change_due' => round($amountPaid - $total, 2),
                    'sold_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                foreach ($lineItems as $item) {
                    DB::table('sale_items')->insert([
                        'sale_id' => $saleId,
                        'spare_part_id' => $item['type'] === 'part' ? $item['id'] : null,
                        'service_id' => $item['type'] === 'service' ? $item['id'] : null,
                        'item_name' => $item['name'],
                        'sku' => $item['sku'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'discount' => 0,
                        'subtotal' => round($item['unit_price'] * $item['quantity'], 2),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    if ($item['type'] === 'part') {
                        $stockBefore = (int) DB::table('spare_parts')
                            ->where('id', $item['id'])
                            ->value('stock');
                        $stockAfter = $stockBefore - $item['quantity'];
                        DB::table('spare_parts')->where('id', $item['id'])->update([
                            'stock' => $stockAfter,
                            'updated_at' => $now,
                        ]);
                        DB::table('inventory_movements')->insert([
                            'spare_part_id' => $item['id'],
                            'movement_type' => 'sale',
                            'quantity' => $item['quantity'],
                            'stock_before' => $stockBefore,
                            'stock_after' => $stockAfter,
                            'reference_type' => 'sale',
                            'reference_id' => $saleId,
                            'central_user_id' => $request->user()->id,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }

                DB::table('payments')->insert([
                    'sale_id' => $saleId,
                    'payment_method' => $validated['payment_method'],
                    'amount' => $total,
                    'status' => 'completed',
                    'paid_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                return $invoiceNumber;
            });
        });

        return redirect()->route('owner.kasir')->with('success', "Transaksi {$invoiceNumber} berhasil dicatat.");
    }

    public function stock(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $search = trim($validated['search'] ?? '');
        $tenant = $this->currentTenant();

        $data = $tenant->run(function () use ($search): array {
            $parts = DB::table('spare_parts')
                ->when($search !== '', function (Builder $query) use ($search): void {
                    $query->where(function (Builder $query) use ($search): void {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('sku', 'like', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(20)
                ->withQueryString();

            return [
                'parts' => $parts,
                'totalParts' => DB::table('spare_parts')->count(),
                'lowStockCount' => DB::table('spare_parts')
                    ->whereColumn('stock', '<=', 'minimum_stock')
                    ->where('stock', '>', 0)
                    ->count(),
                'outOfStockCount' => DB::table('spare_parts')->where('stock', '<=', 0)->count(),
                'stockValue' => DB::table('spare_parts')->sum(DB::raw('stock * price')),
            ];
        });

        return view('tenant.stok', [
            'tenantName' => $tenant->getAttribute('tenant_name'),
            'search' => $search,
            ...$data,
        ]);
    }

    public function people(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $search = trim($validated['search'] ?? '');
        $tenant = $this->currentTenant();

        $data = $tenant->run(function () use ($search): array {
            $customers = DB::table('customers')
                ->when($search !== '', function (Builder $query) use ($search): void {
                    $query->where(function (Builder $query) use ($search): void {
                        $query->where('customers.name', 'like', "%{$search}%")
                            ->orWhere('customers.phone', 'like', "%{$search}%")
                            ->orWhereIn('customers.id', DB::table('vehicles')
                                ->select('customer_id')
                                ->where('license_plate', 'like', "%{$search}%"));
                    });
                })
                ->addSelect([
                    'customers.id',
                    'customers.name',
                    'customers.phone',
                    'vehicles_count' => DB::table('vehicles')
                        ->selectRaw('COUNT(*)')
                        ->whereColumn('vehicles.customer_id', 'customers.id'),
                ])
                ->latest('customers.id')
                ->paginate(20)
                ->withQueryString();

            return [
                'customers' => $customers,
                'customerCount' => DB::table('customers')->count(),
                'completedWorkOrderCount' => DB::table('work_orders')
                    ->where('status', 'completed')
                    ->count(),
                'completedServiceRevenue' => DB::table('work_order_services')
                    ->join('work_orders', 'work_orders.id', '=', 'work_order_services.work_order_id')
                    ->where('work_orders.status', 'completed')
                    ->sum('work_order_services.subtotal'),
                'mechanics' => DB::table('employees')
                    ->where('status', 'active')
                    ->orderBy('name')
                    ->paginate(20, ['*'], 'mechanics_page'),
                'mechanicCount' => DB::table('employees')->where('status', 'active')->count(),
            ];
        });

        return view('tenant.mekanik', [
            'tenantName' => $tenant->getAttribute('tenant_name'),
            'search' => $search,
            ...$data,
        ]);
    }

    public function reminders(): View
    {
        $tenant = $this->currentTenant();

        $data = $tenant->run(function (): array {
            $today = now()->toDateString();
            $nextWeek = now()->addDays(7)->toDateString();

            return [
                'overdueCount' => DB::table('service_reminders')
                    ->where('status', 'pending')
                    ->whereDate('due_date', '<=', $today)
                    ->count(),
                'upcomingCount' => DB::table('service_reminders')
                    ->where('status', 'pending')
                    ->whereDate('due_date', '>', $today)
                    ->whereDate('due_date', '<=', $nextWeek)
                    ->count(),
                'sentCount' => DB::table('service_reminders')
                    ->whereNotNull('sent_at')
                    ->count(),
                'customers' => DB::table('customers')
                    ->orderBy('name')
                    ->limit(200)
                    ->get(['id', 'name', 'phone']),
                'vehicles' => DB::table('vehicles')
                    ->join('customers', 'customers.id', '=', 'vehicles.customer_id')
                    ->orderBy('customers.name')
                    ->limit(200)
                    ->get([
                        'vehicles.id',
                        'vehicles.customer_id',
                        'vehicles.license_plate',
                        'vehicles.brand',
                        'vehicles.model',
                        'customers.name as customer_name',
                    ]),
                'reminders' => DB::table('service_reminders')
                    ->join('customers', 'customers.id', '=', 'service_reminders.customer_id')
                    ->leftJoin('vehicles', 'vehicles.id', '=', 'service_reminders.vehicle_id')
                    ->orderBy('service_reminders.due_date')
                    ->paginate(20, [
                        'service_reminders.id',
                        'service_reminders.due_date',
                        'service_reminders.status',
                        'service_reminders.message',
                        'service_reminders.sent_at',
                        'customers.name as customer_name',
                        'customers.phone as customer_phone',
                        'vehicles.brand as vehicle_brand',
                        'vehicles.model as vehicle_model',
                        'vehicles.license_plate',
                    ]),
            ];
        });

        return view('tenant.pengingat', [
            'tenantName' => $tenant->getAttribute('tenant_name'),
            ...$data,
        ]);
    }

    public function storeEmployee(Request $request): RedirectResponse
    {
        $tenant = $this->currentTenant();
        $tenant->run(function () use ($request): void {
            $validated = $request->validate([
                'employee_code' => ['nullable', 'string', 'max:255', Rule::unique('employees', 'employee_code')],
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['nullable', 'string', 'max:30'],
                'email' => ['nullable', 'email', 'max:255'],
                'position' => ['required', 'string', 'max:100'],
                'specialization' => ['nullable', 'string', 'max:255'],
            ]);

            DB::table('employees')->insert([
                ...$validated,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('owner.mekanik')->with('success', 'Data mekanik berhasil ditambahkan.');
    }

    public function storeReminder(Request $request): RedirectResponse
    {
        $tenant = $this->currentTenant();
        $tenant->run(function () use ($request): void {
            $validated = $request->validate([
                'customer_id' => ['required', 'integer', Rule::exists('customers', 'id')],
                'vehicle_id' => ['nullable', 'integer', Rule::exists('vehicles', 'id')],
                'due_date' => ['required', 'date', 'after_or_equal:today'],
                'message' => ['nullable', 'string', 'max:2000'],
            ]);

            if (! empty($validated['vehicle_id'])
                && ! DB::table('vehicles')
                    ->where('id', $validated['vehicle_id'])
                    ->where('customer_id', $validated['customer_id'])
                    ->exists()) {
                throw ValidationException::withMessages([
                    'vehicle_id' => 'Kendaraan yang dipilih bukan milik pelanggan tersebut.',
                ]);
            }

            DB::table('service_reminders')->insert([
                'customer_id' => $validated['customer_id'],
                'vehicle_id' => $validated['vehicle_id'] ?? null,
                'due_date' => $validated['due_date'],
                'channel' => 'whatsapp',
                'status' => 'pending',
                'message' => $validated['message'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('owner.pengingat')
            ->with('success', 'Pengingat berhasil dijadwalkan. Pesan belum dikirim otomatis.');
    }

    public function storePart(Request $request): RedirectResponse
    {
        $tenant = $this->currentTenant();
        $request->merge(['sku' => Str::upper(trim((string) $request->input('sku', '')))]);
        $validated = $tenant->run(fn (): array => $request->validate([
            'sku' => ['required', 'string', 'max:255', Rule::unique('spare_parts', 'sku')],
            'name' => ['required', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'category' => ['nullable', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:50'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
        ]));

        $tenant->run(function () use ($validated, $request): void {
            DB::transaction(function () use ($validated, $request): void {
                $stock = (int) $validated['stock'];
                $partId = DB::table('spare_parts')->insertGetId([
                    'sku' => Str::upper(trim($validated['sku'])),
                    'name' => trim($validated['name']),
                    'stock' => $stock,
                    'price' => $validated['price'],
                    'category' => $validated['category'] ?? null,
                    'unit' => $validated['unit'],
                    'minimum_stock' => $validated['minimum_stock'],
                    'location' => $validated['location'] ?? null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($stock > 0) {
                    DB::table('inventory_movements')->insert([
                        'spare_part_id' => $partId,
                        'movement_type' => 'initial_stock',
                        'quantity' => $stock,
                        'stock_before' => 0,
                        'stock_after' => $stock,
                        'central_user_id' => $request->user()->id,
                        'notes' => 'Stok awal saat barang ditambahkan.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
        });

        return redirect()->route('owner.stok')->with('success', 'Sparepart berhasil ditambahkan.');
    }

    public function adjustPartStock(Request $request, int $partId): RedirectResponse
    {
        $validated = $request->validate([
            'adjustment' => ['required', 'integer', 'between:-100000,100000', 'not_in:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
        $tenant = $this->currentTenant();

        $tenant->run(function () use ($validated, $partId, $request): void {
            DB::transaction(function () use ($validated, $partId, $request): void {
                $part = DB::table('spare_parts')->where('id', $partId)->lockForUpdate()->first();
                abort_if($part === null, 404);

                $stockBefore = (int) $part->stock;
                $stockAfter = $stockBefore + (int) $validated['adjustment'];
                if ($stockAfter < 0) {
                    throw ValidationException::withMessages([
                        'adjustment' => 'Penyesuaian stok tidak boleh membuat stok menjadi negatif.',
                    ]);
                }

                DB::table('spare_parts')->where('id', $partId)->update([
                    'stock' => $stockAfter,
                    'updated_at' => now(),
                ]);
                DB::table('inventory_movements')->insert([
                    'spare_part_id' => $partId,
                    'movement_type' => $validated['adjustment'] > 0 ? 'stock_in' : 'stock_out',
                    'quantity' => abs((int) $validated['adjustment']),
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'central_user_id' => $request->user()->id,
                    'notes' => $validated['notes'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
        });

        return redirect()->route('owner.stok')->with('success', 'Stok sparepart berhasil diperbarui.');
    }

    public function updateWorkOrderStatus(Request $request, int $workOrderId): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['in_progress', 'completed'])],
        ]);
        $tenant = $this->currentTenant();

        $tenant->run(function () use ($validated, $workOrderId): void {
            DB::transaction(function () use ($validated, $workOrderId): void {
                $workOrder = DB::table('work_orders')
                    ->where('id', $workOrderId)
                    ->lockForUpdate()
                    ->first();
                abort_if($workOrder === null, 404);

                $validTransition = ($workOrder->status === 'waiting' && $validated['status'] === 'in_progress')
                    || ($workOrder->status === 'in_progress' && $validated['status'] === 'completed');
                if (! $validTransition) {
                    throw ValidationException::withMessages([
                        'status' => 'Status antrean tidak dapat diubah dari kondisi saat ini.',
                    ]);
                }

                $timestamps = ['updated_at' => now()];
                if ($validated['status'] === 'in_progress') {
                    $timestamps['started_at'] = now();
                } else {
                    $timestamps['completed_at'] = now();
                }

                DB::table('work_orders')->where('id', $workOrderId)->update([
                    'status' => $validated['status'],
                    ...$timestamps,
                ]);
            });
        });

        return redirect()->route('owner.antrean')->with('success', 'Status antrean berhasil diperbarui.');
    }

    private function currentTenant(): Tenant
    {
        return Tenant::query()->findOrFail(auth()->user()->tenant_id);
    }
}
