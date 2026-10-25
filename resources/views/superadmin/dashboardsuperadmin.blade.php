<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - AMAHAY</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex">

    <!-- Sidebar Super Admin -->
    <aside class="w-64 bg-[#111827] border-r border-gray-800 flex flex-col justify-between hidden md:flex">
        <div>
            <!-- Brand / Logo -->
            <div class="h-16 flex items-center px-6 border-b border-gray-800 space-x-3">
                <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.9 6.9a2.12 2.12 0 1 1-3-3l6.9-6.9a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                        </path>
                    </svg>
                </div>
                <span class="text-base font-bold tracking-wider text-white">AMAHAY Admin</span>
            </div>

            <!-- Menu Sidebar (5 Fitur Super Admin) -->
            <nav class="p-4 space-y-1.5 text-xs">
                <a href="/test-superadmin-dashboard"
                    class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-dashboard') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>📊</span>
                    <span>Dashboard Global</span>
                </a>
                <a href="/test-superadmin"
                    class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>🏢</span>
                    <span>Kelola Bengkel (Tenant)</span>
                </a>
                <a href="/test-superadmin-laporan"
                    class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-laporan') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>💵</span>
                    <span>Laporan Keuangan</span>
                </a>
                <a href="/test-superadmin-paket"
                    class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-paket') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>📦</span>
                    <span>Manajemen Paket</span>
                </a>
                <a href="/test-superadmin-pengaturan"
                    class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-pengaturan') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>⚙️</span>
                    <span>Pengaturan Platform</span>
                </a>
            </nav>
        </div>

        <!-- Footer Sidebar (Info Sistem + Tombol Logout) -->
        <div class="p-4 border-t border-gray-800 space-y-3">
            <div class="text-[10px] text-gray-500">
                Sistem Multi-Tenant v1.0<br>Super Admin Access
            </div>
            <a href="/"
                class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 text-xs font-medium py-2 px-3 rounded-xl transition flex items-center justify-center space-x-2">
                <span>🚪</span>
                <span>Keluar (Logout)</span>
            </a>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 flex flex-col min-h-screen">

        <!-- Top Navbar -->
        <header class="h-16 bg-[#111827] border-b border-gray-800 flex items-center justify-between px-8">
            <h1 class="text-xs font-semibold text-gray-300 tracking-wide uppercase">Manajemen Tenant</h1>
            <div
                class="flex items-center space-x-2 bg-[#1f2937] px-3 py-1.5 rounded-full border border-gray-800 text-xs">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                <span class="text-white font-medium">Admin Line</span>
            </div>
        </header>

        <!-- Area Konten Tabel -->
        <div class="p-8 space-y-6">

            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-white">Daftar Bengkel Langganan</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Kelola akses, paket, dan status pembayaran tenant Anda.</p>
                </div>
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-2 rounded-xl shadow transition">
                    + Daftarkan Bengkel Baru
                </button>
            </div>

            <!-- Tabel Daftar Bengkel -->
            <div class="bg-[#111827] border border-gray-800 rounded-2xl overflow-hidden shadow-lg">
                <table class="w-full text-left text-xs text-gray-300">
                    <thead
                        class="bg-[#161e2e] text-gray-400 uppercase text-[10px] tracking-wider border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-3.5">Identitas Bengkel</th>
                            <th class="px-6 py-3.5">Kontak Pemilik</th>
                            <th class="px-6 py-3.5">Paket Langganan</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <!-- Baris 1 -->
                        <tr class="hover:bg-[#161e2e]/50 transition">
                            <td class="px-6 py-4">
                                <p class="font-bold text-white">Bengkel Maju Jaya</p>
                                <p class="text-[10px] text-gray-400">Bergabung: 15 Jan 2026</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-200">Budi Santoso</p>
                                <p class="text-[10px] text-gray-400">0812-3456-7890</p>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-200">Pro Tenant</td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-[10px] font-bold border border-green-500/30">AKTIF</span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-1.5">
                                <button
                                    class="bg-[#1f2937] hover:bg-gray-700 text-gray-200 px-3 py-1.5 rounded-lg text-xs transition border border-gray-700">Edit</button>
                                <button
                                    class="bg-[#1f2937] hover:bg-gray-700 text-gray-200 px-3 py-1.5 rounded-lg text-xs transition border border-gray-700">Detail</button>
                            </td>
                        </tr>
                        <!-- Baris 2 -->
                        <tr class="hover:bg-[#161e2e]/50 transition">
                            <td class="px-6 py-4">
                                <p class="font-bold text-white">AAA Bike</p>
                                <p class="text-[10px] text-gray-400">Bergabung: 05 Mar 2026</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-200">Agus Supriyadi</p>
                                <p class="text-[10px] text-gray-400">0856-1234-5678</p>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-200">Starter</td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-[10px] font-bold border border-green-500/30">AKTIF</span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-1.5">
                                <button
                                    class="bg-[#1f2937] hover:bg-gray-700 text-gray-200 px-3 py-1.5 rounded-lg text-xs transition border border-gray-700">Edit</button>
                                <button
                                    class="bg-[#1f2937] hover:bg-gray-700 text-gray-200 px-3 py-1.5 rounded-lg text-xs transition border border-gray-700">Detail</button>
                            </td>
                        </tr>
                        <!-- Baris 3 -->
                        <tr class="hover:bg-[#161e2e]/50 transition">
                            <td class="px-6 py-4">
                                <p class="font-bold text-white">Piston Garage</p>
                                <p class="text-[10px] text-gray-400">Bergabung: 22 Nov 2025</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-200">Joko Anwar</p>
                                <p class="text-[10px] text-gray-400">0813-9870-5432</p>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-200">Pro Tenant</td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-[10px] font-bold border border-red-500/30">TELAT
                                    BAYAR</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button
                                    class="bg-red-600/20 hover:bg-red-600/30 text-red-400 px-3 py-1.5 rounded-lg text-xs font-medium transition border border-red-500/30">Blokir
                                    Akses</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>

</html>