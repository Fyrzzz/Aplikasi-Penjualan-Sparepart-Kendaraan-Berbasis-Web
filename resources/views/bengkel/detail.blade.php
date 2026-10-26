<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail & Booking - AMAHAY</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex flex-col justify-between">

    <div>
        <!-- Navbar Atas -->
        <header class="border-b border-gray-800/80 bg-[#0b0f19]/80 backdrop-blur sticky top-0 z-50 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('user.menu') }}" class="text-xs bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-lg text-gray-400 hover:text-white transition">
                    ← Kembali ke Pencarian
                </a>
                <span class="text-sm font-bold text-white hidden md:inline">Detail Bengkel & Booking</span>
            </div>
            <!-- User Profile Pill -->
            <div class="flex items-center space-x-2 bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-full text-xs">
                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center font-bold text-white">N</div>
                <span class="text-gray-200 font-medium">Nadira</span>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-6xl mx-auto px-6 py-8">
            
            <!-- Header Info Bengkel -->
            <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-6 mb-8 shadow-lg">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <span class="text-[10px] bg-blue-500/10 text-blue-400 font-semibold px-2.5 py-1 rounded-md">Pro Bengkel Rekomendasi</span>
                        <h1 class="text-xl md:text-2xl font-bold text-white mt-2">Bengkel Maju Jaya</h1>
                        <p class="text-xs text-gray-400 mt-1">📍 Jl. Sudirman No. 205 (1.2 km) • Buka 08:00 - 17:00 WIB</p>
                    </div>
                    <div>
                        <span class="text-xs bg-yellow-500/10 text-yellow-400 font-semibold px-2.5 py-1 rounded">⭐ 4.9 (128 ulasan)</span>
                        <p class="text-[11px] text-green-400 mt-2">🟢 Buka — Antrean Aktif: 3</p>
                    </div>
                </div>
            </div>

            <!-- Grid 2 Kolom -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Kolom Kiri: Layanan & Fasilitas (2 Span) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Pilih Paket Servis -->
                    <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
                        <h2 class="text-sm font-bold text-white mb-4">Pilih Jenis Servis / Paket</h2>
                        
                        <div class="space-y-3">
                            <label class="flex items-center justify-between p-4 bg-[#161e2e] border border-gray-800 rounded-xl cursor-pointer hover:border-blue-500 transition">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" name="paket_servis" class="text-blue-600 focus:ring-blue-500 bg-gray-900 border-gray-700" checked>
                                    <div>
                                        <p class="text-xs font-bold text-white">Servis Ringan + Ganti Oli</p>
                                        <p class="text-[11px] text-gray-400">Pembersihan CVT, cek rem, dan ganti oli mesin.</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-blue-400">Rp 75.000</span>
                            </label>

                            <label class="flex items-center justify-between p-4 bg-[#161e2e] border border-gray-800 rounded-xl cursor-pointer hover:border-blue-500 transition">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" name="paket_servis" class="text-blue-600 focus:ring-blue-500 bg-gray-900 border-gray-700">
                                    <div>
                                        <p class="text-xs font-bold text-white">Servis Besar / Turun Mesin</p>
                                        <p class="text-[11px] text-gray-400">Pengecekan total komponen mesin dan pembersihan karbu/injeksi.</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-blue-400">Rp 200.000</span>
                            </label>
                        </div>
                    </div>

                    <!-- Fasilitas Bengkel -->
                    <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
                        <h2 class="text-sm font-bold text-white mb-4">Fasilitas Bengkel</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-xs text-gray-300">
                            <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800">🛋️ Ruang Tunggu AC</div>
                            <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800">☕ Free Coffee/Tea</div>
                            <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800">📶 Wi-Fi Gratis</div>
                            <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800">💳 Pembayaran QRIS</div>
                            <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800">📜 Garansi Servis</div>
                        </div>
                    </div>

                </div>

                <!-- Kolom Kanan: Form Booking Cepat (1 Span) -->
                <div class="lg:col-span-1">
                    <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-6 shadow-xl sticky top-24">
                        <h2 class="text-sm font-bold text-white mb-4">Formulir Booking Cepat</h2>
                        
                        <form action="#" method="POST" class="space-y-4 text-xs">
                            @csrf
                            <div>
                                <label class="block text-gray-400 mb-1.5">Jenis / Merek Motor</label>
                                <input type="text" placeholder="Contoh: Honda BeAT 2022" class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-gray-400 mb-1.5">Tanggal Kedatangan</label>
                                <input type="date" class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-gray-400 mb-1.5">Pilih Jam Sesi Antrean</label>
                                <select class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-blue-500">
                                    <option>09:00 - 10:00 WIB (Tersedia)</option>
                                    <option>10:00 - 11:00 WIB (Tersedia)</option>
                                    <option>13:00 - 14:00 WIB (Padat)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-400 mb-1.5">Keluhan / Catatan (Opsional)</label>
                                <textarea rows="2" placeholder="Contoh: Rem belakang agak bunyi..." class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"></textarea>
                            </div>

                            <div class="pt-2 border-t border-gray-800">
                                <div class="flex justify-between text-gray-400 mb-3">
                                    <span>Estimasi Total</span>
                                    <span class="text-sm font-bold text-blue-400">Rp 75.000</span>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl text-xs transition shadow-lg shadow-blue-600/30">
                                    Konfirmasi & Ambil Antrean 🚀
                                </button>
                            </div>
                        </form>
                    </div>
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