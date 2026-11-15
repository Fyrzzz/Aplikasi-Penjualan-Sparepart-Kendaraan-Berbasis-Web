<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS - AMAHAY</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#0b0f19] font-sans text-gray-200">
    <main class="mx-auto max-w-3xl space-y-6 px-4 py-8 sm:px-6">
        <header class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-widest text-blue-400">{{ $tenantName }}</p>
                <h1 class="mt-1 text-xl font-bold text-white">Pembayaran transaksi</h1>
            </div>
            <a href="{{ route('owner.kasir') }}" class="rounded-lg border border-gray-700 px-4 py-2 text-xs text-gray-300 hover:bg-gray-800">Kembali ke kasir</a>
        </header>

        @if (session('success'))
            <p role="status" class="rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-xs text-green-300">{{ session('success') }}</p>
        @endif
        @if (session('error'))
            <p role="alert" class="rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-xs text-red-300">{{ session('error') }}</p>
        @endif
        @if ($errors->any())
            <p role="alert" class="rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-xs text-red-300">{{ $errors->first() }}</p>
        @endif

        <section
            class="rounded-2xl border border-gray-800 bg-[#111827] p-5 shadow-lg sm:p-8"
            data-payment-status
            data-status-url="{{ route('owner.kasir.payment.status', ['invoice' => $sale->invoice_number]) }}"
        >
            <div class="flex flex-wrap items-start justify-between gap-3 border-b border-gray-800 pb-4">
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-gray-500">Nomor invoice</p>
                    <p class="mt-1 font-mono text-sm font-bold text-blue-300">{{ $sale->invoice_number }}</p>
                </div>
                <span id="payment-status" class="rounded-full px-3 py-1 text-[10px] font-semibold {{ $payment->status === 'completed' ? 'bg-green-500/15 text-green-300' : 'bg-amber-500/15 text-amber-300' }}">
                    {{ $payment->status === 'completed' ? 'Pembayaran berhasil' : ($payment->status === 'cancelled' ? 'Transaksi dibatalkan' : ($expired ? 'Tagihan kedaluwarsa' : 'Menunggu pembayaran')) }}
                </span>
            </div>

            <div class="mt-5 flex items-center justify-between gap-4">
                <span class="text-xs text-gray-400">Total transaksi</span>
                <strong class="text-lg text-white">Rp {{ number_format($sale->total, 0, ',', '.') }}</strong>
            </div>

            @if ($sandboxEnabled)
                <p class="mt-5 rounded-xl border border-amber-500/30 bg-amber-500/10 p-3 text-[11px] leading-relaxed text-amber-200">
                    QRIS Sandbox untuk pengujian. Tagihan ini tidak terhubung ke merchant atau rekening sungguhan dan tidak menerima uang.
                </p>
            @endif

            @if ($payment->status === 'completed')
                <p class="mt-6 rounded-xl bg-green-500/10 p-4 text-center text-sm font-semibold text-green-300">Transaksi sudah dibayar.</p>
            @elseif ($payment->status === 'cancelled')
                <p class="mt-6 rounded-xl bg-gray-800 p-4 text-center text-sm text-gray-300">Transaksi dibatalkan dan stok telah dikembalikan.</p>
            @elseif ($active && $qrisSvg)
                <div class="mt-6 grid gap-6 sm:grid-cols-[1fr_1.2fr] sm:items-center">
                    <div class="mx-auto rounded-2xl bg-white p-3" aria-label="Kode QRIS sandbox">
                        {!! $qrisSvg !!}
                    </div>
                    <div class="space-y-3">
                        <p class="text-xs font-semibold text-white">Pindai kode QRIS</p>
                        <p class="text-[11px] leading-relaxed text-gray-400">Kode ini hanya untuk simulasi lokal dan mungkin tidak dapat diproses oleh aplikasi bank.</p>
                        <p class="text-[10px] text-gray-500">Referensi: <span class="font-mono text-gray-300">{{ $attempt->payment_reference }}</span></p>
                        <p class="text-xs text-gray-400">Berlaku sampai <span id="qris-countdown" data-expires-at="{{ $expiresAtIso }}" class="font-semibold text-amber-300">--:--</span></p>
                    </div>
                </div>

                @if ($sandboxEnabled)
                    <form method="POST" action="{{ route('owner.kasir.payment.simulate', ['invoice' => $sale->invoice_number]) }}" class="mt-6">
                        @csrf
                        <button type="submit" class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-xs font-bold text-white hover:bg-emerald-700">Simulasikan pembayaran berhasil</button>
                    </form>
                @endif
            @else
                @if ($expired)
                    <p class="mt-6 rounded-xl bg-amber-500/10 p-4 text-center text-xs text-amber-200">Tagihan sebelumnya kedaluwarsa. Buat QRIS baru untuk melanjutkan.</p>
                @elseif ($attempt && $attempt->status === 'failed')
                    <p class="mt-6 rounded-xl bg-red-500/10 p-4 text-center text-xs text-red-200">Gateway sandbox tidak merespons. Anda dapat mencoba kembali.</p>
                @endif

                @if ($sandboxEnabled && $payment->status === 'pending')
                    <form method="POST" action="{{ route('owner.kasir.payment.create', ['invoice' => $sale->invoice_number]) }}" class="mt-6">
                        @csrf
                        <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-3 text-xs font-bold text-white hover:bg-blue-700">
                            {{ $attempt ? 'Buat QRIS baru' : 'Buat tagihan QRIS' }}
                        </button>
                    </form>
                @else
                    <p class="mt-6 rounded-xl bg-gray-800 p-4 text-center text-xs text-gray-300">Gateway QRIS belum dikonfigurasi untuk lingkungan ini.</p>
                @endif
            @endif

            @if ($payment->status === 'pending')
                <form method="POST" action="{{ route('owner.kasir.payment.cancel', ['invoice' => $sale->invoice_number]) }}" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full rounded-xl border border-red-500/40 px-4 py-3 text-xs font-semibold text-red-300 hover:bg-red-500/10">Batalkan transaksi & kembalikan stok</button>
                </form>
            @endif
        </section>
    </main>

    <script>
        (() => {
            const paymentPanel = document.querySelector('[data-payment-status]');
            const statusLabel = document.getElementById('payment-status');
            const countdown = document.getElementById('qris-countdown');
            let reloaded = false;

            if (countdown) {
                const expiresAt = new Date(countdown.dataset.expiresAt).getTime();
                const updateCountdown = () => {
                    const secondsLeft = Math.max(0, Math.floor((expiresAt - Date.now()) / 1000));
                    const minutes = Math.floor(secondsLeft / 60).toString().padStart(2, '0');
                    const seconds = (secondsLeft % 60).toString().padStart(2, '0');
                    countdown.textContent = `${minutes}:${seconds}`;
                };
                updateCountdown();
                window.setInterval(updateCountdown, 1000);
            }

            const refreshPaymentStatus = async () => {
                try {
                    const response = await fetch(paymentPanel.dataset.statusUrl, {
                        headers: { Accept: 'application/json' },
                        credentials: 'same-origin',
                    });
                    if (!response.ok) {
                        throw new Error('Status pembayaran tidak dapat diperbarui.');
                    }

                    const result = await response.json();
                    if (result.status === 'paid' || result.status === 'expired' || result.status === 'cancelled') {
                        if (!reloaded) {
                            reloaded = true;
                            window.location.reload();
                        }
                    }
                } catch (error) {
                    statusLabel.textContent = 'Status pembayaran sementara tidak dapat diperbarui.';
                }
            };

            window.setInterval(refreshPaymentStatus, 3000);
        })();
    </script>
</body>
</html>
