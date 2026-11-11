<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenantId = $request->user()?->tenant_id;
        $tenant = $tenantId === null ? null : Tenant::query()->find($tenantId);

        abort_unless($tenant?->isActive(), 403, 'Akses tenant ini sedang dinonaktifkan.');

        return $next($request);
    }
}
