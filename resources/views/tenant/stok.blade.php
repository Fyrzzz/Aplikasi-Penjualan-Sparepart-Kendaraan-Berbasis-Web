<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok & Inventaris - AMAHAY</title>
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

            <!-- Menu Sidebar (Sudah diperbaiki ke /owner/mekanik) -->
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
                <a href="/owner/stok" class="flex items-center space-x-3 px-4 py-2.5 bg-[#1f2937] text-white rounded-xl font-medium shadow-sm border border-gray-700/50">
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

    <!-- Konten Utama Stok & Inventaris -->
    <main class="flex-1 flex min-w-0 flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <header class="min-h-16 h-auto bg-[#111827] border-b border-gray-800 flex flex-col justify-between gap-3 px-4 py-3 lg:flex-row lg:items-center lg:px-8">
            <div class="min-w-0">
                <h1 class="text-xs font-bold text-white tracking-wide uppercase">Stok & Inventaris Sparepart</h1>
                <p class="text-[10px] text-gray-400">Monitoring ketersediaan suku cadang, lokasi rak penyimpanan, dan status kritis gudang.</p>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3">
                <button type="button" onclick="window.print()" class="bg-[#1f2937] hover:bg-gray-700 text-gray-200 text-xs font-medium px-4 py-2 rounded-xl border border-gray-700 transition">
                    Cetak Stok (PDF)
                </button>
                @if (auth()->user()->role === 'Owner')
                    <details class="relative">
                        <summary class="list-none cursor-pointer bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-2 rounded-xl shadow transition">
                            + Tambah Barang Baru
                        </summary>
                        <form method="POST" action="{{ route('owner.stok.store') }}" class="absolute right-0 z-30 mt-2 grid w-80 max-w-[90vw] gap-3 rounded-xl border border-gray-700 bg-[#111827] p-4 shadow-xl">
                            @csrf
                            <h2 class="text-xs font-bold text-white">Tambah sparepart</h2>
                            <input name="sku" value="{{ old('sku') }}" required maxlength="255" placeholder="Kode SKU" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            <input name="name" value="{{ old('name') }}" required maxlength="255" placeholder="Nama sparepart" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            <div class="grid grid-cols-2 gap-2">
                                <input name="stock" type="number" value="{{ old('stock', 0) }}" min="0" required placeholder="Stok awal" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                                <input name="price" type="number" value="{{ old('price') }}" min="0" step="0.01" required placeholder="Harga" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <input name="category" value="{{ old('category') }}" maxlength="255" placeholder="Kategori" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                                <input name="unit" value="{{ old('unit', 'pcs') }}" maxlength="50" required placeholder="Satuan" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <input name="minimum_stock" type="number" value="{{ old('minimum_stock', 0) }}" min="0" required placeholder="Batas stok minimum" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                                <input name="location" value="{{ old('location') }}" maxlength="255" placeholder="Lokasi rak" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            </div>
                            @if ($errors->any())
                                <p class="text-xs text-red-400">{{ $errors->first() }}</p>
                            @endif
                            <button type="submit" class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">Simpan sparepart</button>
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

        <!-- Area Konten Stok -->
        <div class="min-w-0 p-4 sm:p-6 lg:p-8 space-y-6 flex-1">
            @if (session('success'))
                <p role="status" class="rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-xs text-green-300">{{ session('success') }}</p>
            @endif
            
            <!-- 4 Kartu Ringkasan Metrik Atas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Item SKU</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ number_format($totalParts, 0, ',', '.') }}</h3>
                    <p class="text-[10px] text-blue-400 font-medium mt-1">📦 Terdaftar di sistem</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Stok Menipis</p>
                    <h3 class="text-2xl font-bold text-yellow-400 mt-1">{{ number_format($lowStockCount, 0, ',', '.') }} Item</h3>
                    <p class="text-[10px] text-yellow-400 font-medium mt-1">⚠️ Perlu restock segera</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Stok Habis</p>
                    <h3 class="text-2xl font-bold text-red-400 mt-1">{{ number_format($outOfStockCount, 0, ',', '.') }} Item</h3>
                    <p class="text-[10px] text-red-400 font-medium mt-1">🚨 Kosong di gudang</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Estimasi Nilai Aset</p>
                    <h3 class="text-xl font-bold text-green-400 mt-1">Rp {{ number_format($stockValue, 0, ',', '.') }}</h3>
                    <p class="text-[10px] text-gray-400 font-medium mt-1">💰 Total valuasi gudang</p>
                </div>
            </div>

            <!-- Tabel Data Stok Lengkap -->
            <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <form method="GET" action="{{ route('owner.stok') }}">
                            <input name="search" value="{{ $search }}" type="search" placeholder="Cari nama atau kode SKU..." class="bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-1.5 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 w-64">
                        </form>
                    </div>
                    <div class="flex items-center space-x-2 text-xs">
                        <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded-lg border border-blue-500/30 font-medium">Semua ({{ number_format($totalParts, 0, ',', '.') }})</span>
                        <span class="bg-[#1f2937] text-gray-400 px-3 py-1 rounded-lg border border-gray-700">Stok Kritis ({{ number_format($lowStockCount + $outOfStockCount, 0, ',', '.') }})</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-300">
                        <thead class="bg-[#161e2e] text-gray-400 uppercase text-[10px] tracking-wider border-b border-gray-800">
                            <tr>
                                <th class="px-4 py-3 rounded-l-lg">No. SKU</th>
                                <th class="px-4 py-3">Nama Suku Cadang</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Rak / Lokasi</th>
                                <th class="px-4 py-3">Harga Jual</th>
                                <th class="px-4 py-3">Sisa Stok</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 rounded-r-lg text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse ($parts as $part)
                                @php
                                    $outOfStock = $part->stock <= 0;
                                    $lowStock = !$outOfStock && $part->stock <= $part->minimum_stock;
                                @endphp
                                <tr class="hover:bg-[#161e2e]/50 transition">
                                    <td class="px-4 py-3 font-mono font-bold text-blue-400">{{ $part->sku }}</td>
                                    <td class="px-4 py-3 font-bold text-white">{{ $part->name }}</td>
                                    <td class="px-4 py-3 text-gray-400">{{ $part->category ?: '-' }}</td>
                                    <td class="px-4 py-3">{{ $part->location ?: '-' }}</td>
                                    <td class="px-4 py-3 font-mono">Rp {{ number_format($part->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 font-bold {{ $outOfStock ? 'text-red-400' : ($lowStock ? 'text-yellow-400' : 'text-white') }}">{{ number_format($part->stock, 0, ',', '.') }} {{ $part->unit }}</td>
                                    <td class="px-4 py-3">
                                        <span class="{{ $outOfStock ? 'bg-red-500/20 text-red-400' : ($lowStock ? 'bg-yellow-500/20 text-yellow-400' : 'bg-green-500/20 text-green-400') }} px-2.5 py-1 rounded-md text-[10px] font-bold">
                                            {{ $outOfStock ? 'Habis' : ($lowStock ? 'Menipis' : 'Aman') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if (auth()->user()->role === 'Owner')
                                            <details class="inline-block text-left">
                                                <summary class="cursor-pointer rounded-lg border border-gray-700 px-3 py-1.5 text-[10px] text-gray-300 hover:bg-gray-700">Atur stok</summary>
                                                <form method="POST" action="{{ route('owner.stok.adjust', $part->id) }}" class="absolute z-20 mt-2 grid w-64 gap-2 rounded-xl border border-gray-700 bg-[#111827] p-3 shadow-xl">
                                                    @csrf
                                                    @method('PATCH')
                                                    <label class="text-[10px] text-gray-300" for="adjustment-{{ $part->id }}">Perubahan stok (+ masuk, - keluar)</label>
                                                    <input id="adjustment-{{ $part->id }}" name="adjustment" type="number" step="1" min="-100000" max="100000" required class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                                                    <input name="notes" maxlength="1000" placeholder="Catatan (opsional)" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                                                    @error('adjustment')
                                                        <p class="text-xs text-red-400">{{ $message }}</p>
                                                    @enderror
                                                    <button type="submit" class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">Simpan perubahan</button>
                                                </form>
                                            </details>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-gray-400">
                                        {{ $search !== '' ? 'Sparepart tidak ditemukan.' : 'Belum ada data sparepart di bengkel ini.' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div>{{ $parts->links() }}</div>

            </div>

        </div>
    </main>

</body>
</html>