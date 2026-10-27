<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Platform - AMAHAY Admin</title>
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
            <span class="text-xs font-semibold text-gray-400 tracking-wide">Pengaturan Platform Global</span>
            <div class="flex items-center space-x-2 bg-[#1f2937] px-3 py-1 rounded-full border border-gray-800 text-xs">
                <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-[10px]">A</span>
                <span class="text-white font-medium">Admin Platform</span>
            </div>
        </header>

        <!-- Area Konten Utama -->
        <div class="p-8 space-y-6">
            
            <div>
                <h1 class="text-base font-bold text-white">Pengaturan Sistem Inti</h1>
                <p class="text-xs text-gray-400 mt-0.5">Konfigurasi menyeluruh nama sistem, pemeliharaan server, dan integrasi API utama.</p>
            </div>

            <!-- Grid 2 Kolom -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Kolom Kiri: Informasi Umum Platform -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <h3 class="text-sm font-semibold text-white border-b border-gray-800 pb-3">Informasi Umum Platform</h3>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-medium text-gray-400 mb-1">Nama Aplikasi / Brand</label>
                            <input type="text" value="AMAHAY - Sistem Manajemen Bengkel" class="w-full bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-2 text-xs text-white focus:outline-none focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-medium text-gray-400 mb-1">Email Kontak Dukungan (B2B)</label>
                            <input type="email" value="support@amahay.com" class="w-full bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-2 text-xs text-white focus:outline-none focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-medium text-gray-400 mb-1">Zona Waktu / Region Server</label>
                            <input type="text" value="Asia/Jakarta (WIB)" class="w-full bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-2 text-xs text-white focus:outline-none focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-[11px] font-medium text-gray-400 mb-1">Mata Uang Default</label>
                            <input type="text" value="IDR (Rupiah - Rp)" class="w-full bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-2 text-xs text-white focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Kondisi Server & Status Servis -->
                <div class="space-y-6">
                    
                    <!-- Kotak 1: Maintenance & Status -->
                    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                        <h3 class="text-sm font-semibold text-white border-b border-gray-800 pb-3">Kondisi Server & Status Servis</h3>

                        <div class="space-y-4">
                            <!-- Toggle 1 -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-white">Sale/Server Tenant Buka</p>
                                    <p class="text-[10px] text-gray-400">Sistem operasional dan database tenant aktif.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" checked class="sr-only peer">
                                    <div class="w-9 h-5 bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-600"></div>
                                </label>
                            </div>

                            <!-- Toggle 2 -->
                            <div class="flex items-center justify-between border-t border-gray-800 pt-3">
                                <div>
                                    <p class="text-xs font-bold text-red-400">Mode Paksa Keluar (Force Logout)</p>
                                    <p class="text-[10px] text-gray-400">Blokir seluruh sesi tenant aktif saat migrasi / perbaikan.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-9 h-5 bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-red-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Kotak 2: Integrasi Midtrans API Key -->
                    <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                        <h3 class="text-sm font-semibold text-white border-b border-gray-800 pb-3">Integrasi Global (API Key)</h3>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-[11px] font-medium text-gray-400 mb-1">Midtrans Server Key (Billing & Langganan)</label>
                                <input type="password" value="SB-Mid-server-xxxxxxxxx" class="w-full bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-2 text-xs text-white font-mono focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-medium text-gray-400 mb-1">Webhook Gateway URL Notifikasi</label>
                                <input type="text" value="https://api.amahay.com/v1/webhook/payment" class="w-full bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-2 text-xs text-white font-mono focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Tombol Aksi Simpan Bawah -->
            <div class="flex justify-end pt-2">
                <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-6 py-2.5 rounded-xl shadow transition">
                    Simpan Perubahan Konfigurasi
                </button>
            </div>

        </div>
    </main>

</body>
</html>