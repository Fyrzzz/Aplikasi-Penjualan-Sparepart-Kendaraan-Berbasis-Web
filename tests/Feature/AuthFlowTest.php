<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Stancl\Tenancy\Events\TenantCreated;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_creation_requires_a_main_account_and_converts_it_to_the_owner_account(): void
    {
        Event::fake([TenantCreated::class]);

        $this->post(route('tenant.store'), [
            'tenant_name' => 'Bengkel Satu',
            'subdomain' => 'bengkel-satu',
            'package' => 'starter',
        ])->assertRedirect(route('login'));
        $this->assertDatabaseCount('tenants', 0);

        $this->post(route('register.proses'), [
            'username' => 'pemilik_satu',
            'name' => 'Pemilik Satu',
            'contact' => '0812-3456-7890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('user.menu'));
        $this->assertDatabaseCount('tenants', 0);
        $this->assertDatabaseHas('users', [
            'username' => 'pemilik_satu',
            'name' => 'Pemilik Satu',
            'phone' => '081234567890',
            'role' => 'Pelanggan',
            'tenant_id' => null,
        ]);
        $this->get(route('user.menu'))
            ->assertOk()
            ->assertSee(route('tenant.create'));

        $this->post(route('tenant.store'), [
            'tenant_name' => 'Bengkel Satu',
            'subdomain' => 'bengkel-satu',
            'package' => 'starter',
        ])->assertRedirect(route('owner.home'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'Pemilik Satu',
            'email' => 'phone-081234567890@accounts.amahay.invalid',
            'phone' => '081234567890',
            'role' => 'Owner',
            'tenant_id' => auth()->user()->tenant_id,
        ]);

        $tenant = Tenant::firstOrFail();
        $this->assertSame('Bengkel Satu', $tenant->getAttribute('tenant_name'));
        $this->assertSame('starter', $tenant->getAttribute('package'));
        $this->assertDatabaseHas('domains', [
            'domain' => 'bengkel-satu.autozone.pro',
            'tenant_id' => $tenant->getTenantKey(),
        ]);
        Event::assertDispatched(TenantCreated::class);
    }

    public function test_new_tenant_dashboard_shows_empty_database_values_instead_of_demo_data(): void
    {
        $this->travelTo(new \DateTimeImmutable('2026-11-02T18:30:00+00:00'));

        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Baru',
            'subdomain' => 'bengkel-dashboard-baru',
            'package' => 'starter',
        ]);

        $dashboard = $this->get(route('owner.home'));
        $dashboard->assertOk()
            ->assertSee('Kembali ke Akun Utama')
            ->assertSee(route('user.menu'))
            ->assertSee('Bengkel Baru')
            ->assertSee('01:30:00 WIB')
            ->assertSee('03 Nov 2026')
            ->assertSee('Rp 0')
            ->assertSee('0 Unit')
            ->assertSee('Belum ada antrean atau servis yang sedang berjalan.')
            ->assertSee('Tidak ada sparepart yang berada di bawah stok minimum.')
            ->assertDontSee('Agus Setiawan')
            ->assertDontSee('Pak Joko')
            ->assertDontSee('B 1234 XYZ')
            ->assertDontSee('Oli MPX2 0.8L Matic');

        $tenant->delete();
    }

    public function test_new_tenant_dashboard_uses_sales_and_stock_from_its_own_database(): void
    {
        $this->freezeTime();

        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Data',
            'subdomain' => 'bengkel-dashboard-data',
            'package' => 'starter',
        ]);

        $tenant->run(function (): void {
            DB::table('sales')->insert([
                'invoice_number' => 'INV-DASHBOARD-001',
                'status' => 'completed',
                'total' => 125000,
                'sold_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('spare_parts')->insert([
                'sku' => 'DASH-PART-001',
                'name' => 'Kampas Rem Uji',
                'stock' => 1,
                'price' => 75000,
                'minimum_stock' => 4,
                'unit' => 'set',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        try {
            $this->get(route('owner.home'))
                ->assertOk()
                ->assertSee('Rp 125.000')
                ->assertSee('Kampas Rem Uji')
                ->assertSee('Stok:')
                ->assertDontSee('Oli MPX2 0.8L Matic');
        } finally {
            $tenant->delete();
        }
    }

    public function test_registered_tenant_appears_in_customer_search_and_superadmin_list(): void
    {
        Event::fake([TenantCreated::class]);

        $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Baru',
            'subdomain' => 'bengkel-baru',
            'package' => 'starter',
        ], 'Pemilik Baru', '081298765432');

        $this->actingAs(User::factory()->create(['role' => 'Pelanggan']))
            ->get(route('user.menu', ['search' => 'bengkel-baru.autozone.pro']))
            ->assertOk()
            ->assertSee('Bengkel Baru')
            ->assertSee('bengkel-baru.autozone.pro')
            ->assertSee('081298765432');

        $this->actingAs(User::factory()->create(['role' => 'Super Admin']))
            ->get(route('superadmin.tenant'))
            ->assertOk()
            ->assertSee('Bengkel Baru')
            ->assertSee('Pemilik Baru')
            ->assertSee('Starter');

        $this->actingAs(User::factory()->create(['role' => 'Super Admin']))
            ->get(route('superadmin.home'))
            ->assertOk()
            ->assertSee('1 Bengkel')
            ->assertSee('Bengkel Baru');
    }

    public function test_customer_and_superadmin_lists_show_an_empty_state_without_sample_tenants(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'Pelanggan']))
            ->get(route('user.menu'))
            ->assertOk()
            ->assertSee('Belum ada bengkel yang terdaftar.')
            ->assertDontSee('Bengkel Maju Jaya')
            ->assertDontSee('AAA Bike');

        $this->actingAs(User::factory()->create(['role' => 'Super Admin']))
            ->get(route('superadmin.tenant'))
            ->assertOk()
            ->assertSee('Belum ada tenant yang terdaftar.')
            ->assertDontSee('Bengkel Maju Jaya')
            ->assertDontSee('AAA Bike');

        $this->actingAs(User::factory()->create(['role' => 'Super Admin']))
            ->get(route('superadmin.home'))
            ->assertOk()
            ->assertSee('0 Bengkel')
            ->assertSee('Belum ada tenant yang terdaftar.')
            ->assertDontSee('Bengkel Maju Jaya')
            ->assertDontSee('AAA Bike');
    }

    public function test_customer_search_treats_search_input_as_data(): void
    {
        Event::fake([TenantCreated::class]);
        Tenant::create([
            'tenant_name' => 'Bengkel Aman',
            'package' => 'starter',
        ]);

        $this->actingAs(User::factory()->create(['role' => 'Pelanggan']))
            ->get(route('user.menu', ['search' => "' OR 1=1 --"]))
            ->assertOk()
            ->assertSee('Bengkel tidak ditemukan.')
            ->assertDontSee('Bengkel Aman');
    }

    public function test_customer_directory_escapes_tenant_names_from_registration(): void
    {
        Event::fake([TenantCreated::class]);
        Tenant::create([
            'tenant_name' => '<script>alert(1)</script>',
            'package' => 'starter',
        ]);

        $this->actingAs(User::factory()->create(['role' => 'Pelanggan']))
            ->get(route('user.menu'))
            ->assertOk()
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_owner_can_log_in_to_the_main_account_then_log_in_to_the_tenant(): void
    {
        Event::fake([TenantCreated::class]);
        $tenant = Tenant::create([
            'tenant_name' => 'Bengkel Login',
            'package' => 'starter',
        ]);
        $user = User::factory()->create([
            'phone' => '08123456789',
            'role' => 'Owner',
            'tenant_id' => $tenant->getTenantKey(),
            'password' => 'password123',
        ]);

        $this->get(route('login'))
            ->assertOk()
            ->assertDontSee('id="btn-tenant"', false);

        $this->post(route('login.proses'), [
            'email' => '08123456789',
            'password' => 'password123',
            'role' => 'user',
        ])->assertRedirect(route('user.menu'));

        $this->assertAuthenticatedAs($user);
        $this->get(route('user.menu'))
            ->assertOk()
            ->assertSee(route('owner.home'));

        $this->get(route('tenant.login'))
            ->assertOk()
            ->assertSee('Login Tenant');
        $this->post(route('tenant.login.proses'), [
            'email' => '08123456789',
            'password' => 'password123',
        ])->assertRedirect(route('owner.home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_tenant_login_is_available_only_after_logging_in_to_the_main_account(): void
    {
        $this->get(route('tenant.login'))->assertRedirect(route('login'));
        $this->post(route('tenant.login.proses'), [
            'email' => 'owner@example.com',
            'password' => 'password123',
        ])->assertRedirect(route('login'));

        $customer = User::factory()->create(['role' => 'Pelanggan']);

        $this->actingAs($customer)
            ->get(route('tenant.login'))
            ->assertOk()
            ->assertSee('Login Tenant')
            ->assertDontSee('id="btn-tenant"', false);
    }

    public function test_customer_can_register_with_an_email_and_confirmed_password(): void
    {
        $response = $this->post(route('register.customer.proses'), [
            'username' => 'Budi_123',
            'name' => 'Budi Santoso',
            'contact' => 'Budi@Example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('user.menu'));
        $this->assertAuthenticated();
        $this->get(route('user.menu'))
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertSee('budi@example.com')
            ->assertDontSee('panda@gmail.com');
        $this->assertDatabaseHas('users', [
            'username' => 'budi_123',
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => null,
            'role' => 'Pelanggan',
        ]);
    }

    public function test_customer_can_register_with_a_phone_number_and_log_in_using_the_username(): void
    {
        $this->post(route('register.customer.proses'), [
            'username' => 'pelanggan01',
            'name' => 'Pelanggan Satu',
            'contact' => '+62 812-3456-7890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('user.menu'));

        $this->assertDatabaseHas('users', [
            'username' => 'pelanggan01',
            'email' => 'phone-6281234567890@accounts.amahay.invalid',
            'phone' => '6281234567890',
            'role' => 'Pelanggan',
        ]);

        auth()->logout();

        $response = $this->post(route('login.proses'), [
            'email' => 'PELANGGAN01',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $response->assertRedirect(route('user.menu'));
        $this->assertAuthenticated();
    }

    public function test_customer_registration_rejects_duplicate_username_and_mismatched_password_confirmation(): void
    {
        User::factory()->create(['username' => 'pelanggan01']);

        $this->post(route('register.customer.proses'), [
            'username' => 'PELANGGAN01',
            'name' => 'Pelanggan Baru',
            'contact' => 'pelanggan@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password-different',
        ])->assertSessionHasErrors(['username', 'password']);

        $this->assertDatabaseCount('users', 1);
        $this->assertGuest();
    }

    public function test_customer_registration_requires_a_valid_email_or_phone_number(): void
    {
        $this->post(route('register.customer.proses'), [
            'username' => 'pelanggan01',
            'name' => 'Pelanggan Baru',
            'contact' => 'bukan-email-atau-nomor',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('contact');

        $this->assertDatabaseCount('users', 0);
    }

    public function test_customer_registration_rejects_an_email_that_is_already_registered(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);

        $this->post(route('register.customer.proses'), [
            'username' => 'pelanggan01',
            'name' => 'Pelanggan Baru',
            'contact' => 'taken@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('contact');

        $this->assertDatabaseCount('users', 1);
    }

    public function test_customer_registration_rejects_a_phone_number_that_is_already_registered(): void
    {
        User::factory()->create(['phone' => '08123456789']);

        $this->post(route('register.customer.proses'), [
            'username' => 'pelanggan01',
            'name' => 'Pelanggan Baru',
            'contact' => '0812 345 6789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('contact');

        $this->assertDatabaseCount('users', 1);
    }

    public function test_each_role_is_redirected_to_its_own_dashboard_after_email_login(): void
    {
        Event::fake([TenantCreated::class]);
        $tenant = Tenant::create([
            'tenant_name' => 'Bengkel Staff',
            'package' => 'starter',
        ]);
        $admin = User::factory()->create([
            'role' => 'Super Admin',
            'password' => 'password123',
        ]);
        $this->post(route('login.proses'), [
            'email' => $admin->email,
            'password' => 'password123',
            'role' => 'admin',
        ])->assertRedirect(route('superadmin.home'));
        $this->assertAuthenticatedAs($admin);

        $customer = User::factory()->create([
            'role' => 'Pelanggan',
            'password' => 'password123',
        ]);
        $this->post(route('login.proses'), [
            'email' => $customer->email,
            'password' => 'password123',
            'role' => 'user',
        ])->assertRedirect(route('user.menu'));
        $this->assertAuthenticatedAs($customer);

        foreach ([
            ['Kasir', 'owner.kasir'],
            ['Mekanik', 'owner.mekanik'],
        ] as [$role, $route]) {
            $user = User::factory()->create([
                'role' => $role,
                'tenant_id' => $tenant->getTenantKey(),
                'password' => 'password123',
            ]);

            $this->actingAs($customer)
                ->post(route('tenant.login.proses'), [
                    'email' => $user->email,
                    'password' => 'password123',
                ])->assertRedirect(route($route));
            $this->assertAuthenticatedAs($user);
        }
    }

    public function test_login_rejects_an_incorrect_password_or_role(): void
    {
        $user = User::factory()->create([
            'phone' => '08123456789',
            'role' => 'Owner',
            'password' => 'password123',
        ]);

        $this->actingAs(User::factory()->create(['role' => 'Pelanggan']));
        $this->post(route('login.proses'), [
            'email' => '08123456789',
            'password' => 'wrong-password',
            'role' => 'user',
        ])->assertSessionHasErrors('email');

        $this->post(route('login.proses'), [
            'email' => $user->email,
            'password' => 'password123',
            'role' => 'tenant',
        ])->assertSessionHasErrors('role');

        $this->post(route('tenant.login.proses'), [
            'email' => '08123456789',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->post(route('login.proses'), [
            'email' => $user->email,
            'password' => 'password123',
            'role' => 'user',
        ])->assertRedirect(route('user.menu'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_duplicate_phone_number_is_rejected_during_registration(): void
    {
        User::factory()->create(['phone' => '08123456789']);

        $this->post(route('register.proses'), [
            'username' => 'pelanggan_baru',
            'name' => 'Pelanggan Baru',
            'contact' => '0812 3456 789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('contact');

        $this->assertDatabaseCount('tenants', 0);
    }

    public function test_dashboard_routes_require_authentication_and_the_correct_role(): void
    {
        $this->get(route('owner.home'))->assertRedirect(route('login'));

        $customer = User::factory()->create(['role' => 'Pelanggan']);
        $this->actingAs($customer)->get(route('owner.home'))->assertForbidden();
    }

    public function test_customer_pages_show_the_authenticated_accounts_identity_instead_of_demo_data(): void
    {
        $customer = User::factory()->create([
            'name' => 'Nadia Konsumen',
            'email' => 'nadia@example.com',
            'role' => 'Pelanggan',
        ]);
        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Profil Konsumen',
            'subdomain' => 'bengkel-profil-konsumen',
            'package' => 'starter',
        ]);

        try {
            $this->actingAs($customer);

            $pages = [
                route('user.menu'),
                route('user.bengkel.detail', ['id' => $tenant->getTenantKey()]),
                route('user.cek.servis'),
                route('user.promo'),
                route('user.riwayat'),
                route('user.profil.edit'),
            ];

            foreach ($pages as $page) {
                $this->get($page)
                    ->assertOk()
                    ->assertSee('Nadia Konsumen')
                    ->assertSee('nadia@example.com')
                    ->assertDontSee('panda@gmail.com');
            }
        } finally {
            $tenant->delete();
        }
    }

    public function test_logout_invalidates_the_authenticated_session(): void
    {
        $user = User::factory()->create(['role' => 'Pelanggan']);

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_login_and_registration_pages_render(): void
    {
        $this->get(route('login'))->assertOk();
        $this->get(route('register'))->assertOk();
        $this->get(route('register.customer'))->assertOk();
    }

    private function createTenantForMainAccount(
        array $tenant,
        string $ownerName = 'Pemilik Uji',
        string $phone = '081298765432',
    ): Tenant {
        $digits = preg_replace('/\D+/', '', $phone);

        $this->post(route('register.proses'), [
            'username' => 'pemilik'.substr($digits, -6),
            'name' => $ownerName,
            'contact' => $phone,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('user.menu'));

        $this->post(route('tenant.store'), $tenant)
            ->assertRedirect(route('owner.home'));

        return Tenant::query()->findOrFail(auth()->user()->tenant_id);
    }
}
