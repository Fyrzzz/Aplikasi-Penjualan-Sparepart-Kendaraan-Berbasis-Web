<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CustomerServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_service_pages_show_empty_states_without_sample_records(): void
    {
        $customer = User::factory()->create(['role' => 'Pelanggan']);
        $this->actingAs($customer);

        $this->get(route('user.cek.servis'))
            ->assertOk()
            ->assertSee('Belum ada servis aktif yang terhubung ke akun Anda.')
            ->assertDontSee('Bengkel Maju Jaya')
            ->assertDontSee('L 4567 XY');

        $this->get(route('user.riwayat'))
            ->assertOk()
            ->assertSee('Belum ada riwayat servis untuk akun Anda.')
            ->assertDontSee('Abadi Motor')
            ->assertDontSee('Rp 185.000');
    }

    public function test_customer_service_pages_show_only_records_linked_to_their_account(): void
    {
        $this->post(route('register.proses'), [
            'username' => 'pemilikportal',
            'name' => 'Pemilik Portal',
            'contact' => '081298765420',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('user.menu'));

        $this->post(route('tenant.store'), [
            'tenant_name' => 'Bengkel Portal',
            'subdomain' => 'bengkel-portal-customer',
            'package' => 'starter',
        ])->assertRedirect(route('owner.home'));

        $tenant = Tenant::query()->findOrFail(auth()->user()->tenant_id);
        $customer = User::factory()->create([
            'name' => 'Konsumen Portal',
            'email' => 'phone-081234567890@accounts.amahay.invalid',
            'phone' => '081234567890',
            'role' => 'Pelanggan',
        ]);

        $tenant->run(function () use ($customer): void {
            $now = now();
            $customerId = DB::table('customers')->insertGetId([
                'name' => $customer->name,
                'phone' => $customer->phone,
                'email' => $customer->email,
                'central_user_id' => $customer->id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $vehicleId = DB::table('vehicles')->insertGetId([
                'customer_id' => $customerId,
                'license_plate' => 'B 1234 TEST',
                'brand' => 'Honda',
                'model' => 'Vario',
                'year' => 2024,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('work_orders')->insert([
                'work_order_number' => 'WO-PORTAL-001',
                'customer_id' => $customerId,
                'vehicle_id' => $vehicleId,
                'status' => 'in_progress',
                'complaint' => 'Rem perlu diperiksa',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('work_orders')->insert([
                'work_order_number' => 'WO-PORTAL-DONE',
                'customer_id' => $customerId,
                'vehicle_id' => $vehicleId,
                'status' => 'completed',
                'complaint' => 'Servis selesai',
                'created_at' => $now->copy()->subDay(),
                'updated_at' => $now,
            ]);
            $saleId = DB::table('sales')->insertGetId([
                'invoice_number' => 'INV-PORTAL-001',
                'customer_id' => $customerId,
                'status' => 'completed',
                'subtotal' => 45000,
                'total' => 45000,
                'amount_paid' => 45000,
                'sold_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('sale_items')->insert([
                'sale_id' => $saleId,
                'item_name' => 'Oli Pelumas Uji',
                'quantity' => 1,
                'unit_price' => 45000,
                'subtotal' => 45000,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $contactCustomerId = DB::table('customers')->insertGetId([
                'name' => $customer->name,
                'phone' => '+62 812-3456-7890',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $contactVehicleId = DB::table('vehicles')->insertGetId([
                'customer_id' => $contactCustomerId,
                'license_plate' => 'B 5678 CONTACT',
                'brand' => 'Honda',
                'model' => 'Beat',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('work_orders')->insert([
                'work_order_number' => 'WO-CONTACT-002',
                'customer_id' => $contactCustomerId,
                'vehicle_id' => $contactVehicleId,
                'status' => 'waiting',
                'complaint' => 'Servis terjadwal',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $otherCustomerId = DB::table('customers')->insertGetId([
                'name' => 'Konsumen Lain',
                'phone' => '081234567891',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $otherVehicleId = DB::table('vehicles')->insertGetId([
                'customer_id' => $otherCustomerId,
                'license_plate' => 'B 9999 OTHER',
                'brand' => 'Yamaha',
                'model' => 'NMAX',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('work_orders')->insert([
                'work_order_number' => 'WO-OTHER-001',
                'customer_id' => $otherCustomerId,
                'vehicle_id' => $otherVehicleId,
                'status' => 'in_progress',
                'complaint' => 'Data konsumen lain',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        });

        try {
            $this->actingAs($customer)
                ->get(route('user.cek.servis'))
                ->assertOk()
                ->assertSee('WO-PORTAL-001')
                ->assertSee('WO-CONTACT-002')
                ->assertDontSee('WO-PORTAL-DONE')
                ->assertDontSee('INV-PORTAL-001')
                ->assertDontSee('WO-OTHER-001');

            $this->get(route('user.cek.servis', ['search' => 'B 1234 TEST']))
                ->assertOk()
                ->assertSee('WO-PORTAL-001')
                ->assertSee('Konsumen Portal')
                ->assertDontSee('WO-CONTACT-002')
                ->assertDontSee('WO-OTHER-001')
                ->assertDontSee('B 9999 OTHER');

            $this->get(route('user.riwayat'))
                ->assertOk()
                ->assertSee('WO-PORTAL-001')
                ->assertSee('WO-PORTAL-DONE')
                ->assertSee('WO-CONTACT-002')
                ->assertSee('INV-PORTAL-001')
                ->assertSee('Oli Pelumas Uji')
                ->assertSee('Rp 45.000')
                ->assertSee('Bengkel Portal')
                ->assertDontSee('WO-OTHER-001')
                ->assertDontSee('Konsumen Lain');
        } finally {
            $tenant->delete();
        }
    }

    public function test_guest_is_redirected_to_login_from_customer_service_pages(): void
    {
        $this->get(route('user.cek.servis'))->assertRedirect(route('login'));
        $this->get(route('user.riwayat'))->assertRedirect(route('login'));
    }
}
