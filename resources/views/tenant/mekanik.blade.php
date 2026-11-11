<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan & Mekanik - AMAHAY</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk interaksi ganti tab dengan mudah -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex" x-data="{ tab: 'pelanggan' }">

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
                <a href="/owner/mekanik" class="flex items-center space-x-3 px-4 py-2.5 bg-[#1f2937] text-white rounded-xl font-medium shadow-sm border border-gray-700/50">
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

    <!-- Konten Utama -->
    <main class="flex-1 flex min-w-0 flex-col min-h-screen">
        
        <!-- Top Navbar dengan Tombol Ganti Halaman / Tab -->
        <header class="min-h-16 h-auto bg-[#111827] border-b border-gray-800 flex flex-col justify-between gap-3 px-4 py-3 lg:flex-row lg:items-center lg:px-8">
            <div class="min-w-0">
                <h1 class="text-xs font-bold text-white tracking-wide uppercase" x-text="tab === 'pelanggan' ? 'Pelanggan & Mekanik (Database Pelanggan)' : 'Pelanggan & Mekanik (Tim Mekanik)'"></h1>
                <p class="text-[10px] text-gray-400">Kelola SDM & Pelanggan dalam satu panel terpadu.</p>
            </div>

            <!-- Tombol Switcher Tab (Sesuai Mockup) -->
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-4">
                <div class="flex bg-[#1f2937] p-1 rounded-xl border border-gray-700 text-xs">
                    <button @click="tab = 'pelanggan'" :class="tab === 'pelanggan' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-4 py-1.5 rounded-lg font-medium transition">
                        Database Pelanggan
                    </button>
                    <button @click="tab = 'mekanik'" :class="tab === 'mekanik' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-4 py-1.5 rounded-lg font-medium transition">
                        Tim Mekanik
                    </button>
                </div>

                @if (auth()->user()->role === 'Owner')
                    <details class="relative">
                        <summary class="list-none cursor-pointer bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-2 rounded-xl shadow transition">+ Tambah Mekanik</summary>
                        <form method="POST" action="{{ route('owner.mekanik.store') }}" class="absolute right-0 z-30 mt-2 grid w-80 max-w-[90vw] gap-3 rounded-xl border border-gray-700 bg-[#111827] p-4 shadow-xl">
                            @csrf
                            <h2 class="text-xs font-bold text-white">Data mekanik baru</h2>
                            <input name="name" value="{{ old('name') }}" required maxlength="255" placeholder="Nama lengkap" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            <input name="employee_code" value="{{ old('employee_code') }}" maxlength="255" placeholder="Kode karyawan (opsional)" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            <input name="phone" value="{{ old('phone') }}" maxlength="30" placeholder="Nomor WhatsApp (opsional)" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            <input name="email" type="email" value="{{ old('email') }}" maxlength="255" placeholder="Email (opsional)" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            <input name="position" value="{{ old('position', 'Mekanik') }}" required maxlength="100" placeholder="Jabatan" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            <input name="specialization" value="{{ old('specialization') }}" maxlength="255" placeholder="Spesialisasi (opsional)" class="rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-2 text-xs text-white">
                            @if ($errors->any())
                                <p class="text-xs text-red-400">{{ $errors->first() }}</p>
                            @endif
                            <button type="submit" class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">Simpan mekanik</button>
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

        <!-- Area Konten yang Berubah Otomatis Sesuai Tab -->
        <div class="min-w-0 p-4 sm:p-6 lg:p-8 space-y-6 flex-1">
            @if (session('success'))
                <p role="status" class="rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-xs text-green-300">{{ session('success') }}</p>
            @endif
            
            <!-- VIEW 1: DATABASE PELANGGAN -->
            <div x-show="tab === 'pelanggan'" class="space-y-4">
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <div class="flex items-center justify-between">
                        <form method="GET" action="{{ route('owner.mekanik') }}">
                            <input name="search" value="{{ $search }}" type="search" placeholder="Cari nama pelanggan atau plat nomor..." class="bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-2 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 w-80">
                        </form>
                        <span class="text-xs text-gray-400">Total: <strong class="text-white">{{ number_format($customerCount, 0, ',', '.') }} Pelanggan</strong></span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-300">
                            <thead class="bg-[#161e2e] text-gray-400 uppercase text-[10px] tracking-wider border-b border-gray-800">
                                <tr>
                                    <th class="px-6 py-3.5">Nama Pelanggan</th>
                                    <th class="px-6 py-3.5">No. WhatsApp</th>
                                    <th class="px-6 py-3.5">Kendaraan & Plat</th>
                                    <th class="px-6 py-3.5">Jumlah Kendaraan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @forelse ($customers as $customer)
                                    <tr class="hover:bg-[#161e2e]/50 transition">
                                        <td class="px-6 py-4 font-bold text-white">{{ $customer->name }}</td>
                                        <td class="px-6 py-4 font-mono text-gray-300">{{ $customer->phone ?: '-' }}</td>
                                        <td class="px-6 py-4">{{ $customer->vehicles_count }} kendaraan</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-gray-400">
                                            {{ $search !== '' ? 'Pelanggan tidak ditemukan.' : 'Belum ada data pelanggan di bengkel ini.' }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>{{ $customers->links() }}</div>
                </div>
            </div>

            <!-- VIEW 2: TIM MEKANIK -->
            <div x-show="tab === 'mekanik'" class="space-y-6" style="display: none;">
                <!-- 4 Kartu Metrik Tim Mekanik -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Mekanik</p>
                        <h3 class="text-2xl font-bold text-white mt-1">{{ number_format($mechanicCount, 0, ',', '.') }} Orang</h3>
                    </div>
                    <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Pekerjaan Selesai</p>
                        <h3 class="text-2xl font-bold text-white mt-1">{{ number_format($completedWorkOrderCount, 0, ',', '.') }} Motor</h3>
                    </div>
                    <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Jasa</p>
                        <h3 class="text-xl font-bold text-green-400 mt-1">Rp {{ number_format($completedServiceRevenue, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Jumlah Pelanggan</p>
                        <h3 class="text-2xl font-bold text-white mt-1">{{ number_format($customerCount, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <!-- Kartu Daftar Mekanik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse ($mechanics as $mechanic)
                        <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-sm font-bold text-white">{{ $mechanic->name }}</h3>
                                    <p class="text-[10px] text-gray-400">{{ $mechanic->position }}</p>
                                </div>
                                <span class="bg-green-500/20 text-green-400 text-[10px] px-2.5 py-1 rounded font-bold">Aktif</span>
                            </div>
                            <p class="text-xs text-gray-400">{{ $mechanic->phone ?: 'Nomor telepon belum ditambahkan.' }}</p>
                        </div>
                    @empty
                        <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 text-sm text-gray-400">
                            Belum ada data mekanik aktif di bengkel ini.
                        </div>
                    @endforelse
                </div>
                <div>{{ $mechanics->links() }}</div>
            </div>

        </div>
    </main>

</body>
</html>