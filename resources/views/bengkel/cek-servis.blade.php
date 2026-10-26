<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Servis - AMAHAY</title>
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
                <span class="text-sm font-bold text-white hidden md:inline">Status Pengerjaan Servis</span>
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
                <h1 class="text-2xl font-bold text-white mb-2">Lacak Status Servis Motor Anda</h1>
                <p class="text-xs text-gray-400">Masukkan nomor plat nomor atau kode booking untuk melihat progres real-time dari bengkel.</p>
            </div>

            <!-- Search / Tracking Box -->
            <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-6 shadow-lg mb-8">
                <div class="flex flex-col md:flex-row gap-3">
                    <input type="text" placeholder="Masukkan Plat Nomor (Contoh: L 1234 AB) atau Kode Booking..." 
                        class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-4 py-3 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-xs font-medium transition shadow-md shadow-blue-600/30 whitespace-nowrap">
                        Lacak Status 🔍
                    </button>
                </div>
            </div>

            <!-- Hasil Tracking (Simulasi Status Aktif) -->
            <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-6 shadow-lg space-y-8">
                
                <!-- Info Header Kendaraan -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-800 pb-5 gap-3">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] bg-blue-500/10 text-blue-400 font-semibold px-2.5 py-0.5 rounded-md border border-blue-500/20">#AMH-88921</span>
                            <span class="text-[10px] bg-gray-800 text-gray-300 px-2 py-0.5 rounded">Bengkel Maju Jaya</span>
                        </div>
                        <h2 class="text-lg font-bold text-white">Honda BeAT 2022 <span class="text-xs font-normal text-gray-400">(L 4567 XY)</span></h2>
                        <p class="text-xs text-gray-400 mt-0.5">Paket: Servis Ringan + Ganti Oli MPX2</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-xs bg-yellow-500/10 text-yellow-400 font-semibold px-3 py-1.5 rounded-xl border border-yellow-500/20 inline-block">
                            ⚡ Sedang Dikerjakan (60%)
                        </span>
                        <p class="text-[11px] text-gray-400 mt-1">Estimasi Selesai: <span class="text-white font-medium">10:15 WIB</span></p>
                    </div>
                </div>

                <!-- Step Progress Bar Visual -->
                <div>
                    <h3 class="text-xs font-bold text-gray-400 mb-4 uppercase tracking-wider">Tahapan Pengerjaan</h3>
                    <div class="grid grid-cols-3 gap-2 text-center text-xs">
                        <!-- Step 1 (Selesai) -->
                        <div class="bg-[#161e2e] border border-blue-500/50 p-3 rounded-xl flex flex-col items-center">
                            <div class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-[10px] mb-1">✓</div>
                            <span class="text-white font-medium text-[11px]">Terdaftar</span>
                            <span class="text-[9px] text-gray-400 mt-0.5">08:30 WIB</span>
                        </div>
                        <!-- Step 2 (Aktif) -->
                        <div class="bg-blue-600/10 border border-blue-500 p-3 rounded-xl flex flex-col items-center shadow-lg shadow-blue-500/10">
                            <div class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-[10px] mb-1 animate-pulse">2</div>
                            <span class="text-blue-400 font-bold text-[11px]">Servis Mesin</span>
                            <span class="text-[9px] text-gray-400 mt-0.5">Sedang Proses</span>
                        </div>
                        <!-- Step 3 (Pending) -->
                        <div class="bg-[#161e2e] border border-gray-800 p-3 rounded-xl flex flex-col items-center opacity-50">
                            <div class="w-6 h-6 rounded-full bg-gray-700 text-gray-400 flex items-center justify-center font-bold text-[10px] mb-1">3</div>
                            <span class="text-gray-400 text-[11px]">Selesai & Kasir</span>
                            <span class="text-[9px] text-gray-500 mt-0.5">Menunggu</span>
                        </div>
                    </div>
                </div>

                <!-- Info Mekanik & Rincian Pekerjaan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kartu Mekanik -->
                    <div class="bg-[#161e2e] border border-gray-800 rounded-xl p-4 flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-800 border border-gray-700 rounded-full flex items-center justify-center text-base">👨‍🔧</div>
                        <div>
                            <p class="text-[10px] text-gray-400">Mekanik Penanggung Jawab</p>
                            <p class="text-xs font-bold text-white">Budi Santoso</p>
                            <p class="text-[10px] text-green-400">Spesialis Matik Honda</p>
                        </div>
                    </div>

                    <!-- Ringkasan Biaya -->
                    <div class="bg-[#161e2e] border border-gray-800 rounded-xl p-4 flex justify-between items-center">
                        <div>
                            <p class="text