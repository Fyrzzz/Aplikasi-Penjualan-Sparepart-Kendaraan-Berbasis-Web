<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir / POS - AMAHAY</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex">

    <!-- Sidebar Tenant -->
    <aside class="w-64 bg-[#111827] border-r border-gray-800 flex flex-col justify-between hidden md:flex">
        <div>
            <!-- Brand / Logo -->
            <div class="h-16 flex items-center px-6 border-b border-gray-800 space-x-3">
                <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.9 6.9a2.12 2.12 0 1 1-3-3l6.9-6.9a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-sm font-bold tracking-wider text-white block">AMAHAY</span>
                    <span class="text-[10px] text-gray-400 block">Bengkel & POS System</span>
                </div>
            </div>

            <!-- Menu Sidebar (Sudah diarahkan ke /owner/mekanik) -->
            <nav class="p-4 space-y-1.5 text-xs">
                <a href="/owner/dashboard" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="/owner/antrean" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>🛠️</span>
                    <span>Antrean Service</span>
                </a>
                <a href="/owner/kasir" class="flex items-center space-x-3 px-4 py-2.5 bg-[#1f2937] text-white rounded-xl font-medium shadow-sm border border-gray-700/50">
                    <span>💰</span>
                    <span>Kasir / POS</span>
                </a>
                <a href="/owner/stok" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>📦</span>
                    <span>Stok Sparepart</span>
                </a>
                <a href="/owner/mekanik" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>👥</span>
                    <span>Pelanggan & Mekanik</span>
                </a>
                <a href="/owner/pengingat" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>🔔</span>
                    <span>Pengingat Service</span>
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-gray-800">
            <div class="flex items-center space-x-3 bg-[#161e2e] p-2.5 rounded-xl border border-gray-800">
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold flex items-center justify-center text-xs">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <div class="text-xs">
                    <p class="font-bold text-white">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-gray-400">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Konten Utama Kasir / POS -->
    <main class="flex-1 flex min-w-0 flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <header class="min-h-16 h-auto bg-[#111827] border-b border-gray-800 flex flex-col justify-between gap-3 px-4 py-3 lg:flex-row lg:items-center lg:px-8">
            <h1 class="text-xs font-bold text-white tracking-wide uppercase">Kasir / POS</h1>
            <div class="flex w-full flex-col gap-2 sm:flex-row sm:items-center sm:gap-4 lg:w-1/2">
                <input type="text" placeholder="Cari nama, kode sparepart, skuter, atau jasa servis..." class="w-full bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-1.5 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                <span class="text-xs bg-green-500/20 text-green-400 px-3 py-1.5 rounded-xl border border-green-500/30 font-bold whitespace-nowrap">Remote</span>
            </div>
        </header>

        <nav aria-label="Navigasi tenant" class="md:hidden flex items-center gap-2 overflow-x-auto border-b border-gray-800 bg-[#111827] px-4 py-3 text-xs text-gray-400">
            <a href="{{ route('owner.home') }}" class="shrink-0 rounded-lg px-3 py-2 {{ request()->routeIs('owner.home') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white' }}">Dashboard</a>
            <a href="{{ route('owner.antrean') }}" class="shrink-0 rounded-lg px-3 py-2 {{ request()->routeIs('owner.antrean') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white' }}">Antrean</a>
            <a href="{{ route('owner.kasir') }}" class="shrink-0 rounded-lg px-3 py-2 {{ request()->routeIs('owner.kasir') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white' }}">Kasir</a>
            <a href="{{ route('owner.stok') }}" class="shrink-0 rounded-lg px-3 py-2 {{ request()->routeIs('owner.stok') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white' }}">Stok</a>
            <a href="{{ route('owner.mekanik') }}" class="shrink-0 rounded-lg px-3 py-2 {{ request()->routeIs('owner.mekanik') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white' }}">Pelanggan & Mekanik</a>
            <a href="{{ route('owner.pengingat') }}" class="shrink-0 rounded-lg px-3 py-2 {{ request()->routeIs('owner.pengingat') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white' }}">Pengingat</a>
            <a href="{{ route('user.menu') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Akun Utama</a>
        </nav>

        <!-- Area Transaksi Layout 2 Kolom -->
        <form method="POST" action="{{ route('owner.kasir.checkout') }}" class="min-w-0 p-4 sm:p-6 lg:p-8 grid grid-cols-1 lg:grid-cols-3 gap-6 flex-1">
            @csrf
            <div class="lg:col-span-2 space-y-5">
                @if (session('success'))
                    <p role="status" class="rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-xs text-green-300">{{ session('success') }}</p>
                @endif
                @if ($errors->any())
                    <p role="alert" class="rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-xs text-red-300">{{ $errors->first() }}</p>
                @endif
                <section class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Katalog Sparepart</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse ($parts as $part)
                            <article class="bg-[#161e2e] border border-gray-800 p-4 rounded-2xl">
                                <div class="flex justify-between gap-3">
                                    <div>
                                        <p class="text-xs font-bold text-white">{{ $part->name }}</p>
                                        <p class="text-[10px] text-gray-400 font-mono">{{ $part->sku }}</p>
                                    </div>
                                    <span class="text-[10px] {{ $part->stock > 0 ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }} px-2 py-0.5 rounded font-medium">Stok: {{ number_format($part->stock, 0, ',', '.') }} {{ $part->unit }}</span>
                                </div>
                                <p class="text-sm font-bold text-green-400 mt-4">Rp {{ number_format($part->price, 0, ',', '.') }}</p>
                                <div class="mt-3 flex items-center justify-between gap-3">
                                    <label class="flex items-center gap-2 text-[10px] text-gray-300">
                                        <input type="checkbox" name="parts[]" value="{{ $part->id }}" class="rounded border-gray-600 bg-gray-900 text-blue-600">
                                        Pilih barang
                                    </label>
                                    <input type="number" name="part_quantities[{{ $part->id }}]" value="1" min="1" max="1000" step="1" aria-label="Jumlah {{ $part->name }}" class="w-20 rounded-lg border border-gray-700 bg-[#1f2937] px-2 py-1.5 text-xs text-white">
                                </div>
                            </article>
                        @empty
                            <p class="text-xs text-gray-400">Belum ada sparepart aktif di bengkel ini.</p>
                        @endforelse
                    </div>
                </section>

                <section class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Katalog Jasa Servis</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse ($services as $service)
                            <article class="bg-[#161e2e] border border-gray-800 p-4 rounded-2xl">
                                <p class="text-xs font-bold text-white">{{ $service->name }}</p>
                                <p class="text-[10px] text-gray-400 font-mono">{{ $service->service_code ?: 'Jasa servis' }}</p>
                                <p class="text-sm font-bold text-green-400 mt-4">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
                                <label class="mt-3 flex items-center gap-2 text-[10px] text-gray-300">
                                    <input type="checkbox" name="services[]" value="{{ $service->id }}" class="rounded border-gray-600 bg-gray-900 text-blue-600">
                                    Pilih jasa
                                </label>
                            </article>
                        @empty
                            <p class="text-xs text-gray-400">Belum ada jasa aktif di bengkel ini.</p>
                        @endforelse
                    </div>
                </section>
            </div>

            <div class="space-y-6">
                <section class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-white border-b border-gray-800 pb-3">Selesaikan Transaksi</h2>
                    <label class="block space-y-1 text-[10px] text-gray-400">
                        <span>Pelanggan (opsional)</span>
                        <select name="customer_id" class="w-full rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            <option value="">Pelanggan umum</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->name }}{{ $customer->phone ? ' · '.$customer->phone : '' }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block space-y-1 text-[10px] text-gray-400">
                        <span>Metode pembayaran</span>
                        <select name="payment_method" required class="w-full rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            <option value="cash" @selected(old('payment_method', 'cash') === 'cash')>Tunai</option>
                            <option value="transfer" @selected(old('payment_method') === 'transfer')>Transfer (dicatat manual)</option>
                            <option value="qris" @selected(old('payment_method') === 'qris')>QRIS (dicatat manual)</option>
                        </select>
                    </label>
                    <label class="block space-y-1 text-[10px] text-gray-400">
                        <span>Jumlah diterima</span>
                        <input type="number" name="amount_paid" min="0" step="0.01" value="{{ old('amount_paid') }}" required class="w-full rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                    </label>
                    <p class="text-[10px] text-gray-500">Total dihitung ulang dari harga katalog dan stok saat transaksi disimpan.</p>
                    <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white hover:bg-blue-700">Simpan & Catat Pembayaran</button>
                </section>

                <section class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-white border-b border-gray-800 pb-3 mb-4">Transaksi Terakhir</h2>
                    <div class="space-y-3">
                        @forelse ($recentSales as $sale)
                            <article class="bg-[#161e2e] border border-gray-800 rounded-xl p-3.5 space-y-2">
                                <div class="flex justify-between gap-2 text-[10px]">
                                    <span class="font-mono font-bold text-blue-400">{{ $sale->invoice_number }}</span>
                                    <span class="text-gray-400">{{ ucfirst($sale->status) }}</span>
                                </div>
                                <p class="text-xs font-bold text-white">{{ $sale->customer_name ?: 'Pelanggan umum' }}</p>
                                <p class="text-[10px] text-gray-400">{{ $sale->sold_at ? \Illuminate\Support\Carbon::parse($sale->sold_at)->format('d M Y H:i') : 'Belum dibayar' }}</p>
                                <p class="text-sm font-bold text-green-400">Rp {{ number_format($sale->total, 0, ',', '.') }}</p>
                            </article>
                        @empty
                            <p class="py-6 text-center text-xs text-gray-400">Belum ada transaksi di bengkel ini.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </form>
    </main>

</body>
</html>