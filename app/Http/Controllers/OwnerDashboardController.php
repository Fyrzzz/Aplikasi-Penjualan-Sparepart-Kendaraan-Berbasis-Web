<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OwnerDashboardController extends Controller
{
    public function __invoke(): View
    {
        $tenant = Tenant::query()->findOrFail(auth()->user()->tenant_id);
        $tenantName = $tenant->getAttribute('tenant_name');

        $dashboard = $tenant->run(function (): array {
            $today = now()->toDateString();
            $weekStart = CarbonImmutable::today()->subDays(6);
            $weekEnd = CarbonImmutable::today();
            $weekStartDateTime = $weekStart->startOfDay()->toDateTimeString();
            $weekEndDateTime = $weekEnd->endOfDay()->toDateTimeString();

            $revenueByDay = DB::table('sales')
                ->where('status', 'completed')
                ->whereBetween('sold_at', [$weekStartDateTime, $weekEndDateTime])
                ->selectRaw('DATE(sold_at) as day, SUM(total) as revenue')
                ->groupByRaw('DATE(sold_at)')
                ->pluck('revenue', 'day');

            $workOrdersByDay = DB::table('work_orders')
                ->whereBetween('created_at', [$weekStartDateTime, $weekEndDateTime])
                ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
                ->groupByRaw('DATE(created_at)')
                ->pluck('total', 'day');

            $weeklyActivity = collect(range(0, 6))
                ->map(function (int $daysAgo) use ($weekEnd, $revenueByDay, $workOrdersByDay): array {
                    $date = $weekEnd->subDays(6 - $daysAgo)->toDateString();

                    return [
                        'date' => $date,
                        'label' => CarbonImmutable::parse($date)->translatedFormat('D'),
                        'revenue' => (float) ($revenueByDay[$date] ?? 0),
                        'work_orders' => (int) ($workOrdersByDay[$date] ?? 0),
                    ];
                });

            return [
                'revenueToday' => (float) DB::table('sales')
                    ->where('status', 'completed')
                    ->whereDate('sold_at', $today)
                    ->sum('total'),
                'workOrdersToday' => DB::table('work_orders')
                    ->whereDate('created_at', $today)
                    ->count(),
                'activeWorkOrdersCount' => DB::table('work_orders')
                    ->whereIn('status', ['waiting', 'in_progress'])
                    ->count(),
                'remindersSentToday' => DB::table('service_reminders')
                    ->whereNotNull('sent_at')
                    ->whereDate('sent_at', $today)
                    ->count(),
                'pendingRemindersCount' => DB::table('service_reminders')
                    ->where('status', 'pending')
                    ->whereDate('due_date', '<=', $today)
                    ->count(),
                'criticalParts' => DB::table('spare_parts')
                    ->where('is_active', true)
                    ->whereColumn('stock', '<=', 'minimum_stock')
                    ->orderBy('stock')
                    ->limit(5)
                    ->get(['name', 'stock', 'minimum_stock', 'unit']),
                'pendingReminders' => DB::table('service_reminders')
                    ->leftJoin('customers', 'customers.id', '=', 'service_reminders.customer_id')
                    ->leftJoin('vehicles', 'vehicles.id', '=', 'service_reminders.vehicle_id')
                    ->where('service_reminders.status', 'pending')
                    ->whereDate('service_reminders.due_date', '<=', $today)
                    ->orderBy('service_reminders.due_date')
                    ->limit(3)
                    ->get([
                        'customers.name as customer_name',
                        'vehicles.brand as vehicle_brand',
                        'vehicles.model as vehicle_model',
                        'service_reminders.due_date',
                        'service_reminders.message',
                    ]),
                'activeWorkOrders' => DB::table('work_orders')
                    ->join('customers', 'customers.id', '=', 'work_orders.customer_id')
                    ->join('vehicles', 'vehicles.id', '=', 'work_orders.vehicle_id')
                    ->leftJoin('employees', 'employees.id', '=', 'work_orders.mechanic_id')
                    ->whereIn('work_orders.status', ['waiting', 'in_progress'])
                    ->orderBy('work_orders.created_at')
                    ->limit(5)
                    ->get([
                        'work_orders.work_order_number',
                        'work_orders.status',
                        'work_orders.complaint',
                        'customers.name as customer_name',
                        'vehicles.license_plate',
                        'vehicles.brand as vehicle_brand',
                        'vehicles.model as vehicle_model',
                        'employees.name as mechanic_name',
                    ]),
                'weeklyActivity' => $weeklyActivity,
            ];
        });

        return view('tenant.dashboard', [
            'tenantName' => $tenantName,
            ...$dashboard,
        ]);
    }
}
