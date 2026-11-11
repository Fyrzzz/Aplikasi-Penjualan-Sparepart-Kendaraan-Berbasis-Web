<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Stancl\Tenancy\Events\TenantCreated;
use Stancl\Tenancy\Events\TenantDeleted;
use Tests\TestCase;

class SuperAdminManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_admin_profile_and_does_not_show_unmeasured_sample_metrics(): void
    {
        $admin = User::factory()->create([
            'username' => 'adminutama',
            'name' => 'Admin Utama',
            'role' => 'Super Admin',
        ]);

        $this->actingAs($admin)
            ->get(route('superadmin.home'))
            ->assertOk()
            ->assertSee('Admin Utama')
            ->assertSee(route('superadmin.profile.edit'))
            ->assertSee('Rp 0')
            ->assertSee('0 nota selesai')
            ->assertDontSee('Rp 5.378.000')
            ->assertDontSee('142 Nota')
            ->assertDontSee('99.9%')
            ->assertSee('Pemantauan uptime belum dikonfigurasi.');
    }

    public function test_superadmin_can_edit_own_profile_and_password(): void
    {
        $admin = User::factory()->create([
            'username' => 'adminlama',
            'name' => 'Admin Lama',
            'email' => 'adminlama@example.com',
            'password' => 'password123',
            'role' => 'Super Admin',
        ]);

        $this->actingAs($admin)
            ->get(route('superadmin.profile.edit'))
            ->assertOk()
            ->assertSee('Admin Lama');

        $this->patch(route('superadmin.profile.update'), [
            'username' => 'adminbaru',
            'name' => 'Admin Baru',
            'email' => 'adminbaru@example.com',
            'phone' => '08123456789',
            'current_password' => 'password123',
            'password' => 'new-password123',
            'password_confirmation' => 'new-password123',
        ])->assertRedirect(route('superadmin.profile.edit'));

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'username' => 'adminbaru',
            'name' => 'Admin Baru',
            'email' => 'adminbaru@example.com',
            'phone' => '08123456789',
            'role' => 'Super Admin',
        ]);
        $this->assertTrue(Hash::check('new-password123', $admin->fresh()->password));
    }

    public function test_non_admin_cannot_edit_superadmin_profile(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'Pelanggan']))
            ->get(route('superadmin.profile.edit'))
            ->assertForbidden();
    }

    public function test_superadmin_can_change_tenant_status_and_inactive_tenants_are_hidden_and_blocked(): void
    {
        Event::fake([TenantCreated::class]);
        $tenant = Tenant::create([
            'tenant_name' => 'Bengkel Moderasi',
            'package' => 'starter',
        ]);
        $owner = User::factory()->create([
            'role' => 'Owner',
            'tenant_id' => $tenant->getTenantKey(),
            'password' => 'password123',
        ]);
        $admin = User::factory()->create(['role' => 'Super Admin']);

        $this->actingAs($admin)
            ->patch(route('superadmin.tenant.status', $tenant), [
                'status' => 'banned',
                'status_reason' => 'Pelanggaran aturan',
            ])
            ->assertRedirect(route('superadmin.tenant'))
            ->assertSessionHas('success');

        $this->assertSame('banned', $tenant->fresh()->getAttribute('status'));
        $this->assertSame('Pelanggaran aturan', $tenant->fresh()->getAttribute('status_reason'));
        $this->actingAs(User::factory()->create(['role' => 'Pelanggan']))
            ->get(route('user.menu'))
            ->assertDontSee('Bengkel Moderasi');
        $this->actingAs($owner)
            ->get(route('user.menu'))
            ->assertOk()
            ->assertSee('Tenant tidak aktif')
            ->assertDontSee(route('owner.home'));
        $this->actingAs($owner)
            ->get(route('owner.home'))
            ->assertForbidden();
        $this->post(route('tenant.login.proses'), [
            'email' => $owner->email,
            'password' => 'password123',
        ])->assertSessionHasErrors('email');

        $this->actingAs($admin)
            ->patch(route('superadmin.tenant.status', $tenant), [
                'status' => 'active',
            ])
            ->assertRedirect(route('superadmin.tenant'));

        $this->assertSame('active', $tenant->fresh()->getAttribute('status'));
        $this->actingAs($owner)
            ->get(route('user.menu'))
            ->assertOk()
            ->assertSee(route('owner.home'));
    }

    public function test_permanent_tenant_deletion_requires_name_confirmation_and_unlinks_users(): void
    {
        Event::fake([TenantCreated::class, TenantDeleted::class]);
        $tenant = Tenant::create([
            'tenant_name' => 'Bengkel Hapus',
            'package' => 'starter',
        ]);
        $owner = User::factory()->create([
            'role' => 'Owner',
            'tenant_id' => $tenant->getTenantKey(),
        ]);
        $admin = User::factory()->create(['role' => 'Super Admin']);

        $this->actingAs($admin)
            ->delete(route('superadmin.tenant.destroy', $tenant), [
                'confirmation' => 'Nama Salah',
            ])
            ->assertSessionHasErrors('confirmation');

        $this->assertModelExists($tenant->fresh());

        $this->delete(route('superadmin.tenant.destroy', $tenant), [
            'confirmation' => 'Bengkel Hapus',
        ])->assertRedirect(route('superadmin.tenant'));

        $this->assertDatabaseMissing('tenants', ['id' => $tenant->getTenantKey()]);
        $this->assertDatabaseHas('users', [
            'id' => $owner->id,
            'role' => 'Pelanggan',
            'tenant_id' => null,
        ]);
        Event::assertDispatched(TenantDeleted::class);
    }

    public function test_package_distribution_uses_current_tenant_records_and_statuses(): void
    {
        Event::fake([TenantCreated::class]);
        $activeTenant = Tenant::create([
            'tenant_name' => 'Starter Aktif',
            'package' => 'starter',
            'status' => 'active',
        ]);
        User::factory()->create([
            'role' => 'Owner',
            'tenant_id' => $activeTenant->getTenantKey(),
        ]);
        Tenant::create([
            'tenant_name' => 'Starter Nonaktif',
            'package' => 'starter',
            'status' => 'inactive',
        ]);
        Tenant::create([
            'tenant_name' => 'Pro Diblokir',
            'package' => 'pro',
            'status' => 'banned',
        ]);
        $this->assertSame('active', $activeTenant->fresh()->getAttribute('status'));
        $this->assertTrue($activeTenant->fresh()->isActive());

        $this->actingAs(User::factory()->create(['role' => 'Super Admin']))
            ->get(route('superadmin.paket'))
            ->assertOk()
            ->assertSee('Distribusi Tenant dan Akun Tenant')
            ->assertSee('Rp 99.000')
            ->assertSee('1')
            ->assertDontSee('8 Bengkel')
            ->assertDontSee('12 Bengkel')
            ->assertDontSee('2 Bengkel')
            ->assertViewHas('packageDistribution', function (array $distribution): bool {
                return $distribution['starter']['active_tenant_count'] === 1
                    && $distribution['starter']['active_user_count'] === 1
                    && $distribution['starter']['inactive_tenant_count'] === 1
                    && $distribution['pro']['active_tenant_count'] === 0
                    && $distribution['pro']['inactive_tenant_count'] === 1;
            });
    }

    public function test_dashboard_and_financial_report_aggregate_real_monthly_tenant_data(): void
    {
        $this->travelTo(new \DateTimeImmutable('2026-11-09T08:30:00+07:00'));
        $tenant = Tenant::create([
            'tenant_name' => 'Bengkel Laporan Aktual',
            'package' => 'starter',
        ]);

        try {
            $tenant->run(function (): void {
                $customerId = DB::table('customers')->insertGetId([
                    'name' => 'Pelanggan Laporan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $vehicleId = DB::table('vehicles')->insertGetId([
                    'customer_id' => $customerId,
                    'license_plate' => 'B 1234 TEST',
                    'brand' => 'Honda',
                    'model' => 'Beat',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('work_orders')->insert([
                    'work_order_number' => 'WO-LAPORAN-001',
                    'customer_id' => $customerId,
                    'vehicle_id' => $vehicleId,
                    'status' => 'completed',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('sales')->insert([
                    'invoice_number' => 'INV-LAPORAN-001',
                    'status' => 'completed',
                    'total' => 275000,
                    'sold_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

            $admin = User::factory()->create(['role' => 'Super Admin']);
            $this->actingAs($admin)
                ->get(route('superadmin.home'))
                ->assertOk()
                ->assertSee('Rp 275.000')
                ->assertSee('1 nota selesai')
                ->assertSee('1 Servis');

            $this->get(route('superadmin.laporan'))
                ->assertOk()
                ->assertSee('Bengkel Laporan Aktual')
                ->assertSee('Rp 275.000')
                ->assertSee('WO-LAPORAN-001')
                ->assertDontSee('BENGKEL MAJU JAYA')
                ->assertDontSee('Agus Supriyadi');
        } finally {
            $tenant->delete();
        }
    }
}
