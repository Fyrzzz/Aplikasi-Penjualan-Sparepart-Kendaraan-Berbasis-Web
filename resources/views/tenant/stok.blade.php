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
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold flex items-center justify-center text-xs">AG</div>
                <div class="text-xs">
                    <p class="font-bold text-white">Agus Setiawan</p>
                    <p class="text-[10px] text-gray-400">Kepala Mekanik</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Konten Utama Stok & Inventaris -->
    <main class="flex-1 flex flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-[#111827] border-b border-gray-800 flex items-center justify-between px-8">
            <div>
                <h1 class="text-xs font-bold text-white tracking-wide uppercase">Stok & Inventaris Sparepart</h1>
                <p class="text-[10px] text-gray-400">Monitoring ketersediaan suku cadang, lokasi rak penyimpanan, dan status kritis gudang.</p>
            </div>
            <div class="flex items-center space-x-3">
                <button class="bg-[#1f2937] hover:bg-gray-700 text-gray-200 text-xs font-medium px-4 py-2 rounded-xl border border-gray-700 transition">
                    Cetak Stok (PDF)
                </button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-2 rounded-xl shadow transition">
                    + Tambah Barang Baru
                </button>
            </div>
        </header>

        <!-- Area Konten Stok -->
        <div class="p-8 space-y-6 flex-1">
            
            <!-- 4 Kartu Ringkasan Metrik Atas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Item SKU</p>
                    <h3 class="text-2xl font-bold text-white mt-1">7</h3>
                    <p class="text-[10px] text-blue-400 font-medium mt-1">📦 Terdaftar di sistem</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Stok Menipis</p>
                    <h3 class="text-2xl font-bold text-yellow-400 mt-1">2 Item</h3>
                    <p class="text-[10px] text-yellow-400 font-medium mt-1">⚠️ Perlu restock segera</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Stok Habis</p>
                    <h3 class="text-2xl font-bold text-red-400 mt-1">1 Item</h3>
                    <p class="text-[10px] text-red-400 font-medium mt-1">🚨 Kosong di gudang</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Estimasi Nilai Aset</p>
                    <h3 class="text-xl font-bold text-green-400 mt-1">Rp 2.645.000</h3>
                    <p class="text-[10px] text-gray-400 font-medium mt-1">💰 Total valuasi gudang</p>
                </div>
            </div>

            <!-- Tabel Data Stok Lengkap -->
            <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <input type="text" placeholder="Cari nama atau kode SKU..." class="bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-1.5 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 w-64">
                    </div>
                    <div class="flex items-center space-x-2 text-xs">
                        <span class="bg-blue-600/20 text-blue-400 px-3 py-1 rounded-lg border border-blue-500/30 font-medium">Semua (7)</span>
                        <span class="bg-[#1f2937] text-gray-400 px-3 py-1 rounded-lg border border-gray-700 hover:text-white cursor-pointer">Stok Kritis</span>
                        <span class="bg-[#1f2937] text-gray-400 px-3 py-1 rounded-lg border border-gray-700 hover:text-white cursor-pointer">Arsip</span>
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
                            <tr class="hover:bg-[#161e2e]/50 transition">
                                <td class="px-4 py-3 font-mono font-bold text-blue-400">SKU-001</td>
                                <td class="px-4 py-3 font-bold text-white">Oli MPX2 Matic 0.8L</td>
                                <td class="px-4 py-3 text-gray-400">Oli & Pelumas</td>
                                <td class="px-4 py-3">Rak A-1</td>
                                <td class="px-4 py-3 font-mono">Rp 55.000</td>
                                <td class="px-4 py-3 font-bold text-white">24 Botol</td>
                                <td class="px-4 py-3"><span class="bg-green-500/20 text-green-400 px-2.5 py-1 rounded-md text-[10px] font-bold">Aman</span></td>
                                <td class="px-4 py-3 text-center space-x-1">
                                    <button class="bg-[#1f2937] hover:bg-gray-700 text-gray-200 px-2.5 py-1 rounded text-[11px] border border-gray-700">Edit</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-[#161e2e]/50 transition">
                                <td class="px-4 py-3 font-mono font-bold text-blue-400">SKU-002</td>
                                <td class="px-4 py-3 font-bold text-white">Kampas Rem Depan Vario</td>
                                <td class="px-4 py-3 text-gray-400">Pengereman</td>
                                <td class="px-4 py-3">Rak B-2</td>
                                <td class="px-4 py-3 font-mono">Rp 45.000</td>
                                <td class="px-4 py-3 font-bold text-yellow-400">3 Set</td>
                                <td class="px-4 py-3"><span class="bg-yellow-500/20 text-yellow-400 px-2.5 py-1 rounded-md text-[10px] font-bold">Menipis</span></td>
                                <td class="px-4 py-3 text-center space-x-1">
                                    <button class="bg-[#1f2937] hover:bg-gray-700 text-gray-200 px-2.5 py-1 rounded text-[11px] border border-gray-700">Edit</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-[#161e2e]/50 transition">
                                <td class="px-4 py-3 font-mono font-bold text-blue-400">SKU-003</td>
                                <td class="px-4 py-3 font-bold text-white">Busi NGK CPR9EA-9</td>
                                <td class="px-4 py-3 text-gray-400">Pengapian</td>
                                <td class="px-4 py-3">Rak C-1</td>
                                <td class="px-4 py-3 font-mono">Rp 25.000</td>
                                <td class="px-4 py-3 font-bold text-red-400">0 Pcs</td>
                                <td class="px-4 py-3"><span class="bg-red-500/20 text-red-400 px-2.5 py-1 rounded-md text-[10px] font-bold">Habis</span></td>
                                <td class="px-4 py-3 text-center space-x-1">
                                    <button class="bg-[#1f2937] hover:bg-gray-700 text-gray-200 px-2.5 py-1 rounded text-[11px] border border-gray-700">Restock</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-[#161e2e]/50 transition">
                                <td class="px-4 py-3 font-mono font-bold text-blue-400">SKU-004</td>
                                <td class="px-4 py-3 font-bold text-white">V-Belt Honda Beat FI</td>
                                <td class="px-4 py-3 text-gray-400">Transmisi CVT</td>
                                <td class="px-4 py-3">Rak A-3</td>
                                <td class="px-4 py-3 font-mono">Rp 95.000</td>
                                <td class="px-4 py-3 font-bold text-white">8 Pcs</td>
                                <td class="px-4 py-3"><span class="bg-green-500/20 text-green-400 px-2.5 py-1 rounded-md text-[10px] font-bold">Aman</span></td>
                                <td class="px-4 py-3 text-center space-x-1">
                                    <button class="bg-[#1f2937] hover:bg-gray-700 text-gray-200 px-2.5 py-1 rounded text-[11px] border border-gray-700">Edit</button>
                                </td>
                            </tr>
                            <tr class="hover:bg-[#161e2e]/50 transition">
                                <td class="px-4 py-3 font-mono font-bold text-blue-400">SKU-005</td>
                                <td class="px-4 py-3 font-bold text-white">Roller Set Vario 150</td>
                                <td class="px-4 py-3 text-gray-400">Transmisi CVT</td>
                                <td class="px-4 py-3">Rak A-4</td>
                                <td class="px-4 py-3 font-mono">Rp 75.000</td>
                                <td class="px-4 py-3 font-bold text-yellow-400">2 Set</td>
                                <td class="px-4 py-3"><span class="bg-yellow-500/20 text-yellow-400 px-2.5 py-1 rounded-md text-[10px] font-bold">Menipis</span></td>
                                <td class="px-4 py-3 text-center space-x-1">
                                    <button class="bg-[#1f2937] hover:bg-gray-700 text-gray-200 px-2.5 py-1 rounded text-[11px] border border-gray-700">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </main>

</body>
</html>