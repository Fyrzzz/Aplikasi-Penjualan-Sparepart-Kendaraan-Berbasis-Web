<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TenantDatabaseSchemaTest extends TestCase
{
    public function test_tenant_migrations_build_the_workshop_operational_schema(): void
    {
        $connection = config('database.connections.sqlite');
        $connection['database'] = ':memory:';
        $connection['url'] = null;
        config(['database.connections.tenant_schema_test' => $connection]);
        DB::purge('tenant_schema_test');

        try {
            $exitCode = Artisan::call('migrate', [
                '--database' => 'tenant_schema_test',
                '--path' => database_path('migrations/tenant'),
                '--realpath' => true,
                '--force' => true,
                '--no-interaction' => true,
            ]);

            $this->assertSame(0, $exitCode, Artisan::output());

            $schema = Schema::connection('tenant_schema_test');
            foreach ([
                'spare_parts',
                'customers',
                'vehicles',
                'employees',
                'service_catalog',
                'work_orders',
                'work_order_services',
                'work_order_parts',
                'inventory_movements',
                'sales',
                'sale_items',
                'payments',
                'service_reminders',
            ] as $table) {
                $this->assertTrue($schema->hasTable($table), "Missing tenant table: {$table}");
            }

            $this->assertTrue($schema->hasColumns('spare_parts', [
                'sku',
                'stock',
                'minimum_stock',
                'location',
                'is_active',
            ]));
            $this->assertTrue($schema->hasColumns('work_orders', [
                'customer_id',
                'vehicle_id',
                'mechanic_id',
                'status',
                'complaint',
            ]));
            $this->assertTrue($schema->hasColumns('sales', [
                'invoice_number',
                'customer_id',
                'cashier_id',
                'total',
                'amount_paid',
            ]));
            $this->assertTrue($schema->hasColumns('service_reminders', [
                'customer_id',
                'vehicle_id',
                'due_date',
                'status',
                'sent_at',
            ]));
        } finally {
            DB::purge('tenant_schema_test');
        }
    }
}
