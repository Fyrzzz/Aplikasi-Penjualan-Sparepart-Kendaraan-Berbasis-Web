<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo Bengkel - AMAHAY</title>
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
                <span class="text-sm font-bold text-white hidden md:inline">Promo & Voucher Spesial</span>
            </div>
            <!-- User Profile Pill -->
            <div class="flex items-center space-x-2 bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-full text-xs">
                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center font-bold text-white">N</div>
                <span class="text-gray-200 font-medium">Nadira</span>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-6xl mx-auto px-6 py-10">
            
            <div class="text-center mb-10">
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Promo Servis & Sparepart Motor</h1>
                <p class="text-xs text-gray-400">Nikmati potongan harga menarik dan cashback khusus pengguna platform AMAHAY.</p>
            </div>

            <!-- Grid Promo Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Promo 1 -->
                <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-blue-600 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl">
                        DISKON 25%
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-500 mb-1 block">Bengkel Maju Jaya</span>
                        <h3 class="text-sm font-bold text-white mb-2">Paket Ganti Oli + Tune Up</h3>
                        <p class="text-xs text-gray-400 mb-4">Dapatkan gratis pembersihan injektor setiap pengambilan paket servis lengkap.</p>
                        <div class="text-xs text-blue-400 font-medium mb-4">🕒 Berlaku s.d. 30 April 2026</div>
                    </div>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-xl text-xs transition shadow-md shadow-blue-600/30">
                        Klaim Voucher 🎟️
                    </button>
                </div>

                <!-- Promo 2 -->
                <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-green-600 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl">
                        CASHBACK 15K
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-500 mb-1 block">Abadi Motor</span>
                        <h3 class="text-sm font-bold text-white mb-2">Spesial Servis CVT Matik</h3>
                        <p class="text-xs text-gray-400 mb-4">Tarikan motor lebih enteng dengan grease dan pembersihan CVT standar pabrik.</p>
                        <div class="text-xs text-blue-400 font-medium mb-4">🕒 Berlaku s.d. 15 Mei 2026</div>
                    </div>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-xl text-xs transition shadow-md shadow-blue-600/30">
                        Klaim Voucher 🎟️
                    </button>
                </div>

                <!-- Promo 3 -->
                <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute top-0 right-0 bg-yellow-600 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl">
                        BUNDLE DEAL
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-500 mb-1 block">Satria Speed Workshop</span>
                        <h3 class="text-sm font-bold text-white mb-2">Paket Rantai & Kampas Rem</h3>
                        <p class="text-xs text-gray-400 mb-4">Potongan harga langsung untuk pembelian suku cadang asli dan ongkos pasang.</p>
                        <div class="text-xs text-blue-400 font-medium mb-4">🕒 Kuota Terbatas</div>
                    </div>
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 rounded-xl text-xs transition shadow-md shadow-blue-600/30">
                        Klaim Voucher 🎟️
                    </button>
                </div>

            </div>

        </main>
    </div>

    <!-- Footer -->
    <footer class="border-t border-gray-800/80 py-4 px-6 text-center text-[11px] text-gray-500 flex justify-between max-w-6xl mx-auto w-full mt-12">
        <span>© AMAHAY 2026</span>
        <span>SaaS Manajemen Bengkel & Konsumen Portal</span>
    </footer>

</body>
</html>