<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan Platform - AMAHAY Admin</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex">

    <!-- Sidebar Super Admin (5 Fitur Utama) -->
    <aside class="w-64 bg-[#111827] border-r border-gray-800 flex flex-col justify-between hidden md:flex">
        <div>
            <!-- Brand / Logo -->
            <div class="h-16 flex items-center px-6 border-b border-gray-800 space-x-3">
                <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.9 6.9a2.12 2.12 0 1 1-3-3l6.9-6.9a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                    </svg>
                </div>
                <span class="text-base font-bold tracking-wider text-white">AMAHAY Admin</span>
            </div>

            <!-- Menu Sidebar -->
            <nav class="p-4 space-y-1.5 text-xs">
                <a href="/superadmin/dashboard" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-dashboard') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>📊</span>
                    <span>Dashboard Global</span>
                </a>
                <a href="/superadmin/tenant" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>🏢</span>
                    <span>Kelola Bengkel (Tenant)</span>
                </a>
                <a href="/superadmin/laporan" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-laporan') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>💵</span>
                    <span>Laporan Keuangan</span>
                </a>
                <a href="/superadmin/paket" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-paket') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>📦</span>
                    <span>Manajemen Paket</span>
                </a>
                <a href="/superadmin/pengaturan" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-pengaturan') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>⚙️</span>
                    <span>Pengaturan Platform</span>
                </a>
            </nav>
        </div>

        <!-- Footer Sidebar & Logout -->
        <div class="p-4 border-t border-gray-800 space-y-3">
            <div class="text-[10px] text-gray-500">
                Sistem Multi-Tenant v1.0<br>Super Admin Access
            </div>
            <a href="/" class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 text-xs font-medium py-2 px-3 rounded-xl transition flex items-center justify-center space-x-2">
                <span>🚪</span>
                <span>Keluar (Logout)</span>
            </a>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 flex flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-[#111827] border-b border-gray-800 flex items-center justify-between px-8">
            <span class="text-xs font-semibold text-gray-400 tracking-wide uppercase">Laporan Konsolidasi Finansial Platform</span>
            <div class="flex items-center space-x-2 bg-[#1f2937] px-3 py-1.5 rounded-full border border-gray-800 text-xs">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                <span class="text-white font-medium">Admin Line (Super Admin)</span>
            </div>
        </header>

        <!-- Area Konten Utama -->
        <div class="p-8 space-y-6">
            
            <!-- Judul & Periode -->
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-lg font-bold text-white tracking-wide">Laporan Keuangan & Audit Platform</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Rekonsiliasi omset global seluruh tenant, laba langganan, dan performa ekosistem AMAHAY.</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 rounded-xl px-4 py-2 flex items-center space-x-3 text-xs shadow">
                    <span class="text-gray-400">Periode:</span>
                    <span class="font-bold text-white bg-[#1f2937] px-3 py-1 rounded-lg border border-gray-700">September 2026</span>
                </div>
            </div>

            <!-- 3 Kartu Metrik Utama Atas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-[#111827] border border-gray-800 p-5 rounded-2xl shadow-lg space-y-2">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Omset Global Tenant</p>
                    <h3 class="text-2xl font-bold text-white">Rp 34.250.000</h3>
                    <p class="text-[11px] text-green-400 font-medium">▲ +12% dibandingkan bulan lalu</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-5 rounded-2xl shadow-lg space-y-2">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Pendapatan Langganan Platform</p>
                    <h3 class="text-2xl font-bold text-blue-400">Rp 14.800.000</h3>
                    <p class="text-[11px] text-blue-300 font-medium">Dari 3 Bengkel Aktif (Pro & Starter)</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-5 rounded-2xl shadow-lg space-y-2">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Nota Servis Keseluruhan</p>
                    <h3 class="text-2xl font-bold text-white">142 Nota</h3>
                    <p class="text-[11px] text-gray-400 font-medium">Akumulasi seluruh tenant</p>
                </div>
            </div>

            <!-- Grid 2 Kolom Bawah -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Kolom Kiri: Mutasi Stok Global -->
                <div class="lg:col-span-2 bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-white">Monitoring Mutasi Stok Sparepart (Global)</h3>
                        <a href="#" class="text-xs text-blue-400 hover:underline">Lihat Semua →</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-300">
                            <thead class="text-gray-400 uppercase text-[10px] tracking-wider border-b border-gray-800 pb-2">
                                <tr>
                                    <th class="pb-3">Barang & SKU</th>
                                    <th class="pb-3 text-center">Stok Awal</th>
                                    <th class="pb-3 text-center">Masuk (In)</th>
                                    <th class="pb-3 text-center">Keluar (Out)</th>
                                    <th class="pb-3 text-right">Sisa Stok</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800/60">
                                <tr class="hover:bg-[#161e2e]/40">
                                    <td class="py-3.5">
                                        <p class="font-bold text-white">Oli MPX 2 Matic 0.8L</p>
                                        <p class="text-[10px] text-gray-500 font-mono">SKU-OLI-001</p>
                                    </td>
                                    <td class="py-3.5 text-center text-gray-300">45</td>
                                    <td class="py-3.5 text-center"><span class="bg-green-500/20 text-green-400 px-2 py-0.5 rounded font-bold text-[11px]">+50</span></td>
                                    <td class="py-3.5 text-center"><span class="bg-red-500/20 text-red-400 px-2 py-0.5 rounded font-bold text-[11px]">-72</span></td>
                                    <td class="py-3.5 text-right font-bold text-white text-sm">23</td>
                                </tr>
                                <tr class="hover:bg-[#161e2e]/40">
                                    <td class="py-3.5">
                                        <p class="font-bold text-white">Kampas Rem Depan Vario</p>
                                        <p class="text-[10px] text-gray-500 font-mono">SKU-REM-012</p>
                                    </td>
                                    <td class="py-3.5 text-center text-gray-300">18</td>
                                    <td class="py-3.5 text-center"><span class="bg-green-500/20 text-green-400 px-2 py-0.5 rounded font-bold text-[11px]">+20</span></td>
                                    <td class="py-3.5 text-center"><span class="bg-red-500/20 text-red-400 px-2 py-0.5 rounded font-bold text-[11px]">-35</span></td>
                                    <td class="py-3.5 text-right font-bold text-red-400 text-sm">3 <span class="text-[10px] font-normal">(kritis)</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Kolom Kanan: Kinerja Keseluruhan Mekanik -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <h3 class="text-sm font-semibold text-white">Performa Top Mekanik Platform</h3>

                    <div class="space-y-4 pt-2">
                        <div class="space-y-1.5 border-b border-gray-800/60 pb-3">
                            <div class="flex justify-between items-center text-xs">
                                <div>
                                    <p class="font-bold text-white">Agus Supriyadi</p>
                                    <span class="text-[9px] bg-blue-600/20 text-blue-400 px-1.5 py-0.5 rounded font-medium">BENGKEL MAJU JAYA</span>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-white">68 SPK</p>
                                    <p class="text-green-400 font-medium text-[11px]">Rp 4.250.000</p>
                                </div>
                            </div>
                            <div class="w-full bg-gray-800 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-blue-600 h-full rounded-full" style="width: 85%"></div>
                            </div>
                        </div>

                        <div class="space-y-1.5 border-b border-gray-800/60 pb-3">
                            <div class="flex justify-between items-center text-xs">
                                <div>
                                    <p class="font-bold text-white">Budi Santoso</p>
                                    <span class="text-[9px] bg-gray-700/50 text-gray-300 px-1.5 py-0.5 rounded font-medium">AAA BIKE</span>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-white">45 SPK</p>
                                    <p class="text-green-400 font-medium text-[11px]">Rp 2.800.000</p>
                                </div>
                            </div>
                            <div class="w-full bg-gray-800 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-blue-600 h-full rounded-full" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

</body>
</html>