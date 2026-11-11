<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OwnerOperationsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_pages_show_only_records_from_the_current_tenant_database(): void
    {
        $this->freezeTime();

        $firstTenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Data',
            'subdomain' => 'bengkel-operations-data',
            'package' => 'starter',
        ], 'Pemilik Data', '081298765410');

        $firstOwner = auth()->user();

        try {
            $firstTenant->run(function (): void {
                $now = now();
                $customerId = DB::table('customers')->insertGetId([
                    'name' => 'Pelanggan Bengkel Data',
                    'phone' => '081234567890',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $vehicleId = DB::table('vehicles')->insertGetId([
                    'customer_id' => $customerId,
                    'license_plate' => 'B 1234 TEST',
                    'brand' => 'Honda',
                    'model' => 'Vario',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $mechanicId = DB::table('employees')->insertGetId([
                    'name' => 'Mekanik Bengkel Data',
                    'position' => 'Mekanik',
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                DB::table('spare_parts')->insert([
                    'sku' => 'DATA-PART-001',
                    'name' => 'Kampas Rem Bengkel Data',
                    'stock' => 3,
                    'price' => 75000,
                    'category' => 'Rem',
                    'unit' => 'set',
                    'minimum_stock' => 4,
                    'location' => 'Rak A1',
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                DB::table('service_catalog')->insert([
                    'service_code' => 'DATA-SERVICE-001',
                    'name' => 'Servis Bengkel Data',
                    'price' => 100000,
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                DB::table('work_orders')->insert([
                    'work_order_number' => 'WO-DATA-001',
                    'customer_id' => $customerId,
                    'vehicle_id' => $vehicleId,
                    'mechanic_id' => $mechanicId,
                    'status' => 'waiting',
                    'complaint' => 'Rem berbunyi',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                DB::table('sales')->insert([
                    'invoice_number' => 'INV-DATA-001',
                    'customer_id' => $customerId,
                    'status' => 'completed',
                    'total' => 175000,
                    'sold_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                DB::table('service_reminders')->insert([
                    'customer_id' => $customerId,
                    'vehicle_id' => $vehicleId,
                    'due_date' => $now->toDateString(),
                    'status' => 'pending',
                    'message' => 'Pengingat Bengkel Data',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            });

            $this->actingAs($firstOwner);
            $this->get(route('owner.antrean'))
                ->assertOk()
                ->assertSee('WO-DATA-001')
                ->assertSee('Pelanggan Bengkel Data')
                ->assertSee('1');
            $this->get(route('owner.kasir'))
                ->assertOk()
                ->assertSee('Kampas Rem Bengkel Data')
                ->assertSee('Servis Bengkel Data')
                ->assertSee('INV-DATA-001');
            $this->get(route('owner.stok'))
                ->assertOk()
                ->assertSee('Kampas Rem Bengkel Data')
                ->assertSee('Rp 75.000');
            $this->get(route('owner.mekanik'))
                ->assertOk()
                ->assertSee('Pelanggan Bengkel Data')
                ->assertSee('Mekanik Bengkel Data');
            $this->get(route('owner.pengingat'))
                ->assertOk()
                ->assertSee('Pelanggan Bengkel Data')
                ->assertSee('Pengingat Bengkel Data');

            $this->post(route('logout'))->assertRedirect();
            $secondTenant = $this->createTenantForMainAccount([
                'tenant_name' => 'Bengkel Kosong',
                'subdomain' => 'bengkel-operations-kosong',
                'package' => 'starter',
            ], 'Pemilik Kosong', '081298765411');

            $this->get(route('owner.antrean'))
                ->assertOk()
                ->assertSee('Belum ada antrean servis.')
                ->assertDontSee('WO-DATA-001');
            $this->get(route('owner.kasir'))
                ->assertOk()
                ->assertSee('Belum ada sparepart aktif di bengkel ini.')
                ->assertSee('Belum ada jasa aktif di bengkel ini.')
                ->assertSee('Belum ada transaksi di bengkel ini.')
                ->assertDontSee('INV-DATA-001');
            $this->get(route('owner.stok'))
                ->assertOk()
                ->assertSee('Belum ada data sparepart di bengkel ini.')
                ->assertDontSee('Kampas Rem Bengkel Data');
            $this->get(route('owner.mekanik'))
                ->assertOk()
                ->assertSee('Belum ada data pelanggan di bengkel ini.')
                ->assertSee('Belum ada data mekanik aktif di bengkel ini.')
                ->assertDontSee('Pelanggan Bengkel Data');
            $this->get(route('owner.pengingat'))
                ->assertOk()
                ->assertSee('Belum ada pengingat servis di bengkel ini.')
                ->assertDontSee('Pengingat Bengkel Data');
        } finally {
            $firstTenant->delete();
            if (isset($secondTenant)) {
                $secondTenant->delete();
            }
        }
    }

    public function test_owner_can_add_and_adjust_sparepart_stock_with_audit_movements(): void
    {
        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Mutasi Stok',
            'subdomain' => 'bengkel-mutasi-stok',
            'package' => 'starter',
        ], 'Pemilik Stok', '081298765412');

        try {
            $this->post(route('owner.stok.store'), [
                'sku' => 'part-001',
                'name' => 'Kampas Rem',
                'stock' => 5,
                'price' => 85000,
                'category' => 'Rem',
                'unit' => 'set',
                'minimum_stock' => 2,
                'location' => 'Rak A1',
            ])->assertRedirect(route('owner.stok'));

            $partId = $tenant->run(fn (): int => (int) DB::table('spare_parts')
                ->where('sku', 'PART-001')
                ->value('id'));

            $this->patch(route('owner.stok.adjust', $partId), [
                'adjustment' => -2,
                'notes' => 'Terjual langsung',
            ])->assertRedirect(route('owner.stok'));

            $tenant->run(function () use ($partId): void {
                $this->assertDatabaseHas('spare_parts', [
                    'id' => $partId,
                    'sku' => 'PART-001',
                    'stock' => 3,
                ]);
                $this->assertDatabaseHas('inventory_movements', [
                    'spare_part_id' => $partId,
                    'movement_type' => 'initial_stock',
                    'quantity' => 5,
                    'stock_before' => 0,
                    'stock_after' => 5,
                ]);
                $this->assertDatabaseHas('inventory_movements', [
                    'spare_part_id' => $partId,
                    'movement_type' => 'stock_out',
                    'quantity' => 2,
                    'stock_before' => 5,
                    'stock_after' => 3,
                    'notes' => 'Terjual langsung',
                ]);
            });
        } finally {
            tenancy()->end();
            DB::purge('tenant');
            $tenant->delete();
        }
    }

    public function test_stock_adjustment_rejects_negative_results_and_cashiers_cannot_manage_inventory(): void
    {
        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Batas Stok',
            'subdomain' => 'bengkel-batas-stok',
            'package' => 'starter',
        ], 'Pemilik Batas Stok', '081298765413');
        $cashier = User::factory()->create([
            'role' => 'Kasir',
            'tenant_id' => $tenant->getTenantKey(),
        ]);

        try {
            $partId = $tenant->run(fn (): int => DB::table('spare_parts')->insertGetId([
                'sku' => 'PART-LIMIT',
                'name' => 'Oli Mesin',
                'stock' => 1,
                'price' => 50000,
                'category' => 'Oli',
                'unit' => 'botol',
                'minimum_stock' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            $this->patch(route('owner.stok.adjust', $partId), [
                'adjustment' => -2,
            ])->assertSessionHasErrors('adjustment');

            $tenant->run(function () use ($partId): void {
                $this->assertDatabaseHas('spare_parts', ['id' => $partId, 'stock' => 1]);
                $this->assertDatabaseCount('inventory_movements', 0);
            });

            $this->actingAs($cashier)
                ->post(route('owner.stok.store'), [
                    'sku' => 'PART-002',
                    'name' => 'Busi',
                    'stock' => 4,
                    'price' => 25000,
                    'unit' => 'pcs',
                    'minimum_stock' => 1,
                ])
                ->assertForbidden();

            $tenant->run(function (): void {
                $this->assertDatabaseCount('spare_parts', 1);
            });
        } finally {
            tenancy()->end();
            DB::purge('tenant');
            $tenant->delete();
        }
    }

    public function test_mechanic_can_move_a_work_order_through_valid_status_transitions(): void
    {
        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Status Antrean',
            'subdomain' => 'bengkel-status-antrean',
            'package' => 'starter',
        ], 'Pemilik Antrean', '081298765414');
        $mechanic = User::factory()->create([
            'role' => 'Mekanik',
            'tenant_id' => $tenant->getTenantKey(),
        ]);

        try {
            $workOrderId = $tenant->run(function (): int {
                $customerId = DB::table('customers')->insertGetId([
                    'name' => 'Pelanggan Antrean',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $vehicleId = DB::table('vehicles')->insertGetId([
                    'customer_id' => $customerId,
                    'license_plate' => 'B 1111 ABC',
                    'brand' => 'Honda',
                    'model' => 'Vario',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return DB::table('work_orders')->insertGetId([
                    'work_order_number' => 'WO-STATUS-001',
                    'customer_id' => $customerId,
                    'vehicle_id' => $vehicleId,
                    'status' => 'waiting',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });

            $this->patch(route('owner.antrean.status', $workOrderId), ['status' => 'completed'])
                ->assertSessionHasErrors('status');
            $tenant->run(function () use ($workOrderId): void {
                $this->assertDatabaseHas('work_orders', [
                    'id' => $workOrderId,
                    'status' => 'waiting',
                ]);
            });

            $this->actingAs($mechanic)
                ->patch(route('owner.antrean.status', $workOrderId), ['status' => 'in_progress'])
                ->assertRedirect(route('owner.antrean'));
            $tenant->run(function () use ($workOrderId): void {
                $this->assertDatabaseHas('work_orders', [
                    'id' => $workOrderId,
                    'status' => 'in_progress',
                ]);
            });

            $this->patch(route('owner.antrean.status', $workOrderId), ['status' => 'completed'])
                ->assertRedirect(route('owner.antrean'));
            $tenant->run(function () use ($workOrderId): void {
                $this->assertDatabaseHas('work_orders', [
                    'id' => $workOrderId,
                    'status' => 'completed',
                ]);
                $this->assertNotNull(DB::table('work_orders')->where('id', $workOrderId)->value('started_at'));
                $this->assertNotNull(DB::table('work_orders')->where('id', $workOrderId)->value('completed_at'));
            });
        } finally {
            tenancy()->end();
            DB::purge('tenant');
            $tenant->delete();
        }
    }

    public function test_cashier_can_record_a_sale_and_stock_is_deducted_atomically(): void
    {
        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Kasir',
            'subdomain' => 'bengkel-kasir',
            'package' => 'starter',
        ], 'Pemilik Kasir', '081298765415');
        $cashier = User::factory()->create([
            'role' => 'Kasir',
            'tenant_id' => $tenant->getTenantKey(),
        ]);

        try {
            $catalog = $tenant->run(function (): array {
                $customerId = DB::table('customers')->insertGetId([
                    'name' => 'Pelanggan POS',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $partId = DB::table('spare_parts')->insertGetId([
                    'sku' => 'POS-PART-001',
                    'name' => 'Oli Mesin',
                    'stock' => 5,
                    'price' => 50000,
                    'category' => 'Oli',
                    'unit' => 'botol',
                    'minimum_stock' => 1,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $serviceId = DB::table('service_catalog')->insertGetId([
                    'service_code' => 'POS-SERVICE-001',
                    'name' => 'Ganti Oli',
                    'price' => 100000,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return compact('customerId', 'partId', 'serviceId');
            });

            $this->actingAs($cashier)
                ->post(route('owner.kasir.checkout'), [
                    'customer_id' => $catalog['customerId'],
                    'payment_method' => 'cash',
                    'amount_paid' => 250000,
                    'parts' => [$catalog['partId']],
                    'part_quantities' => [$catalog['partId'] => 2],
                    'services' => [$catalog['serviceId']],
                ])
                ->assertRedirect(route('owner.kasir'))
                ->assertSessionHas('success');

            $tenant->run(function () use ($catalog): void {
                $this->assertDatabaseHas('sales', [
                    'customer_id' => $catalog['customerId'],
                    'status' => 'completed',
                    'subtotal' => 200000,
                    'total' => 200000,
                    'amount_paid' => 250000,
                    'change_due' => 50000,
                ]);
                $this->assertDatabaseCount('sale_items', 2);
                $this->assertDatabaseHas('spare_parts', [
                    'id' => $catalog['partId'],
                    'stock' => 3,
                ]);
                $this->assertDatabaseHas('payments', [
                    'payment_method' => 'cash',
                    'amount' => 200000,
                    'status' => 'completed',
                ]);
                $this->assertDatabaseHas('inventory_movements', [
                    'spare_part_id' => $catalog['partId'],
                    'movement_type' => 'sale',
                    'stock_before' => 5,
                    'stock_after' => 3,
                ]);
            });
        } finally {
            tenancy()->end();
            DB::purge('tenant');
            $tenant->delete();
        }
    }

    public function test_cashier_checkout_rejects_insufficient_stock_without_creating_a_sale(): void
    {
        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Stok Kasir',
            'subdomain' => 'bengkel-stok-kasir',
            'package' => 'starter',
        ], 'Pemilik Stok Kasir', '081298765416');
        $cashier = User::factory()->create([
            'role' => 'Kasir',
            'tenant_id' => $tenant->getTenantKey(),
        ]);

        try {
            $partId = $tenant->run(fn (): int => DB::table('spare_parts')->insertGetId([
                'sku' => 'POS-STOCK-001',
                'name' => 'Busi',
                'stock' => 1,
                'price' => 25000,
                'category' => 'Kelistrikan',
                'unit' => 'pcs',
                'minimum_stock' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            $this->actingAs($cashier)
                ->post(route('owner.kasir.checkout'), [
                    'payment_method' => 'cash',
                    'amount_paid' => 50000,
                    'parts' => [$partId],
                    'part_quantities' => [$partId => 2],
                ])
                ->assertSessionHasErrors('parts');

            $tenant->run(function () use ($partId): void {
                $this->assertDatabaseCount('sales', 0);
                $this->assertDatabaseHas('spare_parts', ['id' => $partId, 'stock' => 1]);
                $this->assertDatabaseCount('inventory_movements', 0);
            });
        } finally {
            tenancy()->end();
            DB::purge('tenant');
            $tenant->delete();
        }
    }

    public function test_owner_can_add_a_mechanic_and_schedule_a_manual_service_reminder(): void
    {
        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Pengingat',
            'subdomain' => 'bengkel-pengingat',
            'package' => 'starter',
        ], 'Pemilik Pengingat', '081298765417');

        try {
            $customerData = $tenant->run(function (): array {
                $customerId = DB::table('customers')->insertGetId([
                    'name' => 'Pelanggan Pengingat',
                    'phone' => '081234567890',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $vehicleId = DB::table('vehicles')->insertGetId([
                    'customer_id' => $customerId,
                    'license_plate' => 'D 1234 REM',
                    'brand' => 'Yamaha',
                    'model' => 'NMAX',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return compact('customerId', 'vehicleId');
            });

            $this->post(route('owner.mekanik.store'), [
                'employee_code' => 'MEK-001',
                'name' => 'Mekanik Baru',
                'phone' => '081234567891',
                'position' => 'Mekanik',
                'specialization' => 'Mesin',
            ])->assertRedirect(route('owner.mekanik'));

            $this->post(route('owner.pengingat.store'), [
                'customer_id' => $customerData['customerId'],
                'vehicle_id' => $customerData['vehicleId'],
                'due_date' => now()->addWeek()->toDateString(),
                'message' => 'Jadwalkan servis berikutnya',
            ])->assertRedirect(route('owner.pengingat'))
                ->assertSessionHas('success', 'Pengingat berhasil dijadwalkan. Pesan belum dikirim otomatis.');

            $tenant->run(function () use ($customerData): void {
                $this->assertDatabaseHas('employees', [
                    'employee_code' => 'MEK-001',
                    'name' => 'Mekanik Baru',
                    'status' => 'active',
                ]);
                $this->assertDatabaseHas('service_reminders', [
                    'customer_id' => $customerData['customerId'],
                    'vehicle_id' => $customerData['vehicleId'],
                    'status' => 'pending',
                    'channel' => 'whatsapp',
                    'message' => 'Jadwalkan servis berikutnya',
                ]);
            });
        } finally {
            tenancy()->end();
            DB::purge('tenant');
            $tenant->delete();
        }
    }

    public function test_reminder_rejects_a_vehicle_belonging_to_a_different_customer(): void
    {
        $tenant = $this->createTenantForMainAccount([
            'tenant_name' => 'Bengkel Validasi Pengingat',
            'subdomain' => 'bengkel-validasi-pengingat',
            'package' => 'starter',
        ], 'Pemilik Validasi Pengingat', '081298765418');

        try {
            $customers = $tenant->run(function (): array {
                $firstCustomerId = DB::table('customers')->insertGetId([
                    'name' => 'Pelanggan Pertama',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $secondCustomerId = DB::table('customers')->insertGetId([
                    'name' => 'Pelanggan Kedua',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $vehicleId = DB::table('vehicles')->insertGetId([
                    'customer_id' => $firstCustomerId,
                    'license_plate' => 'E 5678 ABC',
                    'brand' => 'Honda',
                    'model' => 'Beat',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return compact('secondCustomerId', 'vehicleId');
            });

            $this->post(route('owner.pengingat.store'), [
                'customer_id' => $customers['secondCustomerId'],
                'vehicle_id' => $customers['vehicleId'],
                'due_date' => now()->addDay()->toDateString(),
            ])->assertSessionHasErrors('vehicle_id');

            $tenant->run(function (): void {
                $this->assertDatabaseCount('service_reminders', 0);
            });
        } finally {
            tenancy()->end();
            DB::purge('tenant');
            $tenant->delete();
        }
    }

    private function createTenantForMainAccount(array $tenant, string $ownerName, string $phone): Tenant
    {
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
