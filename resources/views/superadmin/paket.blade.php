<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Paket - AMAHAY Admin</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex">

    <!-- Sidebar Super Admin (5 Fitur Sesuai Rencana) -->
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
                <a href="/test-superadmin-dashboard" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-dashboard') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>📊</span>
                    <span>Dashboard Global</span>
                </a>
                <a href="/test-superadmin" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>🏢</span>
                    <span>Kelola Bengkel (Tenant)</span>
                </a>
                <a href="/test-superadmin-laporan" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-laporan') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>💵</span>
                    <span>Laporan Keuangan</span>
                </a>
                <a href="/test-superadmin-paket" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-paket') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>📦</span>
                    <span>Manajemen Paket</span>
                </a>
                <a href="/test-superadmin-pengaturan" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-pengaturan') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>⚙️</span>
                    <span>Pengaturan Platform</span>
                </a>
            </nav>
        </div>

        <!-- Footer Sidebar & Tombol Logout -->
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
            <span class="text-xs font-semibold text-gray-400 tracking-wide">Manajemen Paket & Harga</span>
            <div class="flex items-center space-x-2 bg-[#1f2937] px-3 py-1 rounded-full border border-gray-800 text-xs">
                <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-[10px]">A</span>
                <span class="text-white font-medium">Admin Platform</span>
            </div>
        </header>

        <!-- Area Konten Utama -->
        <div class="p-8 space-y-8">
            
            <!-- Bagian 1: Pengaturan Harga Langganan SaaS -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-base font-bold text-white">Pengaturan Harga Langganan SaaS</h1>
                        <p class="text-xs text-gray-400 mt-0.5">Atur struktur biaya, limit fitur, dan harga per paket layanan untuk tenant bengkel.</p>
                    </div>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-2 rounded-xl shadow transition">
                        + Daftarkan Paket Baru
                    </button>
                </div>

                <!-- Kartu 3 Pilihan Paket -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    
                    <!-- Starter -->
                    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs font-bold text-gray-300">Starter</span>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Rp 99rb <span class="text-xs text-gray-400 font-normal">/bln</span></h3>
                            
                            <ul class="mt-5 space-y-2 text-xs text-gray-300 border-t border-gray-800 pt-4">
                                <li class="flex items-center space-x-2"><span>✔️</span> <span>Maks 1 Kasir (Database Lokal)</span></li>
                                <li class="flex items-center space-x-2"><span>✔️</span> <span>Modul POS & Stok Terbatas</span></li>
                                <li class="flex items-center space-x-2"><span>✔️</span> <span>Laporan Bulanan PDF Sederhana</span></li>
                                <li class="flex items-center space-x-2 text-gray-500"><span>❌</span> <span>Dukungan Prioritas 24/7</span></li>
                            </ul>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-800">
                            <button class="w-full bg-[#1f2937] hover:bg-gray-700 text-gray-200 text-xs font-medium py-2 rounded-xl transition border border-gray-700">Edit Paket Starter</button>
                        </div>
                    </div>

                    <!-- Pro Tenant (Featured) -->
                    <div class="bg-[#111827] border-2 border-blue-600 rounded-2xl p-6 shadow-xl flex flex-col justify-between relative">
                        <div class="absolute -top-3 right-5 bg-blue-600 text-white text-[9px] font-bold px-3 py-0.5 rounded-full uppercase tracking-wider shadow">Rekomendasi</div>
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs font-bold text-blue-400">Pro Tenant</span>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Rp 249rb <span class="text-xs text-gray-400 font-normal">/bln</span></h3>
                            
                            <ul class="mt-5 space-y-2 text-xs text-gray-300 border-t border-gray-800 pt-4">
                                <li class="flex items-center space-x-2"><span>✔️</span> <span>Multi Kasir & Multi Mekanik (5x)</span></li>
                                <li class="flex items-center space-x-2"><span>✔️</span> <span>Manajemen Antrean & POS</span></li>
                                <li class="flex items-center space-x-2"><span>✔️</span> <span>Laporan Keuangan & Laba-Rugi (FR)</span></li>
                                <li class="flex items-center space-x-2"><span>✔️</span> <span>Backup Otomatis Mingguan</span></li>
                            </ul>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-800">
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium py-2 rounded-xl transition shadow">Edit Paket Pro</button>
                        </div>
                    </div>

                    <!-- Enterprise -->
                    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs font-bold text-gray-300">Enterprise</span>
                            </div>
                            <h3 class="text-2xl font-bold text-white">Rp 799rb <span class="text-xs text-gray-400 font-normal">/bln</span></h3>
                            
                            <ul class="mt-5 space-y-2 text-xs text-gray-300 border-t border-gray-800 pt-4">
                                <li class="flex items-center space-x-2"><span>✔️</span> <span>Unlimited Cabang & Kasir</span></li>
                                <li class="flex items-center space-x-2"><span>✔️</span> <span>Akses API & Integrasi Pihak ke-3</span></li>
                                <li class="flex items-center space-x-2"><span>✔️</span> <span>Prioritas Dukungan 24/7 Owner</span></li>
                                <li class="flex items-center space-x-2"><span>✔️</span> <span>Custom Domain & Logo Bengkel</span></li>
                            </ul>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-800">
                            <button class="w-full bg-[#1f2937] hover:bg-gray-700 text-gray-200 text-xs font-medium py-2 rounded-xl transition border border-gray-700">Edit Paket Enterprise</button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Bagian 2: Tabel Distribusi Pengguna Aktif -->
            <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                <h3 class="text-sm font-semibold text-white">Distribusi Pengguna Aktif</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-300">
                        <thead class="text-gray-400 uppercase text-[10px] tracking-wider border-b border-gray-800 pb-2">
                            <tr>
                                <th class="pb-3">Nama Paket</th>
                                <th class="pb-3">Total Tenant Terdaftar</th>
                                <th class="pb-3">Akumulasi Nilai Kontrak / Bulan</th>
                                <th class="pb-3">Status Subscriber</th>
                                <th class="pb-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/60">
                            <tr class="hover:bg-[#161e2e]/40">
                                <td class="py-3.5 font-bold text-white">Starter</td>
                                <td class="py-3.5 text-gray-300">8 Bengkel</td>
                                <td class="py-3.5 font-mono text-gray-300">Rp 792.000</td>
                                <td class="py-3.5"><span class="bg-green-500/20 text-green-400 px-2.5 py-1 rounded text-[10px] font-bold">Stabil & Aktif</span></td>
                                <td class="py-3.5 text-right"><button class="text-blue-400 hover:underline">Detail</button></td>
                            </tr>
                            <tr class="hover:bg-[#161e2e]/40">
                                <td class="py-3.5 font-bold text-white">Pro Tenant</td>
                                <td class="py-3.5 text-gray-300">12 Bengkel</td>
                                <td class="py-3.5 font-mono text-gray-300">Rp 2.988.000</td>
                                <td class="py-3.5"><span class="bg-blue-500/20 text-blue-400 px-2.5 py-1 rounded text-[10px] font-bold">Tumbuh Cepat</span></td>
                                <td class="py-3.5 text-right"><button class="text-blue-400 hover:underline">Detail</button></td>
                            </tr>
                            <tr class="hover:bg-[#161e2e]/40">
                                <td class="py-3.5 font-bold text-white">Enterprise</td>
                                <td class="py-3.5 text-gray-300">2 Bengkel</td>
                                <td class="py-3.5 font-mono text-gray-300">Rp 1.598.000</td>
                                <td class="py-3.5"><span class="bg-yellow-500/20 text-yellow-400 px-2.5 py-1 rounded text-[10px] font-bold">Potensi Premium</span></td>
                                <td class="py-3.5 text-right"><button class="text-blue-400 hover:underline">Detail</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>
</html>