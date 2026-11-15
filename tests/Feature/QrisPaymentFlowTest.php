<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class QrisPaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.qris.sandbox_enabled' => true,
            'services.qris.fake_unavailable' => false,
        ]);
    }

    public function test_qris_checkout_creates_pending_dynamic_charge_and_simulation_completes_payment(): void
    {
        $this->freezeTime();
        $records = $this->createCashierTenant('501');
        $tenant = $records['tenant'];
        $cashier = $records['cashier'];

        try {
            $partId = $this->createPart($tenant);
            $payload = $this->qrisCheckoutPayload($partId, 'cd42d5a5-00d8-4be2-b483-2744df694151');

            $this->actingAs($cashier)
                ->post(route('owner.kasir.checkout'), $payload)
                ->assertRedirect(route('owner.kasir.payment.show', ['invoice' => $this->invoiceFor($tenant)]));

            $sale = $this->saleFor($tenant);
            $this->assertSame('pending', $sale->status);
            $this->assertSame('0.00', number_format((float) $sale->amount_paid, 2, '.', ''));
            $this->assertSame(2, (int) $tenant->run(fn (): mixed => DB::table('spare_parts')->where('id', $partId)->value('stock')));

            $paymentData = $tenant->run(function () use ($sale): array {
                $payment = DB::table('payments')->where('sale_id', $sale->id)->first();
                $attempt = DB::table('payment_attempts')->where('payment_id', $payment->id)->first();

                return compact('payment', 'attempt');
            });
            $this->assertSame('qris', $paymentData['payment']->payment_method);
            $this->assertSame('pending', $paymentData['payment']->status);
            $this->assertSame('pending', $paymentData['attempt']->status);
            $this->assertSame('50000', number_format((float) $paymentData['attempt']->amount, 0, '.', ''));
            $this->assertStringContainsString('540550000', $paymentData['attempt']->qris_payload);
            $this->assertSame(
                $this->crc16(substr($paymentData['attempt']->qris_payload, 0, -4)),
                substr($paymentData['attempt']->qris_payload, -4),
            );
            $this->assertSame(
                now()->addMinutes(15)->toDateTimeString(),
                Carbon::parse($paymentData['attempt']->expires_at)->toDateTimeString(),
            );

            $this->get(route('owner.kasir.payment.show', ['invoice' => $sale->invoice_number]))
                ->assertOk()
                ->assertSee('QRIS Sandbox')
                ->assertSee('Simulasikan pembayaran berhasil')
                ->assertSee('<svg', false);
            $this->get(route('owner.kasir.payment.status', ['invoice' => $sale->invoice_number]))
                ->assertOk()
                ->assertJsonPath('status', 'pending');

            $this->post(route('owner.kasir.payment.simulate', ['invoice' => $sale->invoice_number]))
                ->assertRedirect(route('owner.kasir.payment.show', ['invoice' => $sale->invoice_number]))
                ->assertSessionHas('success');
            $this->get(route('owner.kasir.payment.status', ['invoice' => $sale->invoice_number]))
                ->assertOk()
                ->assertJsonPath('status', 'paid');

            $tenant->run(function () use ($sale): void {
                $this->assertDatabaseHas('sales', [
                    'id' => $sale->id,
                    'status' => 'completed',
                    'amount_paid' => 50000,
                ]);
                $this->assertDatabaseHas('payments', [
                    'sale_id' => $sale->id,
                    'status' => 'completed',
                ]);
                $this->assertDatabaseHas('payment_attempts', [
                    'payment_id' => DB::table('payments')->where('sale_id', $sale->id)->value('id'),
                    'status' => 'succeeded',
                ]);
            });
        } finally {
            $this->deleteTenant($tenant);
        }
    }

    public function test_replaying_checkout_is_idempotent_and_changed_payload_is_rejected(): void
    {
        $records = $this->createCashierTenant('502');
        $tenant = $records['tenant'];
        $cashier = $records['cashier'];

        try {
            $partId = $this->createPart($tenant);
            $payload = $this->qrisCheckoutPayload($partId, '9f9b5488-2ae3-4f3e-b21c-f258f9e904a0');
            $invoice = null;

            for ($attempt = 0; $attempt < 2; $attempt++) {
                $response = $this->actingAs($cashier)->post(route('owner.kasir.checkout'), $payload);
                $invoice = $this->invoiceFor($tenant);
                $response->assertRedirect(route('owner.kasir.payment.show', ['invoice' => $invoice]));
            }

            $changedPayload = $payload;
            $changedPayload['part_quantities'][$partId] = 2;
            $this->from(route('owner.kasir'))->actingAs($cashier)
                ->post(route('owner.kasir.checkout'), $changedPayload)
                ->assertSessionHasErrors('checkout_idempotency_key');

            $tenant->run(function () use ($partId): void {
                $this->assertDatabaseCount('sales', 1);
                $this->assertDatabaseCount('payment_attempts', 1);
                $this->assertDatabaseHas('spare_parts', ['id' => $partId, 'stock' => 2]);
            });
        } finally {
            $this->deleteTenant($tenant);
        }
    }

    public function test_expired_qris_attempt_cannot_be_simulated_as_paid(): void
    {
        $this->freezeTime();
        $records = $this->createCashierTenant('503');
        $tenant = $records['tenant'];
        $cashier = $records['cashier'];

        try {
            $partId = $this->createPart($tenant);
            $this->actingAs($cashier)
                ->post(route('owner.kasir.checkout'), $this->qrisCheckoutPayload(
                    $partId,
                    '5aaf0b2f-76f4-4a0b-9cee-3424c4a4904d',
                ));
            $invoice = $this->invoiceFor($tenant);
            $this->travel(16)->minutes();

            $this->from(route('owner.kasir.payment.show', ['invoice' => $invoice]))
                ->post(route('owner.kasir.payment.simulate', ['invoice' => $invoice]))
                ->assertSessionHasErrors('payment');

            $tenant->run(function () use ($invoice): void {
                $sale = DB::table('sales')->where('invoice_number', $invoice)->first();
                $payment = DB::table('payments')->where('sale_id', $sale->id)->first();
                $attempt = DB::table('payment_attempts')->where('payment_id', $payment->id)->first();

                $this->assertSame('pending', $sale->status);
                $this->assertSame('pending', $payment->status);
                $this->assertSame('expired', $attempt->status);
            });
        } finally {
            $this->deleteTenant($tenant);
        }
    }

    public function test_gateway_failure_keeps_sale_pending_and_allows_a_new_attempt(): void
    {
        $records = $this->createCashierTenant('505');
        $tenant = $records['tenant'];
        $cashier = $records['cashier'];

        try {
            $partId = $this->createPart($tenant);
            config(['services.qris.fake_unavailable' => true]);
            $payload = $this->qrisCheckoutPayload($partId, '93e8da91-21ef-4e42-90c9-c6d947e9fd52');

            $this->actingAs($cashier)
                ->post(route('owner.kasir.checkout'), $payload)
                ->assertRedirect(route('owner.kasir.payment.show', ['invoice' => $this->invoiceFor($tenant)]));

            $sale = $this->saleFor($tenant);
            $tenant->run(function () use ($sale): void {
                $payment = DB::table('payments')->where('sale_id', $sale->id)->first();
                $attempt = DB::table('payment_attempts')->where('payment_id', $payment->id)->first();
                $this->assertSame('pending', $sale->status);
                $this->assertSame('pending', $payment->status);
                $this->assertSame('failed', $attempt->status);
            });

            config(['services.qris.fake_unavailable' => false]);
            $this->post(route('owner.kasir.payment.create', ['invoice' => $sale->invoice_number]))
                ->assertRedirect(route('owner.kasir.payment.show', ['invoice' => $sale->invoice_number]));

            $tenant->run(function () use ($sale): void {
                $payment = DB::table('payments')->where('sale_id', $sale->id)->first();
                $this->assertDatabaseCount('payment_attempts', 2);
                $this->assertDatabaseHas('payment_attempts', [
                    'payment_id' => $payment->id,
                    'attempt_number' => 2,
                    'status' => 'pending',
                ]);
            });
        } finally {
            $this->deleteTenant($tenant);
        }
    }

    public function test_cancelling_unpaid_qris_restores_stock_only_once(): void
    {
        $records = $this->createCashierTenant('508');
        $tenant = $records['tenant'];
        $cashier = $records['cashier'];

        try {
            $partId = $this->createPart($tenant);
            $this->actingAs($cashier)
                ->post(route('owner.kasir.checkout'), $this->qrisCheckoutPayload(
                    $partId,
                    'c9841f1f-6cec-4e31-b123-ded68d35f58e',
                ));
            $invoice = $this->invoiceFor($tenant);
            $cancelUrl = route('owner.kasir.payment.cancel', ['invoice' => $invoice]);

            $this->post($cancelUrl)
                ->assertRedirect(route('owner.kasir.payment.show', ['invoice' => $invoice]))
                ->assertSessionHas('success');
            $this->post($cancelUrl)
                ->assertRedirect(route('owner.kasir.payment.show', ['invoice' => $invoice]));

            $tenant->run(function () use ($invoice, $partId): void {
                $sale = DB::table('sales')->where('invoice_number', $invoice)->first();
                $payment = DB::table('payments')->where('sale_id', $sale->id)->first();

                $this->assertSame('cancelled', $sale->status);
                $this->assertSame('cancelled', $payment->status);
                $this->assertDatabaseHas('payment_attempts', [
                    'payment_id' => $payment->id,
                    'status' => 'cancelled',
                ]);
                $this->assertDatabaseHas('spare_parts', ['id' => $partId, 'stock' => 3]);
                $this->assertDatabaseCount('inventory_movements', 2);
            });
        } finally {
            $this->deleteTenant($tenant);
        }
    }

    public function test_invoice_from_another_tenant_is_not_visible_on_payment_routes(): void
    {
        $firstRecords = $this->createCashierTenant('506');
        $firstTenant = $firstRecords['tenant'];
        $firstCashier = $firstRecords['cashier'];
        $secondRecords = null;

        try {
            $partId = $this->createPart($firstTenant);
            $this->actingAs($firstCashier)
                ->post(route('owner.kasir.checkout'), $this->qrisCheckoutPayload(
                    $partId,
                    '1db75d9a-b119-4c79-8ca6-52df70821e0e',
                ));
            $invoice = $this->invoiceFor($firstTenant);

            $secondRecords = $this->createCashierTenant('507');
            $this->actingAs($secondRecords['cashier'])
                ->get(route('owner.kasir.payment.show', ['invoice' => $invoice]))
                ->assertNotFound();
        } finally {
            $this->deleteTenant($firstTenant);
            if ($secondRecords !== null) {
                $this->deleteTenant($secondRecords['tenant']);
            }
        }
    }

    public function test_bank_transfer_requires_a_bank_and_records_manual_confirmation(): void
    {
        $records = $this->createCashierTenant('504');
        $tenant = $records['tenant'];
        $cashier = $records['cashier'];

        try {
            $partId = $this->createPart($tenant);
            $this->actingAs($cashier)
                ->get(route('owner.kasir'))
                ->assertOk()
                ->assertSee('QRIS Sandbox')
                ->assertSee('BCA')
                ->assertSee('Mandiri');

            $payload = [
                'checkout_idempotency_key' => '0fa681fd-9de9-4fc7-a744-c72eb7a61e88',
                'payment_method' => 'transfer',
                'amount_paid' => 50000,
                'parts' => [$partId],
                'part_quantities' => [$partId => 1],
            ];

            $this->from(route('owner.kasir'))->actingAs($cashier)
                ->post(route('owner.kasir.checkout'), $payload)
                ->assertSessionHasErrors('bank_code');

            $payload['bank_code'] = 'bca';
            $this->actingAs($cashier)
                ->post(route('owner.kasir.checkout'), $payload)
                ->assertRedirect(route('owner.kasir'))
                ->assertSessionHas('success');

            $tenant->run(function (): void {
                $payment = DB::table('payments')->first();
                $this->assertSame('transfer', $payment->payment_method);
                $this->assertSame('completed', $payment->status);
                $this->assertSame('Bank pengirim: BCA', $payment->notes);
            });
        } finally {
            $this->deleteTenant($tenant);
        }
    }

    /**
     * @return array{tenant: Tenant, cashier: User}
     */
    private function createCashierTenant(string $suffix): array
    {
        $phone = '0812987'.$suffix;
        $this->post(route('register.proses'), [
            'username' => 'qrisowner'.$suffix,
            'name' => 'Pemilik QRIS '.$suffix,
            'contact' => $phone,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('user.menu'));

        $this->post(route('tenant.store'), [
            'tenant_name' => 'Bengkel QRIS '.$suffix,
            'subdomain' => 'bengkel-qris-'.$suffix,
            'package' => 'starter',
        ])->assertRedirect(route('owner.home'));

        $tenant = Tenant::query()->findOrFail(auth()->user()->tenant_id);
        $cashier = User::factory()->create([
            'role' => 'Kasir',
            'tenant_id' => $tenant->getTenantKey(),
        ]);

        return compact('tenant', 'cashier');
    }

    private function createPart(Tenant $tenant): int
    {
        return $tenant->run(fn (): int => DB::table('spare_parts')->insertGetId([
            'sku' => 'QRIS-PART-001',
            'name' => 'Oli QRIS',
            'stock' => 3,
            'price' => 50000,
            'category' => 'Oli',
            'unit' => 'botol',
            'minimum_stock' => 1,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]));
    }

    /**
     * @return array<string, mixed>
     */
    private function qrisCheckoutPayload(int $partId, string $idempotencyKey): array
    {
        return [
            'checkout_idempotency_key' => $idempotencyKey,
            'payment_method' => 'qris',
            'parts' => [$partId],
            'part_quantities' => [$partId => 1],
        ];
    }

    private function invoiceFor(Tenant $tenant): string
    {
        return $tenant->run(fn (): string => (string) DB::table('sales')->value('invoice_number'));
    }

    private function saleFor(Tenant $tenant): object
    {
        return $tenant->run(fn (): object => DB::table('sales')->first());
    }

    private function deleteTenant(Tenant $tenant): void
    {
        tenancy()->end();
        DB::purge('tenant');
        $tenant->delete();
    }

    private function crc16(string $data): string
    {
        $crc = 0xFFFF;
        foreach (str_split($data) as $character) {
            $crc ^= ord($character) << 8;
            for ($bit = 0; $bit < 8; $bit++) {
                $crc = ($crc & 0x8000) !== 0
                    ? ($crc << 1) ^ 0x1021
                    : $crc << 1;
                $crc &= 0xFFFF;
            }
        }

        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }
}
