<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Servis - AMAHAY</title>
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

            <!-- Menu Sidebar -->
            <nav class="p-4 space-y-1.5 text-xs">
                <a href="/owner/dashboard" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="/owner/antrean" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>🛠️</span>
                    <span>Antrean Service</span>
                </a>
                <a href="/owner/kasir" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
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
                <a href="/owner/pengingat" class="flex items-center space-x-3 px-4 py-2.5 bg-[#1f2937] text-white rounded-xl font-medium shadow-sm border border-gray-700/50">
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

    <!-- Konten Utama Pengingat Servis -->
    <main class="flex-1 flex min-w-0 flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <header class="min-h-16 h-auto bg-[#111827] border-b border-gray-800 flex flex-col justify-between gap-3 px-4 py-3 lg:flex-row lg:items-center lg:px-8">
            <div class="min-w-0">
                <h1 class="text-xs font-bold text-white tracking-wide uppercase">Pengendali Servis Pelanggan</h1>
                <p class="text-[10px] text-gray-400">Catat jadwal pengingat untuk ditindaklanjuti; pengiriman WhatsApp belum terintegrasi.</p>
            </div>
            <div class="flex items-center space-x-3">
                @if (auth()->user()->role === 'Owner')
                    <details class="relative">
                        <summary class="list-none cursor-pointer bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-2 rounded-xl shadow transition">+ Buat Pengingat Baru</summary>
                        <form method="POST" action="{{ route('owner.pengingat.store') }}" class="absolute right-0 z-30 mt-2 grid w-80 max-w-[90vw] gap-3 rounded-xl border border-gray-700 bg-[#111827] p-4 shadow-xl">
                            @csrf
                            <h2 class="text-xs font-bold text-white">Jadwal pengingat servis</h2>
                            <select name="customer_id" required class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                                <option value="">Pilih pelanggan</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            <select name="vehicle_id" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                                <option value="">Tanpa kendaraan tertentu</option>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" @selected(old('vehicle_id') == $vehicle->id)>{{ $vehicle->license_plate }} · {{ $vehicle->customer_name }}</option>
                                @endforeach
                            </select>
                            <input name="due_date" type="date" value="{{ old('due_date') }}" min="{{ now()->toDateString() }}" required class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            <textarea name="message" rows="3" maxlength="2000" placeholder="Catatan untuk pengingat (opsional)" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">{{ old('message') }}</textarea>
                            @if ($errors->any())
                                <p class="text-xs text-red-400">{{ $errors->first() }}</p>
                            @endif
                            <button type="submit" class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">Simpan jadwal</button>
                        </form>
                    </details>
                @endif
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

        <!-- Area Konten Pengingat -->
        <div class="min-w-0 p-4 sm:p-6 lg:p-8 space-y-6 flex-1">
            @if (session('success'))
                <p role="status" class="rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-xs text-green-300">{{ session('success') }}</p>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Jatuh Tempo</p>
                    <h3 class="text-2xl font-bold text-red-400 mt-1">{{ number_format($overdueCount, 0, ',', '.') }} Pengingat</h3>
                    <p class="text-[10px] text-red-400 font-medium mt-1">Belum terkirim dan jatuh tempo</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Akan Datang (7 Hari)</p>
                    <h3 class="text-2xl font-bold text-yellow-400 mt-1">{{ number_format($upcomingCount, 0, ',', '.') }} Pengingat</h3>
                    <p class="text-[10px] text-yellow-400 font-medium mt-1">Sesuai jadwal yang tersimpan</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Pesan Terkirim</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ number_format($sentCount, 0, ',', '.') }} Pesan</h3>
                    <p class="text-[10px] text-gray-400 font-medium mt-1">Tercatat di database bengkel</p>
                </div>
            </div>

            <section class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-white">Daftar Pengingat Servis</h2>
                    <span class="text-xs text-gray-400">{{ $reminders->total() }} data</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse ($reminders as $reminder)
                        <article class="bg-[#161e2e] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                            <div class="flex justify-between items-start gap-3">
                                <div>
                                    <h3 class="text-sm font-bold text-white">{{ $reminder->customer_name }}</h3>
                                    <p class="text-[10px] text-gray-400 font-mono">{{ $reminder->customer_phone ?: 'Nomor telepon belum tersedia' }}</p>
                                </div>
                                <span class="{{ $reminder->status === 'pending' && $reminder->due_date <= now()->toDateString() ? 'bg-red-500/20 text-red-400' : ($reminder->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400') }} text-[10px] px-2.5 py-1 rounded font-bold">{{ ucfirst($reminder->status) }}</span>
                            </div>
                            <div class="bg-[#111827] p-3 rounded-xl border border-gray-800 text-xs space-y-1">
                                <span class="text-[10px] text-gray-400 block font-mono">{{ trim(($reminder->vehicle_brand ?? '').' '.($reminder->vehicle_model ?? '')) ?: 'Kendaraan tidak ditentukan' }}{{ $reminder->license_plate ? ' ('.$reminder->license_plate.')' : '' }}</span>
                                <p class="text-gray-200 font-medium">{{ $reminder->message ?: 'Tidak ada catatan pengingat.' }}</p>
                                <span class="text-[10px] text-gray-400 block pt-1">Jatuh tempo: {{ \Illuminate\Support\Carbon::parse($reminder->due_date)->format('d M Y') }}</span>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-gray-400">Belum ada pengingat servis di bengkel ini.</p>
                    @endforelse
                </div>
                <div>{{ $reminders->links() }}</div>
            </section>
        </div>
    </main>

</body>
</html>