<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use PDOException;

class TenantMetricsService
{
    private const PACKAGE_PRICES = [
        'starter' => 99000,
        'pro' => 249000,
        'enterprise' => 799000,
    ];

    public function monthlySummary(): array
    {
        $periodStart = CarbonImmutable::now()->startOfMonth();
        $nextPeriodStart = $periodStart->addMonth();
        $tenants = Tenant::query()->with(['domains', 'owner'])->latest()->get();
        $activeTenants = $tenants->filter(fn (Tenant $tenant): bool => $tenant->isActive());
        $rows = [];
        $unavailableTenantNames = [];

        foreach ($activeTenants as $tenant) {
            try {
                tenancy()->initialize($tenant);

                $metrics = [
                    'revenue' => (float) DB::table('sales')
                        ->where('status', 'completed')
                        ->where('sold_at', '>=', $periodStart)
                        ->where('sold_at', '<', $nextPeriodStart)
                        ->sum('total'),
                    'invoice_count' => DB::table('sales')
                        ->where('status', 'completed')
                        ->where('sold_at', '>=', $periodStart)
                        ->where('sold_at', '<', $nextPeriodStart)
                        ->count(),
                    'work_order_count' => DB::table('work_orders')
                        ->where('created_at', '>=', $periodStart)
                        ->where('created_at', '<', $nextPeriodStart)
                        ->count(),
                    'recent_work_orders' => DB::table('work_orders')
                        ->where('created_at', '>=', $periodStart)
                        ->where('created_at', '<', $nextPeriodStart)
                        ->latest('created_at')
                        ->limit(3)
                        ->pluck('work_order_number'),
                ];
            } catch (QueryException|PDOException $exception) {
                report($exception);
                $unavailableTenantNames[] = (string) $tenant->getAttribute('tenant_name');

                continue;
            } finally {
                if (tenancy()->initialized) {
                    tenancy()->end();
                }
            }

            $rows[] = [
                'tenant' => $tenant,
                ...$metrics,
            ];
        }

        return [
            'tenantCount' => $tenants->count(),
            'activeTenantCount' => $activeTenants->count(),
            'monthlyRevenue' => collect($rows)->sum('revenue'),
            'monthlyInvoiceCount' => collect($rows)->sum('invoice_count'),
            'monthlyWorkOrderCount' => collect($rows)->sum('work_order_count'),
            'estimatedMonthlySubscriptions' => $activeTenants->sum(
                fn (Tenant $tenant): int => self::PACKAGE_PRICES[(string) $tenant->getAttribute('package')] ?? 0,
            ),
            'monthLabel' => $periodStart->locale('id')->translatedFormat('F Y'),
            'unavailableTenantNames' => $unavailableTenantNames,
            'availableDatabaseCount' => count($rows),
            'recentTenants' => $tenants->take(3),
            'tenantReportRows' => collect($rows)->sortByDesc('revenue')->values(),
        ];
    }

    public function packageDistribution(): array
    {
        $tenants = Tenant::query()->get();
        $distribution = [];

        foreach ([
            'starter' => 'Starter',
            'pro' => 'Pro Tenant',
            'enterprise' => 'Enterprise',
        ] as $package => $label) {
            $packageTenants = $tenants->filter(
                fn (Tenant $tenant): bool => $tenant->getAttribute('package') === $package,
            );
            $activeTenants = $packageTenants->filter(fn (Tenant $tenant): bool => $tenant->isActive());
            $activeTenantIds = $activeTenants->map(fn (Tenant $tenant): string => (string) $tenant->getTenantKey());

            $distribution[$package] = [
                'package' => $package,
                'label' => $label,
                'active_tenant_count' => $activeTenants->count(),
                'inactive_tenant_count' => $packageTenants->count() - $activeTenants->count(),
                'active_user_count' => User::query()
                    ->whereIn('tenant_id', $activeTenantIds)
                    ->whereIn('role', ['Owner', 'Kasir', 'Mekanik'])
                    ->count(),
                'unit_price' => self::PACKAGE_PRICES[$package],
                'estimated_monthly_value' => $activeTenants->count() * self::PACKAGE_PRICES[$package],
            ];
        }

        return $distribution;
    }
}
