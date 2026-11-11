<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TenantModerationController extends Controller
{
    public function updateStatus(Request $request, Tenant $tenant): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['active', 'inactive', 'banned'])],
            'status_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $tenant->setAttribute('status', $validated['status']);
        $tenant->setAttribute('status_reason', $validated['status_reason'] ?? null);
        $tenant->save();

        return redirect()->route('superadmin.tenant')->with('success', 'Status tenant berhasil diperbarui.');
    }

    public function destroy(Request $request, Tenant $tenant): RedirectResponse
    {
        $validated = $request->validate([
            'confirmation' => [
                'required',
                'string',
                Rule::in([(string) $tenant->getAttribute('tenant_name')]),
            ],
        ], [
            'confirmation.in' => 'Ketik nama bengkel dengan tepat untuk menghapus tenant.',
        ]);

        DB::transaction(function () use ($tenant): void {
            User::query()
                ->where('tenant_id', $tenant->getTenantKey())
                ->update([
                    'role' => 'Pelanggan',
                    'tenant_id' => null,
                ]);

            $tenant->delete();
        });

        return redirect()->route('superadmin.tenant')->with('success', 'Tenant dan database operasionalnya berhasil dihapus.');
    }
}
