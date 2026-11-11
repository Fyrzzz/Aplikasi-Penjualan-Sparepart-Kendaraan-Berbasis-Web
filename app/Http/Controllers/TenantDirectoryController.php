<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Services\TenantMetricsService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantDirectoryController extends Controller
{
    public function consumerIndex(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $search = trim($validated['search'] ?? '');

        $tenants = Tenant::query()
            ->where(function (Builder $query): void {
                $query->whereNull('data->status')
                    ->orWhere('data->status', 'active');
            })
            ->with(['domains', 'owner'])
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('data->tenant_name', 'like', "%{$search}%")
                        ->orWhereHas('domains', function (Builder $domainQuery) use ($search): void {
                            $domainQuery->where('domain', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();
        $accountTenant = $request->user()->tenant_id === null
            ? null
            : Tenant::query()->find($request->user()->tenant_id);

        return view('bengkel.user-menu', compact('tenants', 'search', 'accountTenant'));
    }

    public function adminIndex(): View
    {
        $tenants = Tenant::query()
            ->with(['domains', 'owner'])
            ->latest()
            ->paginate(15);

        return view('superadmin.dashboardsuperadmin', compact('tenants'));
    }

    public function adminDashboard(TenantMetricsService $metrics): View
    {
        $summary = $metrics->monthlySummary();

        return view('superadmin.dashboard-global', $summary);
    }

    public function adminReport(TenantMetricsService $metrics): View
    {
        return view('superadmin.laporan', $metrics->monthlySummary());
    }

    public function adminPackages(TenantMetricsService $metrics): View
    {
        return view('superadmin.paket', [
            'packageDistribution' => $metrics->packageDistribution(),
        ]);
    }
}
