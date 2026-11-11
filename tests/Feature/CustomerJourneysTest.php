<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CustomerJourneysTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_update_profile_and_save_a_vehicle(): void
    {
        $customer = User::factory()->create([
            'name' => 'Nama Lama',
            'email' => 'lama@example.com',
            'role' => 'Pelanggan',
        ]);

        $this->actingAs($customer)
            ->patch(route('user.profil.update'), [
                'name' => 'Nama Baru',
                'contact' => 'baru@example.com',
                'license_plate' => 'b 1234 xyz',
                'brand' => 'Honda',
                'model' => 'BeAT',
                'year' => 2022,
                'odometer' => 12000,
            ])
            ->assertRedirect(route('user.profil.edit'));

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'name' => 'Nama Baru',
            'email' => 'baru@example.com',
        ]);
        $this->assertDatabaseHas('customer_vehicles', [
            'user_id' => $customer->id,
            'license_plate' => 'B 1234 XYZ',
            'brand' => 'Honda',
            'model' => 'BeAT',
            'year' => 2022,
            'odometer' => 12000,
        ]);
    }

    public function test_profile_update_rejects_an_invalid_or_duplicate_contact_without_saving(): void
    {
        $customer = User::factory()->create([
            'name' => 'Nama Lama',
            'role' => 'Pelanggan',
        ]);
        User::factory()->create(['phone' => '08123456789']);

        $this->actingAs($customer)
            ->patch(route('user.profil.update'), [
                'name' => 'Nama Baru',
                'contact' => '0812 345 6789',
            ])
            ->assertSessionHasErrors('contact');

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'name' => 'Nama Lama',
        ]);
        $this->assertDatabaseCount('customer_vehicles', 0);
    }

    public function test_customer_profile_requires_authentication(): void
    {
        $this->get(route('user.profil.edit'))
            ->assertRedirect(route('login'));
    }

    public function test_customer_can_book_an_active_tenant_and_the_service_is_recorded(): void
    {
        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Booking',
            'subdomain' => 'bengkel-booking',
            'package' => 'starter',
        ]);

        $serviceId = $tenant->run(fn (): int => DB::table('service_catalog')->insertGetId([
            'service_code' => 'SRV-BOOKING-01',
            'name' => 'Servis Ringan',
            'description' => 'Servis rutin',
            'estimated_duration_minutes' => 60,
            'price' => 75000,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        $this->post(route('user.bengkel.booking', ['id' => $tenant->getTenantKey()]), [
            'license_plate' => 'B 1234 XYZ',
            'brand' => 'Honda',
            'model' => 'BeAT',
            'year' => 2022,
            'odometer' => 12000,
            'scheduled_date' => now()->addDay()->toDateString(),
            'scheduled_time' => '09:00',
            'complaint' => 'Rem berbunyi',
            'service_id' => $serviceId,
        ])->assertRedirect(route('user.riwayat'));

        $tenant->run(function () use ($serviceId): void {
            $this->assertDatabaseHas('customers', [
                'name' => 'Pemilik Uji',
                'central_user_id' => auth()->id(),
            ]);
            $this->assertDatabaseHas('vehicles', [
                'license_plate' => 'B 1234 XYZ',
                'brand' => 'Honda',
                'model' => 'BeAT',
            ]);
            $this->assertDatabaseHas('work_orders', [
                'status' => 'waiting',
                'complaint' => 'Rem berbunyi',
            ]);
            $this->assertDatabaseHas('work_order_services', [
                'service_id' => $serviceId,
                'service_name' => 'Servis Ringan',
                'subtotal' => 75000,
            ]);
        });

        $this->assertDatabaseHas('customer_vehicles', [
            'user_id' => auth()->id(),
            'license_plate' => 'B 1234 XYZ',
        ]);
    }

    public function test_booking_rejects_an_inactive_tenant_and_invalid_schedule(): void
    {
        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Tidak Aktif',
            'subdomain' => 'bengkel-tidak-aktif',
            'package' => 'starter',
        ]);
        $tenant->setAttribute('status', 'inactive');
        $tenant->save();

        $this->get(route('user.bengkel.detail', ['id' => $tenant->getTenantKey()]))
            ->assertNotFound();

        $tenant->setAttribute('status', 'active');
        $tenant->save();

        $this->post(route('user.bengkel.booking', ['id' => $tenant->getTenantKey()]), [
            'license_plate' => 'B 1234 XYZ',
            'brand' => 'Honda',
            'model' => 'BeAT',
            'scheduled_date' => now()->subDay()->toDateString(),
            'scheduled_time' => '09:00',
        ])->assertSessionHasErrors('scheduled_date');

        $tenant->run(function (): void {
            $this->assertDatabaseCount('work_orders', 0);
        });
    }

    public function test_booking_cannot_use_another_customers_saved_vehicle(): void
    {
        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Isolasi',
            'subdomain' => 'bengkel-isolasi',
            'package' => 'starter',
        ]);
        $otherCustomer = User::factory()->create(['role' => 'Pelanggan']);
        $vehicleId = DB::table('customer_vehicles')->insertGetId([
            'user_id' => $otherCustomer->id,
            'license_plate' => 'D 1234 ABC',
            'brand' => 'Yamaha',
            'model' => 'NMAX',
            'odometer' => 1000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->post(route('user.bengkel.booking', ['id' => $tenant->getTenantKey()]), [
            'vehicle_id' => $vehicleId,
            'license_plate' => 'D 1234 ABC',
            'brand' => 'Yamaha',
            'model' => 'NMAX',
            'scheduled_date' => now()->addDay()->toDateString(),
            'scheduled_time' => '09:00',
        ])->assertSessionHasErrors('vehicle_id');

        $tenant->run(function (): void {
            $this->assertDatabaseCount('work_orders', 0);
        });
    }

    private function createTenantForMainAccount(array $tenant): Tenant
    {
        $this->post(route('register.proses'), [
            'username' => 'pemilikbooking',
            'name' => 'Pemilik Uji',
            'contact' => '081298765432',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('user.menu'));

        $this->post(route('tenant.store'), $tenant)
            ->assertRedirect(route('owner.home'));

        return Tenant::query()->findOrFail(auth()->user()->tenant_id);
    }
}
