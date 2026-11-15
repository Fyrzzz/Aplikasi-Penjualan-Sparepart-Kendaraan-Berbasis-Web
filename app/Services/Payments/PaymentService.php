<?php

namespace App\Services\Payments;

use App\Services\Payments\Contracts\PaymentGateway;
use App\Services\Payments\Data\PaymentChargeRequest;
use App\Services\Payments\Data\QrisCharge;
use App\Services\Payments\Exceptions\GatewayUnavailableException;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use RuntimeException;

final class PaymentService
{
    private const ATTEMPT_DURATION_MINUTES = 15;

    private const GATEWAY_RETRIES = 3;

    public function __construct(private PaymentGateway $gateway) {}

    public function createQrisAttempt(int $paymentId): object
    {
        if (! config('services.qris.sandbox_enabled')) {
            throw ValidationException::withMessages([
                'payment_method' => 'Pembayaran QRIS belum dikonfigurasi untuk lingkungan ini.',
            ]);
        }

        $attemptContext = DB::transaction(function () use ($paymentId): array {
            $payment = DB::table('payments')
                ->where('id', $paymentId)
                ->lockForUpdate()
                ->first();
            abort_if($payment === null, 404);

            if ($payment->payment_method !== 'qris') {
                throw ValidationException::withMessages([
                    'payment' => 'Metode pembayaran ini bukan QRIS.',
                ]);
            }

            $sale = DB::table('sales')
                ->where('id', $payment->sale_id)
                ->lockForUpdate()
                ->first();
            abort_if($sale === null, 404);

            $latestAttempt = DB::table('payment_attempts')
                ->where('payment_id', $paymentId)
                ->orderByDesc('attempt_number')
                ->first();

            if ($payment->status === 'completed') {
                if ($latestAttempt !== null) {
                    return ['attempt' => $latestAttempt];
                }

                throw ValidationException::withMessages([
                    'payment' => 'Pembayaran sudah selesai.',
                ]);
            }

            if ($payment->status !== 'pending' || $sale->status !== 'pending') {
                throw ValidationException::withMessages([
                    'payment' => 'Transaksi tidak lagi menunggu pembayaran.',
                ]);
            }

            if (round((float) $sale->total, 2) !== round((float) $payment->amount, 2)) {
                throw ValidationException::withMessages([
                    'payment' => 'Nominal pembayaran tidak sesuai dengan total transaksi.',
                ]);
            }

            if ($latestAttempt !== null
                && in_array($latestAttempt->status, ['creating', 'pending'], true)
                && $latestAttempt->expires_at !== null
                && CarbonImmutable::parse($latestAttempt->expires_at)->isFuture()) {
                if ($latestAttempt->status === 'pending') {
                    return ['attempt' => $latestAttempt];
                }

                return [
                    'attempt_id' => (int) $latestAttempt->id,
                    'payment_reference' => $latestAttempt->payment_reference,
                    'idempotency_key' => $latestAttempt->idempotency_key,
                    'amount' => (int) round((float) $payment->amount),
                    'expires_at' => CarbonImmutable::parse($latestAttempt->expires_at),
                ];
            }

            if ($latestAttempt !== null && $latestAttempt->status === 'pending') {
                DB::table('payment_attempts')
                    ->where('id', $latestAttempt->id)
                    ->update(['status' => 'expired', 'updated_at' => now()]);
            }

            $attemptNumber = (int) DB::table('payment_attempts')
                ->where('payment_id', $paymentId)
                ->max('attempt_number') + 1;
            $paymentReference = 'PAY-'.Str::upper((string) Str::ulid());
            $expiresAt = now()->toImmutable()->addMinutes(self::ATTEMPT_DURATION_MINUTES);
            $attemptId = DB::table('payment_attempts')->insertGetId([
                'payment_id' => $paymentId,
                'attempt_number' => $attemptNumber,
                'payment_reference' => $paymentReference,
                'idempotency_key' => $paymentReference,
                'provider' => 'fake_qris',
                'status' => 'creating',
                'amount' => $payment->amount,
                'expires_at' => $expiresAt,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return [
                'attempt_id' => $attemptId,
                'payment_reference' => $paymentReference,
                'idempotency_key' => $paymentReference,
                'amount' => (int) round((float) $payment->amount),
                'expires_at' => $expiresAt,
            ];
        }, attempts: 3);

        if (isset($attemptContext['attempt'])) {
            return $attemptContext['attempt'];
        }

        $charge = $this->createChargeWithRetries($attemptContext);
        if ($charge->paymentReference !== $attemptContext['payment_reference']
            || $charge->amount !== $attemptContext['amount']
            || ! $charge->expiresAt->equalTo($attemptContext['expires_at'])) {
            DB::table('payment_attempts')
                ->where('id', $attemptContext['attempt_id'])
                ->update(['status' => 'failed', 'updated_at' => now()]);

            throw new RuntimeException('QRIS gateway returned an inconsistent charge.');
        }

        DB::table('payment_attempts')
            ->where('id', $attemptContext['attempt_id'])
            ->where('status', 'creating')
            ->update([
                'provider_reference' => $charge->providerReference,
                'qris_payload' => $charge->payload,
                'status' => 'pending',
                'updated_at' => now(),
            ]);

        return DB::table('payment_attempts')->where('id', $attemptContext['attempt_id'])->first();
    }

    public function simulateSandboxPayment(int $paymentId): void
    {
        if (! config('services.qris.sandbox_enabled')) {
            abort(404);
        }

        $attemptExpired = DB::transaction(function () use ($paymentId): bool {
            $payment = DB::table('payments')
                ->where('id', $paymentId)
                ->lockForUpdate()
                ->first();
            abort_if($payment === null, 404);

            $sale = DB::table('sales')
                ->where('id', $payment->sale_id)
                ->lockForUpdate()
                ->first();
            abort_if($sale === null, 404);

            if ($payment->status === 'completed' && $sale->status === 'completed') {
                return false;
            }

            if ($payment->payment_method !== 'qris'
                || $payment->status !== 'pending'
                || $sale->status !== 'pending') {
                throw ValidationException::withMessages([
                    'payment' => 'Transaksi tidak lagi menunggu pembayaran.',
                ]);
            }

            $attempt = DB::table('payment_attempts')
                ->where('payment_id', $paymentId)
                ->orderByDesc('attempt_number')
                ->lockForUpdate()
                ->first();
            abort_if($attempt === null, 404);

            if ($attempt->status !== 'pending') {
                throw ValidationException::withMessages([
                    'payment' => 'Tagihan QRIS tidak lagi aktif.',
                ]);
            }

            if ($attempt->expires_at === null || ! CarbonImmutable::parse($attempt->expires_at)->isFuture()) {
                DB::table('payment_attempts')
                    ->where('id', $attempt->id)
                    ->update(['status' => 'expired', 'updated_at' => now()]);

                return true;
            }

            if (round((float) $sale->total, 2) !== round((float) $payment->amount, 2)) {
                throw ValidationException::withMessages([
                    'payment' => 'Nominal pembayaran tidak sesuai dengan total transaksi.',
                ]);
            }

            $now = now();
            DB::table('payment_attempts')->where('id', $attempt->id)->update([
                'status' => 'succeeded',
                'updated_at' => $now,
            ]);
            DB::table('payments')->where('id', $paymentId)->update([
                'status' => 'completed',
                'paid_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('sales')->where('id', $sale->id)->update([
                'status' => 'completed',
                'amount_paid' => $payment->amount,
                'change_due' => 0,
                'sold_at' => $now,
                'updated_at' => $now,
            ]);

            return false;
        }, attempts: 3);

        if ($attemptExpired) {
            throw ValidationException::withMessages([
                'payment' => 'Tagihan QRIS telah kedaluwarsa. Buat tagihan baru.',
            ]);
        }
    }

    public function cancelUnpaidQrisPayment(int $paymentId, int $centralUserId): void
    {
        DB::transaction(function () use ($paymentId, $centralUserId): void {
            $payment = DB::table('payments')
                ->where('id', $paymentId)
                ->lockForUpdate()
                ->first();
            abort_if($payment === null, 404);

            $sale = DB::table('sales')
                ->where('id', $payment->sale_id)
                ->lockForUpdate()
                ->first();
            abort_if($sale === null, 404);

            if ($payment->status === 'cancelled' && $sale->status === 'cancelled') {
                return;
            }

            if ($payment->payment_method !== 'qris'
                || $payment->status !== 'pending'
                || $sale->status !== 'pending') {
                throw ValidationException::withMessages([
                    'payment' => 'Transaksi ini tidak dapat dibatalkan.',
                ]);
            }

            $now = now();
            $items = DB::table('sale_items')
                ->where('sale_id', $sale->id)
                ->whereNotNull('spare_part_id')
                ->orderBy('spare_part_id')
                ->get(['spare_part_id', 'quantity']);

            foreach ($items as $item) {
                $part = DB::table('spare_parts')
                    ->where('id', $item->spare_part_id)
                    ->lockForUpdate()
                    ->first();
                if ($part === null) {
                    continue;
                }

                $quantity = (float) $item->quantity;
                $stockBefore = (float) $part->stock;
                $stockAfter = $stockBefore + $quantity;

                DB::table('spare_parts')->where('id', $part->id)->update([
                    'stock' => $stockAfter,
                    'updated_at' => $now,
                ]);
                DB::table('inventory_movements')->insert([
                    'spare_part_id' => $part->id,
                    'movement_type' => 'sale_reversal',
                    'quantity' => $quantity,
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'reference_type' => 'sale',
                    'reference_id' => $sale->id,
                    'central_user_id' => $centralUserId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table('payment_attempts')
                ->where('payment_id', $paymentId)
                ->whereIn('status', ['creating', 'pending', 'failed', 'expired'])
                ->update(['status' => 'cancelled', 'updated_at' => $now]);
            DB::table('payments')->where('id', $paymentId)->update([
                'status' => 'cancelled',
                'updated_at' => $now,
            ]);
            DB::table('sales')->where('id', $sale->id)->update([
                'status' => 'cancelled',
                'updated_at' => $now,
            ]);
        }, attempts: 3);
    }

    /**
     * @param  array{attempt_id: int, payment_reference: string, idempotency_key: string, amount: int, expires_at: CarbonImmutable}  $attemptContext
     */
    private function createChargeWithRetries(array $attemptContext): QrisCharge
    {
        for ($attemptNumber = 1; $attemptNumber <= self::GATEWAY_RETRIES; $attemptNumber++) {
            try {
                return $this->gateway->createQrisCharge(new PaymentChargeRequest(
                    paymentReference: $attemptContext['payment_reference'],
                    idempotencyKey: $attemptContext['idempotency_key'],
                    amount: $attemptContext['amount'],
                    expiresAt: $attemptContext['expires_at'],
                ));
            } catch (GatewayUnavailableException $exception) {
                if ($attemptNumber === self::GATEWAY_RETRIES) {
                    DB::table('payment_attempts')
                        ->where('id', $attemptContext['attempt_id'])
                        ->where('status', 'creating')
                        ->update(['status' => 'failed', 'updated_at' => now()]);

                    throw $exception;
                }
            }
        }

        throw new RuntimeException('QRIS gateway retry limit was exceeded.');
    }
}
