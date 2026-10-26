<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Bengkel - AMAHAY</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex flex-col justify-between">

    <div>
        <!-- Navbar Atas -->
        <header class="border-b border-gray-800/80 bg-[#0b0f19]/80 backdrop-blur sticky top-0 z-50 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.9 6.9a2.12 2.12 0 1 1-3-3l6.9-6.9a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                        </svg>
                    </div>
                    <span class="text-lg font-bold tracking-wider text-white">AMAHAY</span>
                </div>
                <!-- Menu Navigasi -->
                <nav class="hidden md:flex items-center space-x-6 text-xs text-gray-400">
                    <a href="#" class="text-blue-400 font-medium">Cari Bengkel</a>
                    <a href="{{ route('user.cek.servis') }}" class="hover:text-white transition">Cek Status Servis</a>
                    <a href="{{ route('user.promo') }}" class="hover:text-white transition">Promo</a>
                    <a href="{{ route('user.riwayat') }}" class="hover:text-white transition">Riwayat</a>
                </nav>
            </div>
            <!-- User Profile Pill -->
            <div class="flex items-center space-x-2 bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-full text-xs">
                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center font-bold text-white">N</div>
                <span class="text-gray-200 font-medium">Nadira</span>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </header>

        <!-- Hero Search Section -->
        <section class="max-w-5xl mx-auto px-6 py-16 text-center">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Temukan Bengkel Terbaik di Sekitar Anda</h1>
            <p class="text-xs text-gray-400 mb-8">Temukan servis panggilan, lokasi bengkel, paket promo, dan sparepart motor</p>
            
            <!-- Search Bar -->
            <div class="max-w-xl mx-auto flex items-center bg-[#161e2e] border border-gray-700/80 rounded-2xl p-1.5 shadow-xl">
                <input type="text" placeholder="Cari nama bengkel, lokasi, atau jenis motor..." 
                    class="w-full bg-transparent px-4 py-2.5 text-xs text-white placeholder-gray-500 focus:outline-none">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-xs font-medium transition shadow-md shadow-blue-600/30">
                    Cari
                </button>
            </div>

            <!-- Quick Filter Badges -->
            <div class="flex flex-wrap items-center justify-center gap-3 mt-6 text-xs text-gray-400">
                <button class="bg-[#161e2e] border border-gray-800 px-3.5 py-1.5 rounded-lg hover:border-blue-500 transition">🔧 Terdekat</button>
                <button class="bg-[#161e2e] border border-gray-800 px-3.5 py-1.5 rounded-lg hover:border-blue-500 transition">⚡ Ganti Oli</button>
                <button class="bg-[#161e2e] border border-gray-800 px-3.5 py-1.5 rounded-lg hover:border-blue-500 transition">🛠️ Servis Besar</button>
                <button class="bg-[#161e2e] border border-gray-800 px-3.5 py-1.5 rounded-lg hover:border-blue-500 transition">🛵 Booking & Antrean</button>
                <button class="bg-[#161e2e] border border-gray-800 px-3.5 py-1.5 rounded-lg hover:border-blue-500 transition">📦 Stok Suku Cadang</button>
            </div>
        </section>

        <!-- Rekomendasi Terdekat -->
        <section class="max-w-6xl mx-auto px-6 pb-20">
            <h2 class="text-sm font-bold text-white mb-4">Rekomendasi Terdekat</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Card 1 -->
                <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg relative flex flex-col justify-between">
                    <div>
                        <div class="text-[10px] text-gray-500 mb-2">Pro Bengkel Rekomendasi</div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-bold text-white">Bengkel Maju Jaya</h3>
                            <span class="text-xs bg-yellow-500/10 text-yellow-400 font-semibold px-2 py-0.5 rounded">⭐ 4.9</span>
                        </div>
                        <div class="text-[11px] bg-[#161e2e] text-green-400 px-2.5 py-1 rounded-md inline-block mb-3 font-medium">
                            🟢 Buka — Antrean Aktif: 3
                        </div>
                        <div class="space-y-1.5 text-xs text-gray-400 mb-4">
                            <p>📍 Jl. Sudirman No. 205 (1.2 km)</p>
                            <p>📞 Buka 08:00 - 17:00 WIB</p>
                            <p class="text-[11px] text-gray-500">Estimasi waktu tunggu: ± 15 mnt</p>
                        </div>
                    </div>
                <!-- Contoh pada card bengkel -->
                <a href="{{ url('/user-menu/bengkel/bengkel-maju-jaya') }}" class="block w-full text-center bg-[#1f2937] hover:bg-blue-600 hover:text-white text-gray-300 font-medium py-2.5 rounded-xl text-xs transition duration-200 border border-gray-700/50">
                    Lihat Detail & Booking
                </a>
                </div>

                <!-- Card 2 -->
                <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg relative flex flex-col justify-between">
                    <div>
                        <div class="text-[10px] text-gray-500 mb-2">Pro Partner Auto</div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-bold text-white">Abadi Motor</h3>
                            <span class="text-xs bg-yellow-500/10 text-yellow-400 font-semibold px-2 py-0.5 rounded">⭐ 4.8</span>
                        </div>
                        <div class="text-[11px] bg-[#161e2e] text-green-400 px-2.5 py-1 rounded-md inline-block mb-3 font-medium">
                            🟢 Buka — Antrean Aktif: 5
                        </div>
                        <div class="space-y-1.5 text-xs text-gray-400 mb-4">
                            <p>📍 Jl. Mayjen Sungkono No. 122 (2.4 km)</p>
                            <p>📞 Buka 08:00 - 18:00 WIB</p>
                            <p class="text-[11px] text-gray-500">Estimasi waktu tunggu: ± 25 mnt</p>
                        </div>
                    </div>
                    <button class="w-full bg-[#1f2937] hover:bg-blue-600 hover:text-white text-gray-300 font-medium py-2.5 rounded-xl text-xs transition duration-200 border border-gray-700/50">
                        Lihat Detail & Booking
                    </button>
                </div>

                <!-- Card 3 -->
                <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg relative flex flex-col justify-between">
                    <div>
                        <div class="text-[10px] text-gray-500 mb-2">Authorized Partner</div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-bold text-white">Bengkel Terangjaya Mtr</h3>
                            <span class="text-xs bg-yellow-500/10 text-yellow-400 font-semibold px-2 py-0.5 rounded">⭐ 4.7</span>
                        </div>
                        <div class="text-[11px] bg-[#161e2e] text-yellow-500 px-2.5 py-1 rounded-md inline-block mb-3 font-medium">
                            🟡 Sebentar Lagi Tutup
                        </div>
                        <div class="space-y-1.5 text-xs text-gray-400 mb-4">
                            <p>📍 Jl. Diponegoro No. 8-10 (3.1 km)</p>
                            <p>📞 Buka 08:00 - 16:00 WIB</p>
                            <p class="text-[11px] text-gray-500">Estimasi waktu tunggu: ± 10 mnt</p>
                        </div>
                    </div>
                    <button class="w-full bg-[#1f2937] hover:bg-blue-600 hover:text-white text-gray-300 font-medium py-2.5 rounded-xl text-xs transition duration-200 border border-gray-700/50">
                        Lihat Detail & Booking
                    </button>
                </div>

                <!-- Card 4 -->
                <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg relative flex flex-col justify-between">
                    <div>
                        <div class="text-[10px] text-gray-500 mb-2">Pro Bengkel Rekomendasi</div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-bold text-white">Satria Speed Workshop</h3>
                            <span class="text-xs bg-yellow-500/10 text-yellow-400 font-semibold px-2 py-0.5 rounded">⭐ 4.9</span>
                        </div>
                        <div class="text-[11px] bg-[#161e2e] text-green-400 px-2.5 py-1 rounded-md inline-block mb-3 font-medium">
                            🟢 Buka — Antrean Aktif: 2
                        </div>
                        <div class="space-y-1.5 text-xs text-gray-400 mb-4">
                            <p>📍 Jl. Ahmad Yani No. 45 (3.5 km)</p>
                            <p>📞 Buka 08:00 - 20:00 WIB</p>
                            <p class="text-[11px] text-gray-500">Estimasi waktu tunggu: ± 10 mnt</p>
                        </div>
                    </div>
                    <button class="w-full bg-[#1f2937] hover:bg-blue-600 hover:text-white text-gray-300 font-medium py-2.5 rounded-xl text-xs transition duration-200 border border-gray-700/50">
                        Lihat Detail & Booking
                    </button>
                </div>

                <!-- Card 5 -->
                <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg relative flex flex-col justify-between">
                    <div>
                        <div class="text-[10px] text-gray-500 mb-2">Official Partner</div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-bold text-white">Bintang Motor 24Jam</h3>
                            <span class="text-xs bg-yellow-500/10 text-yellow-400 font-semibold px-2 py-0.5 rounded">⭐ 4.6</span>
                        </div>
                        <div class="text-[11px] bg-[#161e2e] text-green-400 px-2.5 py-1 rounded-md inline-block mb-3 font-medium">
                            🟢 Buka 24 Jam — Antrean: 6
                        </div>
                        <div class="space-y-1.5 text-xs text-gray-400 mb-4">
                            <p>📍 Jl. Bypass Ngurah Rai No. 9 (4.0 km)</p>
                            <p>📞 Layanan 24 Jam Nonstop</p>
                            <p class="text-[11px] text-gray-500">Estimasi waktu tunggu: ± 30 mnt</p>
                        </div>
                    </div>
                    <button class="w-full bg-[#1f2937] hover:bg-blue-600 hover:text-white text-gray-300 font-medium py-2.5 rounded-xl text-xs transition duration-200 border border-gray-700/50">
                        Lihat Detail & Booking
                    </button>
                </div>

                <!-- Card 6 -->
                <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg relative flex flex-col justify-between">
                    <div>
                        <div class="text-[10px] text-gray-500 mb-2">Pro Bengkel Spesialis</div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-bold text-white">Garasi Matic Express</h3>
                            <span class="text-xs bg-yellow-500/10 text-yellow-400 font-semibold px-2 py-0.5 rounded">⭐ 4.9</span>
                        </div>
                        <div class="text-[11px] bg-[#161e2e] text-green-400 px-2.5 py-1 rounded-md inline-block mb-3 font-medium">
                            🟢 Buka — Antrean Aktif: 1
                        </div>
                        <div class="space-y-1.5 text-xs text-gray-400 mb-4">
                            <p>📍 Jl. Hayam Wuruk No. 78 (4.5 km)</p>
                            <p>📞 Buka 08:30 - 17:30 WIB</p>
                            <p class="text-[11px] text-gray-500">Estimasi waktu tunggu: ± 5 mnt</p>
                        </div>
                    </div>
                    <button class="w-full bg-[#1f2937] hover:bg-blue-600 hover:text-white text-gray-300 font-medium py-2.5 rounded-xl text-xs transition duration-200 border border-gray-700/50">
                        Lihat Detail & Booking
                    </button>
                </div>

            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="border-t border-gray-800/80 py-4 px-6 text-center text-[11px] text-gray-500 flex justify-between max-w-6xl mx-auto w-full">
        <span>© AMAHAY 2026</span>
        <span>SaaS Manajemen Bengkel & Konsumen Portal</span>
    </footer>

</body>
</html>