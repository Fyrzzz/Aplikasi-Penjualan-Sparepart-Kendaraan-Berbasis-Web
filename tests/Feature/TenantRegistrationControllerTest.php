<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Stancl\Tenancy\Events\TenantCreated;
use Tests\TestCase;

class TenantRegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_main_account_registration_does_not_create_a_tenant(): void
    {
        $this->post(route('register.proses'), [
            'username' => 'akunutama',
            'name' => 'Pengguna Utama',
            'contact' => 'utama@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('user.menu'));

        $this->assertAuthenticated();
        $this->assertDatabaseCount('tenants', 0);
        $this->assertDatabaseHas('users', [
            'username' => 'akunutama',
            'role' => 'Pelanggan',
            'tenant_id' => null,
        ]);
        $this->get(route('user.menu'))
            ->assertOk()
            ->assertSee(route('tenant.create'));
    }

    public function test_authenticated_main_account_can_create_a_tenant_and_becomes_its_owner(): void
    {
        Event::fake([TenantCreated::class]);
        $customer = User::factory()->create([
            'name' => 'Pemilik Akun',
            'phone' => '08123456789',
            'role' => 'Pelanggan',
            'password' => 'password123',
        ]);
        $this->actingAs($customer);

        $this->get(route('tenant.create'))
            ->assertOk()
            ->assertSee('Daftarkan Tenant Bengkel')
            ->assertSee('Pemilik Akun');
        $this->post(route('tenant.store'), [
            'tenant_name' => 'Bengkel Utama',
            'subdomain' => 'bengkel-utama',
            'package' => 'starter',
        ])->assertRedirect(route('owner.home'));

        $tenant = Tenant::query()->firstOrFail();
        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'role' => 'Owner',
            'tenant_id' => $tenant->getTenantKey(),
        ]);
        $this->assertDatabaseHas('domains', [
            'domain' => 'bengkel-utama.autozone.pro',
            'tenant_id' => $tenant->getTenantKey(),
        ]);
        $this->assertAuthenticatedAs($customer->fresh());
        $this->get(route('tenant.create'))->assertRedirect(route('owner.home'));
        $this->post(route('tenant.store'), [
            'tenant_name' => 'Bengkel Kedua',
            'subdomain' => 'bengkel-kedua',
            'package' => 'starter',
        ])->assertRedirect(route('owner.home'));
        $this->assertDatabaseCount('tenants', 1);
        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->post(route('login.proses'), [
            'email' => $customer->email,
            'password' => 'password123',
            'role' => 'user',
        ])->assertRedirect(route('user.menu'));
        $this->assertAuthenticatedAs($customer->fresh());
        Event::assertDispatched(TenantCreated::class);
    }

    public function test_guest_cannot_open_or_submit_tenant_creation(): void
    {
        $this->get(route('tenant.create'))->assertRedirect(route('login'));
        $this->post(route('tenant.store'), [
            'tenant_name' => 'Bengkel Tamu',
            'subdomain' => 'bengkel-tamu',
            'package' => 'starter',
        ])->assertRedirect(route('login'));

        $this->assertDatabaseCount('tenants', 0);
    }

    public function test_existing_tenant_owner_is_redirected_to_the_dashboard_instead_of_creating_another_tenant(): void
    {
        Event::fake([TenantCreated::class]);
        $tenant = Tenant::create([
            'tenant_name' => 'Toko Sudah Ada',
            'package' => 'starter',
        ]);
        $owner = User::factory()->create([
            'role' => 'Owner',
            'tenant_id' => $tenant->getTenantKey(),
        ]);

        $this->actingAs($owner);
        $this->get(route('tenant.create'))->assertRedirect(route('owner.home'));
        $this->post(route('tenant.store'), [
            'tenant_name' => 'Bengkel Kedua',
            'subdomain' => 'bengkel-kedua',
            'package' => 'starter',
        ])
            ->assertRedirect(route('owner.home'));

        $this->assertDatabaseCount('tenants', 1);
        $this->assertDatabaseHas('users', [
            'id' => $owner->id,
            'role' => 'Owner',
            'tenant_id' => $tenant->getTenantKey(),
        ]);
    }

    public function test_duplicate_subdomain_does_not_promote_the_main_account(): void
    {
        Event::fake([TenantCreated::class]);
        $existingTenant = Tenant::create([
            'tenant_name' => 'Tenant Awal',
            'package' => 'starter',
        ]);
        $existingTenant->createDomain('bengkel-terpakai.autozone.pro');
        $customer = User::factory()->create(['role' => 'Pelanggan']);

        $this->actingAs($customer)
            ->post(route('tenant.store'), [
                'tenant_name' => 'Tenant Baru',
                'subdomain' => 'bengkel-terpakai',
                'package' => 'starter',
            ])
            ->assertSessionHasErrors('subdomain');

        $this->assertDatabaseCount('tenants', 1);
        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'role' => 'Pelanggan',
            'tenant_id' => null,
        ]);
    }
}
