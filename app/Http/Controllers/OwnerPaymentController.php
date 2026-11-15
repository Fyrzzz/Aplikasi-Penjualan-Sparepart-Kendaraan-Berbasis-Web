<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Services\Payments\Exceptions\GatewayUnavailableException;
use App\Services\Payments\PaymentService;
use App\Services\Payments\QrisSvgRenderer;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OwnerPaymentController extends Controller
{
    public function show(string $invoice, QrisSvgRenderer $renderer): View
    {
        $tenant = $this->currentTenant();
        $data = $tenant->run(function () use ($invoice): array {
            $sale = DB::table('sales')->where('invoice_number', $invoice)->first();
            abort_if($sale === null, 404);

            $payment = DB::table('payments')->where('sale_id', $sale->id)->first();
            abort_if($payment === null || $payment->payment_method !== 'qris', 404);

            $attempt = DB::table('payment_attempts')
                ->where('payment_id', $payment->id)
                ->orderByDesc('attempt_number')
                ->first();
            $expiresAt = $attempt?->expires_at !== null
                ? CarbonImmutable::parse($attempt->expires_at)
                : null;
            $expired = $attempt !== null
                && ($attempt->status === 'expired'
                    || ($attempt->status === 'pending' && ($expiresAt === null || ! $expiresAt->isFuture())));
            $active = $attempt !== null
                && $attempt->status === 'pending'
                && $attempt->qris_payload !== null
                && ! $expired;

            return [
                'sale' => $sale,
                'payment' => $payment,
                'attempt' => $attempt,
                'expiresAtIso' => $expiresAt?->toIso8601String(),
                'expired' => $expired,
                'active' => $active,
            ];
        });

        return view('tenant.pembayaran', [
            'tenantName' => $tenant->getAttribute('tenant_name'),
            'sandboxEnabled' => (bool) config('services.qris.sandbox_enabled'),
            'qrisSvg' => $data['active'] && config('services.qris.sandbox_enabled')
                ? $renderer->svg((string) $data['attempt']->qris_payload)
                : null,
            ...$data,
        ]);
    }

    public function create(string $invoice, PaymentService $paymentService): RedirectResponse
    {
        $tenant = $this->currentTenant();

        try {
            $tenant->run(function () use ($invoice, $paymentService): void {
                $payment = $this->qrisPaymentForInvoice($invoice);
                $paymentService->createQrisAttempt((int) $payment->id);
            });
        } catch (GatewayUnavailableException $exception) {
            report($exception);

            return redirect()
                ->route('owner.kasir.payment.show', ['invoice' => $invoice])
                ->with('error', 'QRIS sandbox sedang mengalami gangguan. Coba buat tagihan kembali.');
        }

        return redirect()
            ->route('owner.kasir.payment.show', ['invoice' => $invoice])
            ->with('success', 'Tagihan QRIS sandbox berhasil dibuat.');
    }

    public function simulate(string $invoice, PaymentService $paymentService): RedirectResponse
    {
        $tenant = $this->currentTenant();
        $tenant->run(function () use ($invoice, $paymentService): void {
            $payment = $this->qrisPaymentForInvoice($invoice);
            $paymentService->simulateSandboxPayment((int) $payment->id);
        });

        return redirect()
            ->route('owner.kasir.payment.show', ['invoice' => $invoice])
            ->with('success', 'Pembayaran sandbox berhasil disimulasikan.');
    }

    public function cancel(Request $request, string $invoice, PaymentService $paymentService): RedirectResponse
    {
        $tenant = $this->currentTenant();
        $tenant->run(function () use ($request, $invoice, $paymentService): void {
            $payment = $this->qrisPaymentForInvoice($invoice);
            $paymentService->cancelUnpaidQrisPayment((int) $payment->id, (int) $request->user()->id);
        });

        return redirect()
            ->route('owner.kasir.payment.show', ['invoice' => $invoice])
            ->with('success', 'Transaksi dibatalkan dan stok sparepart dikembalikan.');
    }

    public function status(string $invoice): JsonResponse
    {
        $tenant = $this->currentTenant();
        $status = $tenant->run(function () use ($invoice): array {
            $sale = DB::table('sales')->where('invoice_number', $invoice)->first();
            abort_if($sale === null, 404);

            $payment = DB::table('payments')->where('sale_id', $sale->id)->first();
            abort_if($payment === null || $payment->payment_method !== 'qris', 404);

            $attempt = DB::table('payment_attempts')
                ->where('payment_id', $payment->id)
                ->orderByDesc('attempt_number')
                ->first();
            $expired = $attempt !== null
                && ($attempt->status === 'expired'
                    || ($attempt->status === 'pending'
                        && ($attempt->expires_at === null
                            || ! CarbonImmutable::parse($attempt->expires_at)->isFuture())));

            return [
                'status' => $payment->status === 'completed'
                    ? 'paid'
                    : ($payment->status === 'cancelled' ? 'cancelled' : ($expired ? 'expired' : 'pending')),
            ];
        });

        return response()->json($status)->header('Cache-Control', 'no-store');
    }

    private function qrisPaymentForInvoice(string $invoice): object
    {
        $sale = DB::table('sales')->where('invoice_number', $invoice)->first();
        abort_if($sale === null, 404);

        $payment = DB::table('payments')->where('sale_id', $sale->id)->first();
        abort_if($payment === null || $payment->payment_method !== 'qris', 404);

        return $payment;
    }

    private function currentTenant(): Tenant
    {
        return Tenant::query()->findOrFail(auth()->user()->tenant_id);
    }
}
