<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Global - AMAHAY Admin</title>
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
            <span class="text-xs font-semibold text-gray-400 tracking-wide uppercase">Dashboard Ringkasan Global Platform</span>
            <div class="flex items-center space-x-2 bg-[#1f2937] px-3 py-1.5 rounded-full border border-gray-800 text-xs">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                <span class="text-white font-medium">Admin Platform</span>
            </div>
        </header>

        <!-- Area Konten Utama -->
        <div class="p-8 space-y-6">
            
            <!-- Judul Halaman -->
            <div>
                <h1 class="text-lg font-bold text-white tracking-wide">Ringkasan Ekosistem SaaS AMAHAY</h1>
                <p class="text-xs text-gray-400 mt-0.5">Statistik menyeluruh pertumbuhan tenant, aktivitas server, dan kesehatan finansial.</p>
            </div>

            <!-- 4 Kartu Metrik Utama -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div class="bg-[#111827] border border-gray-800 p-5 rounded-2xl shadow-lg space-y-2">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Tenant Aktif</p>
                    <h3 class="text-2xl font-bold text-white">22 Bengkel</h3>
                    <p class="text-[11px] text-green-400 font-medium">▲ +3 bulan ini</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-5 rounded-2xl shadow-lg space-y-2">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Pendapatan Bulanan (MRR)</p>
                    <h3 class="text-2xl font-bold text-blue-400">Rp 5.378.000</h3>
                    <p class="text-[11px] text-blue-300 font-medium">Akumulasi langganan aktif</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-5 rounded-2xl shadow-lg space-y-2">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Servis Global</p>
                    <h3 class="text-2xl font-bold text-white">142 Nota</h3>
                    <p class="text-[11px] text-gray-400 font-medium">Bulan September 2026</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-5 rounded-2xl shadow-lg space-y-2">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Status Kesehatan Server</p>
                    <h3 class="text-2xl font-bold text-green-400">99.9%</h3>
                    <p class="text-[11px] text-gray-400 font-medium">Normal & Stabil</p>
                </div>
            </div>

            <!-- Bagian Grafik / Aktivitas Terbaru -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Aktivitas Tenant Terbaru -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <h3 class="text-sm font-semibold text-white">Aktivitas & Pendaftaran Terbaru</h3>
                    <div class="space-y-3 text-xs text-gray-300">
                        <div class="flex items-center justify-between border-b border-gray-800/60 pb-3">
                            <div>
                                <p class="font-bold text-white">Bengkel Maju Jaya</p>
                                <p class="text-[10px] text-gray-400">Memperbarui paket ke Pro Tenant</p>
                            </div>
                            <span class="text-[10px] text-gray-500">Baru saja</span>
                        </div>
                        <div class="flex items-center justify-between border-b border-gray-800/60 pb-3">
                            <div>
                                <p class="font-bold text-white">AAA Bike</p>
                                <p class="text-[10px] text-gray-400">Pendaftaran akun tenant baru (Starter)</p>
                            </div>
                            <span class="text-[10px] text-gray-500">2 jam lalu</span>
                        </div>
                        <div class="flex items-center justify-between pb-1">
                            <div>
                                <p class="font-bold text-white">Piston Garage</p>
                                <p class="text-[10px] text-red-400">Peringatan: Masa langganan tertunda</p>
                            </div>
                            <span class="text-[10px] text-gray-500">1 hari lalu</span>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Beban Server -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <h3 class="text-sm font-semibold text-white">Kinerja Sistem & Database Tenant</h3>
                    <div class="space-y-4 pt-1">
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-400">Kapasitas Database Multi-Tenant</span>
                                <span class="text-white font-medium">42% (Terpakai)</span>
                            </div>
                            <div class="w-full bg-gray-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-blue-600 h-full rounded-full" style="width: 42%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-400">Penggunaan Bandwidth API Gateway</span>
                                <span class="text-white font-medium">68%</span>
                            </div>
                            <div class="w-full bg-gray-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-full rounded-full" style="width: 68%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-400">Penyimpanan Storage Cloud (Media & Nota)</span>
                                <span class="text-white font-medium">25 GB / 100 GB</span>
                            </div>
                            <div class="w-full bg-gray-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-green-600 h-full rounded-full" style="width: 25%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>