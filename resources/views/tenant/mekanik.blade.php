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
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold flex items-center justify-center text-xs">AG</div>
                <div class="text-xs">
                    <p class="font-bold text-white">Agus Setiawan</p>
                    <p class="text-[10px] text-gray-400">Kepala Mekanik</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 flex flex-col min-h-screen">
        
        <!-- Top Navbar dengan Tombol Ganti Halaman / Tab -->
        <header class="h-16 bg-[#111827] border-b border-gray-800 flex items-center justify-between px-8">
            <div>
                <h1 class="text-xs font-bold text-white tracking-wide uppercase" x-text="tab === 'pelanggan' ? 'Pelanggan & Mekanik (Database Pelanggan)' : 'Pelanggan & Mekanik (Tim Mekanik)'"></h1>
                <p class="text-[10px] text-gray-400">Kelola SDM & Pelanggan dalam satu panel terpadu.</p>
            </div>

            <!-- Tombol Switcher Tab (Sesuai Mockup) -->
            <div class="flex items-center space-x-4">
                <div class="flex bg-[#1f2937] p-1 rounded-xl border border-gray-700 text-xs">
                    <button @click="tab = 'pelanggan'" :class="tab === 'pelanggan' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-4 py-1.5 rounded-lg font-medium transition">
                        Database Pelanggan
                    </button>
                    <button @click="tab = 'mekanik'" :class="tab === 'mekanik' ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:text-white'" class="px-4 py-1.5 rounded-lg font-medium transition">
                        Tim Mekanik
                    </button>
                </div>

                <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-2 rounded-xl shadow transition">
                    + Tambah Data
                </button>
            </div>
        </header>

        <!-- Area Konten yang Berubah Otomatis Sesuai Tab -->
        <div class="p-8 space-y-6 flex-1">
            
            <!-- VIEW 1: DATABASE PELANGGAN -->
            <div x-show="tab === 'pelanggan'" class="space-y-4">
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <div class="flex items-center justify-between">
                        <input type="text" placeholder="Cari nama pelanggan atau plat nomor..." class="bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-2 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 w-80">
                        <span class="text-xs text-gray-400">Total: <strong class="text-white">48 Pelanggan</strong></span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-300">
                            <thead class="bg-[#161e2e] text-gray-400 uppercase text-[10px] tracking-wider border-b border-gray-800">
                                <tr>
                                    <th class="px-6 py-3.5">Nama Pelanggan</th>
                                    <th class="px-6 py-3.5">No. WhatsApp</th>
                                    <th class="px-6 py-3.5">Kendaraan & Plat</th>
                                    <th class="px-6 py-3.5">Terakhir Servis</th>
                                    <th class="px-6 py-3.5">Total Transaksi</th>
                                    <th class="px-6 py-3.5 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                <tr class="hover:bg-[#161e2e]/50 transition">
                                    <td class="px-6 py-4 font-bold text-white">Pak Hendra</td>
                                    <td class="px-6 py-4 font-mono text-gray-300">0812-3456-7890</td>
                                    <td class="px-6 py-4">Honda Beat FI <br><span class="text-[10px] text-gray-400 font-mono">L 3456 GH</span></td>
                                    <td class="px-6 py-4 text-gray-300">18 Sep 2026</td>
                                    <td class="px-6 py-4 font-mono font-bold text-green-400">Rp 1.450.000</td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="bg-[#1f2937] hover:bg-gray-700 text-gray-200 px-3 py-1 rounded text-xs border border-gray-700">Detail</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- VIEW 2: TIM MEKANIK -->
            <div x-show="tab === 'mekanik'" class="space-y-6" style="display: none;">
                <!-- 4 Kartu Metrik Tim Mekanik -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Mekanik</p>
                        <h3 class="text-2xl font-bold text-white mt-1">3 Orang</h3>
                    </div>
                    <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Pekerjaan Selesai</p>
                        <h3 class="text-2xl font-bold text-white mt-1">5 Motor</h3>
                    </div>
                    <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Jasa</p>
                        <h3 class="text-xl font-bold text-green-400 mt-1">Rp 8.700.000</h3>
                    </div>
                    <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                        <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Rating Bengkel</p>
                        <h3 class="text-2xl font-bold text-yellow-400 mt-1">4.9 / 5.0</h3>
                    </div>
                </div>

                <!-- Kartu Daftar Mekanik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-sm font-bold text-white">Agus Setiawan</h3>
                                <p class="text-[10px] text-gray-400">Kepala Mekanik</p>
                            </div>
                            <span class="bg-green-500/20 text-green-400 text-[10px] px-2.5 py-1 rounded font-bold">Sertifikasi A</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3 bg-[#161e2e] p-3 rounded-xl border border-gray-800 text-xs">
                            <div>
                                <span class="text-[10px] text-gray-400 block">Selesai</span>
                                <span class="font-bold text-white text-base">3 Motor</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-gray-400 block">Pendapatan</span>
                                <span class="font-bold text-green-400 text-base">Rp 4.250</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-sm font-bold text-white">Budi Santoso</h3>
                                <p class="text-[10px] text-gray-400">Mekanik Junior</p>
                            </div>
                            <span class="bg-blue-500/20 text-blue-400 text-[10px] px-2.5 py-1 rounded font-bold">Sertifikasi B</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3 bg-[#161e2e] p-3 rounded-xl border border-gray-800 text-xs">
                            <div>
                                <span class="text-[10px] text-gray-400 block">Selesai</span>
                                <span class="font-bold text-white text-base">2 Motor</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-gray-400 block">Pendapatan</span>
                                <span class="font-bold text-green-400 text-base">Rp 2.800</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-sm font-bold text-white">Riko Pratama</h3>
                                <p class="text-[10px] text-gray-400">Mekanik Magang</p>
                            </div>
                            <span class="bg-yellow-500/20 text-yellow-400 text-[10px] px-2.5 py-1 rounded font-bold">Junior</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3 bg-[#161e2e] p-3 rounded-xl border border-gray-800 text-xs">
                            <div>
                                <span class="text-[10px] text-gray-400 block">Selesai</span>
                                <span class="font-bold text-white text-base">0 Motor</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-gray-400 block">Pendapatan</span>
                                <span class="font-bold text-green-400 text-base">Rp 1.650</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>