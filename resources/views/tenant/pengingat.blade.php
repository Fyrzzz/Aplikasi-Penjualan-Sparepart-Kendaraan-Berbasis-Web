<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Servis - AMAHAY</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex">

    <!-- Sidebar Tenant -->
    <aside class="w-64 bg-[#111827] border-r border-gray-800 flex flex-col justify-between hidden md:flex">
        <div>
            <!-- Brand / Logo -->
            <div class="h-16 flex items-center px-6 border-b border-gray-800 space-x-3">
                <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.9 6.9a2.12 2.12 0 1 1-3-3l6.9-6.9a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-sm font-bold tracking-wider text-white block">AMAHAY</span>
                    <span class="text-[10px] text-gray-400 block">Bengkel & POS System</span>
                </div>
            </div>

            <!-- Menu Sidebar -->
            <nav class="p-4 space-y-1.5 text-xs">
                <a href="/owner/dashboard" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="/owner/antrean" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>🛠️</span>
                    <span>Antrean Service</span>
                </a>
                <a href="/owner/kasir" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>💰</span>
                    <span>Kasir / POS</span>
                </a>
                <a href="/owner/stok" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>📦</span>
                    <span>Stok Sparepart</span>
                </a>
                <a href="/owner/mekanik" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>👥</span>
                    <span>Pelanggan & Mekanik</span>
                </a>
                <a href="/owner/pengingat" class="flex items-center space-x-3 px-4 py-2.5 bg-[#1f2937] text-white rounded-xl font-medium shadow-sm border border-gray-700/50">
                    <span>🔔</span>
                    <span>Pengingat Service</span>
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-gray-800">
            <div class="flex items-center space-x-3 bg-[#161e2e] p-2.5 rounded-xl border border-gray-800">
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold flex items-center justify-center text-xs">AG</div>
                <div class="text-xs">
                    <p class="font-bold text-white">Agus Setiawan</p>
                    <p class="text-[10px] text-gray-400">Kepala Mekanik</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Konten Utama Pengingat Servis -->
    <main class="flex-1 flex flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-[#111827] border-b border-gray-800 flex items-center justify-between px-8">
            <div>
                <h1 class="text-xs font-bold text-white tracking-wide uppercase">Pengendali Servis Pelanggan</h1>
                <p class="text-[10px] text-gray-400">Kirimkan pengingat servis otomatis via WhatsApp berdasarkan riwayat jarak tempuh & waktu.</p>
            </div>
            <div class="flex items-center space-x-3">
                <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-2 rounded-xl shadow transition">
                    + Buat Pengingat Baru
                </button>
            </div>
        </header>

        <!-- Area Konten Pengingat -->
        <div class="p-8 space-y-6 flex-1">
            
            <!-- 4 Kartu Metrik Ringkasan Atas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Jatuh Tempo</p>
                    <h3 class="text-2xl font-bold text-red-400 mt-1">3 Pelanggan</h3>
                    <p class="text-[10px] text-red-400 font-medium mt-1">🚨 Wajib diingatkan hari ini</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Akan Datang (7 Hari)</p>
                    <h3 class="text-2xl font-bold text-yellow-400 mt-1">6 Pelanggan</h3>
                    <p class="text-[10px] text-yellow-400 font-medium mt-1">⏳ Mendekati jadwal</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Pesan Terkirim</p>
                    <h3 class="text-2xl font-bold text-white mt-1">28 Pesan</h3>
                    <p class="text-[10px] text-green-400 font-medium mt-1">📱 Via WhatsApp Gateway</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Conversion Rate</p>
                    <h3 class="text-2xl font-bold text-blue-400 mt-1">82%</h3>
                    <p class="text-[10px] text-blue-300 font-medium mt-1">🎯 Kembali datang servis</p>
                </div>
            </div>

            <!-- Tab Filter & Tombol Broadcast -->
            <div class="flex items-center justify-between">
                <div class="flex bg-[#111827] p-1 rounded-xl border border-gray-800 text-xs">
                    <button class="bg-blue-600 text-white px-4 py-1.5 rounded-lg font-medium shadow">Siap Broadcast (3)</button>
                    <button class="text-gray-400 px-4 py-1.5 rounded-lg hover:text-white transition">Menunggu Jadwal (6)</button>
                    <button class="text-gray-400 px-4 py-1.5 rounded-lg hover:text-white transition">Riwayat Terkirim</button>
                </div>
                <button class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold px-4 py-2 rounded-xl shadow transition">
                    📢 Kirim Broadcast Massal (WhatsApp)
                </button>
            </div>

            <!-- Grid Kartu Daftar Pengingat -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Card 1 -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-sm font-bold text-white">Pak Joko</h3>
                            <p class="text-[10px] text-gray-400 font-mono">0812-3456-7890</p>
                        </div>
                        <span class="bg-red-500/20 text-red-400 text-[10px] px-2.5 py-1 rounded font-bold">Jatuh Tempo</span>
                    </div>

                    <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800 text-xs space-y-1">
                        <span class="text-[10px] text-gray-400 block font-mono">Honda Supra X (B 4567 AB)</span>
                        <p class="text-gray-200 font-medium">Ganti Oli Mesin & Cek Kampas Rem</p>
                        <span class="text-[10px] text-yellow-400 block pt-1">Terakhir Servis: 2 Bulan lalu (3.000 KM)</span>
                    </div>

                    <div class="pt-2">
                        <button class="w-full bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 rounded-xl shadow transition flex items-center justify-center space-x-2">
                            <span>💬 Kirim WhatsApp Pengingat</span>
                        </button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-sm font-bold text-white">Bu Ratna</h3>
                            <p class="text-[10px] text-gray-400 font-mono">0856-1234-5678</p>
                        </div>
                        <span class="bg-red-500/20 text-red-400 text-[10px] px-2.5 py-1 rounded font-bold">Jatuh Tempo</span>
                    </div>

                    <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800 text-xs space-y-1">
                        <span class="text-[10px] text-gray-400 block font-mono">Yamaha Mio (L 9012 XY)</span>
                        <p class="text-gray-200 font-medium">Servis Berkala & Ganti V-Belt CVT</p>
                        <span class="text-[10px] text-yellow-400 block pt-1">Terakhir Servis: 6 Bulan lalu (6.500 KM)</span>
                    </div>

                    <div class="pt-2">
                        <button class="w-full bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 rounded-xl shadow transition flex items-center justify-center space-x-2">
                            <span>💬 Kirim WhatsApp Pengingat</span>
                        </button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-sm font-bold text-white">Mas Rizky</h3>
                            <p class="text-[10px] text-gray-400 font-mono">0813-9870-5432</p>
                        </div>
                        <span class="bg-red-500/20 text-red-400 text-[10px] px-2.5 py-1 rounded font-bold">Jatuh Tempo</span>
                    </div>

                    <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800 text-xs space-y-1">
                        <span class="text-[10px] text-gray-400 block font-mono">Honda CB150R (P 8899 ZZ)</span>
                        <p class="text-gray-200 font-medium">Ganti Busi Racing & Setel Rantai</p>
                        <span class="text-[10px] text-yellow-400 block pt-1">Terakhir Servis: 4 Bulan lalu (4.500 KM)</span>
                    </div>

                    <div class="pt-2">
                        <button class="w-full bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 rounded-xl shadow transition flex items-center justify-center space-x-2">
                            <span>💬 Kirim WhatsApp Pengingat</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </main>

</body>
</html>