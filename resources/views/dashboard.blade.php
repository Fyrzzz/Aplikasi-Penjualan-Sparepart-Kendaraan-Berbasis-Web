<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Tenant - AMAHAY</title>
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
                <a href="/test-dashboard" class="flex items-center space-x-3 px-4 py-2.5 bg-[#1f2937] text-white rounded-xl font-medium shadow-sm border border-gray-700/50">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="/test-antrean" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>🛠️</span>
                    <span>Antrean Service</span>
                </a>
                <a href="/test-kasir" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>💰</span>
                    <span>Kasir / POS</span>
                </a>
                <a href="/test-stok" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>📦</span>
                    <span>Stok Sparepart</span>
                </a>
                <a href="/test-mekanik" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>👥</span>
                    <span>Pelanggan & Mekanik</span>
                </a>
                <a href="/test-pengingat" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>🔔</span>
                    <span>Pengingat Service</span>
                </a>
            </nav>
        </div>

        <!-- Profil Owner / Mekanik di Sidebar Bawah & Tombol Logout -->
        <div class="p-4 border-t border-gray-800 space-y-3">
            <div class="flex items-center space-x-3 bg-[#161e2e] p-2.5 rounded-xl border border-gray-800">
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold flex items-center justify-center text-xs">AG</div>
                <div class="text-xs">
                    <p class="font-bold text-white">Agus Setiawan</p>
                    <p class="text-[10px] text-gray-400">Kepala Mekanik</p>
                </div>
            </div>
            <!-- Tombol Keluar / Logout -->
            <a href="/" class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 text-xs font-medium py-2 px-3 rounded-xl transition flex items-center justify-center space-x-2">
                <span>🚪</span>
                <span>Keluar (Logout)</span>
            </a>
        </div>
    </aside>

    <!-- Konten Utama Dashboard Tenant -->
    <main class="flex-1 flex flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-[#111827] border-b border-gray-800 flex items-center justify-between px-8">
            <div>
                <div class="flex items-center space-x-2">
                    <h1 class="text-xs font-bold text-white tracking-wide">Dashboard Ringkasan Bengkel</h1>
                    <span class="bg-blue-600/20 text-blue-400 text-[10px] px-2 py-0.5 rounded font-medium border border-blue-500/30">REALTIME MONITOR</span>
                </div>
                <p class="text-[10px] text-gray-400">Monitoring operasional harian, estimasi omset, dan pengingat servis otomatis.</p>
            </div>

            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-white">10:17:37 WIB</p>
                    <p class="text-[10px] text-gray-400">21 Sept 2026</p>
                </div>
                <button class="w-8 h-8 bg-[#1f2937] border border-gray-700 rounded-xl flex items-center justify-center text-gray-300 hover:text-white transition">
                    🔔
                </button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-2 rounded-xl shadow transition flex items-center space-x-2">
                    <span>+ Antrean Baru</span>
                </button>
            </div>
        </header>

        <!-- Area Konten Dashboard -->
        <div class="p-8 space-y-6">
            
            <!-- 4 Kartu Metrik Utama Atas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow-lg relative">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Pendapatan Hari Ini</p>
                    <h3 class="text-xl font-bold text-white mt-1">Rp 2.850.000</h3>
                    <p class="text-[10px] text-green-400 font-medium mt-1">▲ +14.2% dari kemarin</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow-lg relative">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Unit Servis</p>
                    <h3 class="text-xl font-bold text-white mt-1">12 Unit</h3>
                    <p class="text-[10px] text-blue-400 font-medium mt-1">🔧 4 Antrean Aktif</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow-lg relative">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Pengingat Terkirim</p>
                    <h3 class="text-xl font-bold text-white mt-1">18 / 21</h3>
                    <p class="text-[10px] text-yellow-400 font-medium mt-1">⚠️ 3 Perlu Tindakan</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow-lg relative">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Stok Sparepart Kritis</p>
                    <h3 class="text-xl font-bold text-red-400 mt-1">3 Item</h3>
                    <p class="text-[10px] text-red-400 font-medium mt-1">🚨 Perlu Reorder</p>
                </div>
            </div>

            <!-- Grid Tengah: Grafik & Widget Samping -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Grafik Pendapatan (2 Kolom) - Tinggi disesuaikan agar tidak terpotong -->
                <div class="lg:col-span-2 bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xs font-bold text-white">Grafik Pendapatan & Volume Servis Pekan Ini</h3>
                            <p class="text-[10px] text-gray-400">Perbandingan unit masuk vs estimasi pendapatan per hari</p>
                        </div>
                        <span class="text-[10px] bg-[#1f2937] text-gray-300 px-3 py-1 rounded-lg border border-gray-700">7 Hari Terakhir</span>
                    </div>

                    <!-- Visual Grafik Kurva Sempurna (Tinggi h-60) -->
                    <div class="h-60 bg-[#161e2e]/50 rounded-xl border border-gray-800 flex items-center justify-center p-4 relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center p-2">
                            <svg class="w-full h-full text-blue-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 500 160">
                                <path d="M 20 130 Q 100 40, 200 110 T 380 30 T 480 90" />
                            </svg>
                        </div>
                        <div class="text-center z-10 space-y-1 bg-[#111827]/80 px-4 py-2 rounded-xl border border-gray-700 backdrop-blur">
                            <span class="text-xs text-blue-400 font-bold block">Grafik Kurva Realtime Aktif</span>
                            <p class="text-[10px] text-gray-300">Puncak tertinggi pada hari Sabtu (15 Unit Servis)</p>
                        </div>
                    </div>
                </div>

                <!-- Widget Samping Kanan: Pengingat Servis Otomatis -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-5 shadow-lg space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                        <div>
                            <h4 class="text-xs font-bold text-white">Pengingat Servis Otomatis</h4>
                            <p class="text-[9px] text-gray-400">Jadwal ganti oli/sparepart berkala</p>
                        </div>
                        <span class="text-[9px] bg-green-500/20 text-green-400 px-2 py-0.5 rounded font-bold">3 Siap Kirim</span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800 space-y-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-bold text-white">Pak Joko (Honda Supra X)</p>
                                    <p class="text-[10px] text-gray-400">Terakhir Servis: 2 Bulan lalu (3.000 KM)</p>
                                </div>
                                <span class="text-[9px] bg-red-500/20 text-red-400 px-1.5 py-0.5 rounded">Ganti Oli</span>
                            </div>
                            <button class="w-full bg-green-600 hover:bg-green-700 text-white text-[11px] font-medium py-1.5 rounded-lg transition shadow">
                                💬 Kirim WhatsApp Pengingat
                            </button>
                        </div>

                        <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800 space-y-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-bold text-white">Bu Ratna (Yamaha Mio)</p>
                                    <p class="text-[10px] text-gray-400">Terakhir Servis: 6 Bulan lalu (6.500 KM)</p>
                                </div>
                                <span class="text-[9px] bg-yellow-500/20 text-yellow-400 px-1.5 py-0.5 rounded">Servis CVT</span>
                            </div>
                            <button class="w-full bg-green-600 hover:bg-green-700 text-white text-[11px] font-medium py-1.5 rounded-lg transition shadow">
                                💬 Kirim WhatsApp Pengingat
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bagian Bawah: Status Bay & Antrean Servis Aktif & Stok Kritis -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Tabel Antrean Aktif (2 Kolom) -->
                <div class="lg:col-span-2 bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xs font-bold text-white">Status Bay & Antrean Servis Aktif</h3>
                            <p class="text-[10px] text-gray-400">Daftar kendaraan yang sedang berada dalam penanganan atau antrean</p>
                        </div>
                        <button class="text-xs text-blue-400 hover:underline">Refresh Status</button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-300">
                            <thead class="text-gray-400 uppercase text-[9px] tracking-wider border-b border-gray-800 pb-2">
                                <tr>
                                    <th class="pb-3">No. Antrean</th>
                                    <th class="pb-3">Pelanggan / Kendaraan</th>
                                    <th class="pb-3">Jenis Pekerjaan</th>
                                    <th class="pb-3">Mekanik</th>
                                    <th class="pb-3">Status</th>
                                    <th class="pb-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800/60">
                                <tr class="hover:bg-[#161e2e]/40">
                                    <td class="py-3 font-mono font-bold text-blue-400">#A-01</td>
                                    <td class="py-3">
                                        <p class="font-bold text-white">Pak Ahmad</p>
                                        <p class="text-[10px] text-gray-400">B 1234 XYZ • Honda Vario 150</p>
                                    </td>
                                    <td class="py-3 text-gray-300">Ganti Oli Mesin + CVT</td>
                                    <td class="py-3 text-gray-300">Agus Setiawan</td>
                                    <td class="py-3"><span class="bg-yellow-500/20 text-yellow-400 px-2 py-0.5 rounded text-[10px] font-bold">MENUNGGU</span></td>
                                    <td class="py-3 text-right"><button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-[11px] font-medium transition">Proses</button></td>
                                </tr>
                                <tr class="hover:bg-[#161e2e]/40">
                                    <td class="py-3 font-mono font-bold text-blue-400">#A-02</td>
                                    <td class="py-3">
                                        <p class="font-bold text-white">Ibu Siska</p>
                                        <p class="text-[10px] text-gray-400">P 5678 LMN • NMAX 155</p>
                                    </td>
                                    <td class="py-3 text-gray-300">Kampas Rem Depan & Belakang</td>
                                    <td class="py-3 text-gray-300">Budi Santoso</td>
                                    <td class="py-3"><span class="bg-yellow-500/20 text-yellow-400 px-2 py-0.5 rounded text-[10px] font-bold">MENUNGGU</span></td>
                                    <td class="py-3 text-right"><button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-[11px] font-medium transition">Proses</button></td>
                                </tr>
                                <tr class="hover:bg-[#161e2e]/40">
                                    <td class="py-3 font-mono font-bold text-blue-400">#A-03</td>
                                    <td class="py-3">
                                        <p class="font-bold text-white">Mas Dimas</p>
                                        <p class="text-[10px] text-gray-400">DK 9012 AB • Honda PCX 160</p>
                                    </td>
                                    <td class="py-3 text-gray-300">Tune Up Mesin + Ganti Busi</td>
                                    <td class="py-3 text-gray-300">Eko Prasetyo</td>
                                    <td class="py-3"><span class="bg-blue-500/20 text-blue-400 px-2 py-0.5 rounded text-[10px] font-bold">DIKERJAKAN</span></td>
                                    <td class="py-3 text-right"><button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-[11px] font-medium transition">Selesai</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Widget Samping: Stok Sparepart Kritis -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-5 shadow-lg space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                        <div>
                            <h4 class="text-xs font-bold text-white">Stok Sparepart Kritis</h4>
                            <p class="text-[9px] text-gray-400">Item di bawah batas minimum</p>
                        </div>
                        <span class="text-[9px] bg-red-500/20 text-red-400 px-2 py-0.5 rounded font-bold">Perlu Order</span>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800 flex items-center justify-between">
                            <div>
                                <p class="font-bold text-white">Oli MPX2 0.8L Matic</p>
                                <p class="text-[10px] text-red-400 font-medium">Stok Sisa: <strong class="text-white">2 Botol</strong> (Min: 10)</p>
                            </div>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow">Restock</button>
                        </div>

                        <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800 flex items-center justify-between">
                            <div>
                                <p class="font-bold text-white">Kampas Rem Vario</p>
                                <p class="text-[10px] text-red-400 font-medium">Stok Sisa: <strong class="text-white">1 Set</strong> (Min: 5)</p>
                            </div>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow">Restock</button>
                        </div>

                        <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800 flex items-center justify-between">
                            <div>
                                <p class="font-bold text-white">Busi NGK CPR9EA-9</p>
                                <p class="text-[10px] text-red-400 font-medium">Stok Sisa: <strong class="text-white">3 Pcs</strong> (Min: 8)</p>
                            </div>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow">Restock</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

</body>
</html>