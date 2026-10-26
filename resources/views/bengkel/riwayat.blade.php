<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Servis - AMAHAY</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex flex-col justify-between">

    <div>
        <!-- Navbar Atas -->
        <header class="border-b border-gray-800/80 bg-[#0b0f19]/80 backdrop-blur sticky top-0 z-50 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('user.menu') }}" class="text-xs bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-lg text-gray-400 hover:text-white transition">
                    ← Kembali ke Menu
                </a>
                <span class="text-sm font-bold text-white hidden md:inline">Riwayat Servis & Transaksi</span>
            </div>
            <!-- User Profile Pill -->
            <div class="flex items-center space-x-2 bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-full text-xs">
                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center font-bold text-white">N</div>
                <span class="text-gray-200 font-medium">Nadira</span>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto px-6 py-10">
            
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-white mb-2">Riwayat Perawatan Kendaraan</h1>
                <p class="text-xs text-gray-400">Daftar seluruh catatan servis, penggantian sparepart, dan transaksi yang pernah Anda lakukan.</p>
            </div>

            <!-- List Riwayat -->
            <div class="space-y-4">
                
                <!-- Item Riwayat 1 -->
                <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="text-[10px] bg-green-500/10 text-green-400 font-semibold px-2.5 py-0.5 rounded-md border border-green-500/20">Selesai</span>
                            <span class="text-[10px] text-gray-400">12 Maret 2026 • 10:30 WIB</span>
                        </div>
                        <h3 class="text-sm font-bold text-white">Honda BeAT 2022 <span class="text-xs font-normal text-gray-400">(L 4567 XY)</span></h3>
                        <p class="text-xs text-gray-400 mt-0.5">Bengkel Maju Jaya — Servis Ringan + Ganti Oli MPX2</p>
                    </div>
                    <div class="text-left md:text-right w-full md:w-auto flex md:flex-col justify-between items-center md:items-end border-t md:border-t-0 pt-3 md:pt-0 border-gray-800">
                        <span class="text-xs font-bold text-blue-400">Rp 75.000</span>
                        <button class="mt-2 text-xs bg-[#161e2e] border border-gray-700 hover:border-blue-500 text-gray-300 px-3.5 py-1.5 rounded-xl transition">
                            Unduh Nota 📄
                        </button>
                    </div>
                </div>

                <!-- Item Riwayat 2 -->
                <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="text-[10px] bg-green-500/10 text-green-400 font-semibold px-2.5 py-0.5 rounded-md border border-green-500/20">Selesai</span>
                            <span class="text-[10px] text-gray-400">05 Januari 2026 • 14:15 WIB</span>
                        </div>
                        <h3 class="text-sm font-bold text-white">Honda BeAT 2022 <span class="text-xs font-normal text-gray-400">(L 4567 XY)</span></h3>
                        <p class="text-xs text-gray-400 mt-0.5">Abadi Motor — Ganti Kampas Rem Belakang & Ban</p>
                    </div>
                    <div class="text-left md:text-right w-full md:w-auto flex md:flex-col justify-between items-center md:items-end border-t md:border-t-0 pt-3 md:pt-0 border-gray-800">
                        <span class="text-xs font-bold text-blue-400">Rp 185.000</span>
                        <button class="mt-2 text-xs bg-[#161e2e] border border-gray-700 hover:border-blue-500 text-gray-300 px-3.5 py-1.5 rounded-xl transition">
                            Unduh Nota 📄
                        </button>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- Footer -->
    <footer class="border-t border-gray-800/80 py-4 px-6 text-center text-[11px] text-gray-500 flex justify-between max-w-4xl mx-auto w-full mt-12">
        <span>© AMAHAY 2026</span>
        <span>SaaS Manajemen Bengkel & Konsumen Portal</span>
    </footer>

</body>
</html>