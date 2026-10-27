<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antrean Servis - AMAHAY</title>
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

            <!-- Menu Sidebar (Sudah diarahkan ke /owner/mekanik) -->
            <nav class="p-4 space-y-1.5 text-xs">
                <a href="/owner/dashboard" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="/owner/antrean" class="flex items-center space-x-3 px-4 py-2.5 bg-[#1f2937] text-white rounded-xl font-medium shadow-sm border border-gray-700/50">
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
                <a href="/owner/pengingat" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
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

    <!-- Konten Utama Antrean Servis -->
    <main class="flex-1 flex flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-[#111827] border-b border-gray-800 flex items-center justify-between px-8">
            <div>
                <h1 class="text-xs font-bold text-white tracking-wide uppercase">Manajemen Antrean Servis</h1>
                <p class="text-[10px] text-gray-400">Pantau status pengerjaan motor, alokasi mekanik, dan kasir per waktu selesai.</p>
            </div>

            <div class="flex items-center space-x-4">
                <input type="text" placeholder="Cari Plat, Pemilik, atau Motor..." class="bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-1.5 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 w-64">
                <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-2 rounded-xl shadow transition">
                    + Tambah Servis Baru
                </button>
            </div>
        </header>

        <!-- Area Konten Kanban 3 Kolom -->
        <div class="p-8 space-y-6 flex-1 flex flex-col">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow text-xs">
                <div class="flex items-center justify-between px-2">
                    <span class="text-gray-400 font-medium">Menunggu Diproses</span>
                    <span class="bg-yellow-500/20 text-yellow-400 px-2.5 py-0.5 rounded-full font-bold">2</span>
                </div>
                <div class="flex items-center justify-between px-2 border-x border-gray-800">
                    <span class="text-gray-400 font-medium">Sedang Dikerjakan</span>
                    <span class="bg-blue-500/20 text-blue-400 px-2.5 py-0.5 rounded-full font-bold">2</span>
                </div>
                <div class="flex items-center justify-between px-2">
                    <span class="text-gray-400 font-medium">Selesai (Menunggu Bayar)</span>
                    <span class="bg-green-500/20 text-green-400 px-2.5 py-0.5 rounded-full font-bold">1</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 flex-1">
                
                <!-- KOLOM 1 -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-4 space-y-4 shadow-lg flex flex-col">
                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                        <h3 class="text-xs font-bold text-yellow-400 uppercase tracking-wider">1. Menunggu Diproses</h3>
                        <span class="text-xs bg-yellow-500/20 text-yellow-400 w-5 h-5 rounded-full flex items-center justify-center font-bold">2</span>
                    </div>

                    <div class="space-y-3 flex-1">
                        <div class="bg-[#161e2e] border border-gray-800 rounded-xl p-3.5 space-y-2.5 shadow">
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="font-mono font-bold text-blue-400">#P08-2026-001</span>
                                <span class="text-gray-400">🕒 Est. 12:00 WIB</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">B 1234 XYZ • Pak Ahmad</p>
                                <p class="text-[10px] text-gray-400">Honda Vario 150</p>
                            </div>
                            <div class="bg-[#111827] p-2 rounded-lg border border-gray-800 text-[11px]">
                                <span class="text-gray-400 block text-[9px]">Keluhan:</span>
                                <p class="text-gray-200 font-medium">Servis Berkala + Ganti Oli & Kampas Rem</p>
                            </div>
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-medium py-1.5 rounded-lg transition shadow">
                                Mulai Kerjakan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- KOLOM 2 -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-4 space-y-4 shadow-lg flex flex-col">
                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                        <h3 class="text-xs font-bold text-blue-400 uppercase tracking-wider">2. Sedang Dikerjakan</h3>
                        <span class="text-xs bg-blue-500/20 text-blue-400 w-5 h-5 rounded-full flex items-center justify-center font-bold">2</span>
                    </div>

                    <div class="space-y-3 flex-1">
                        <div class="bg-[#161e2e] border border-gray-800 rounded-xl p-3.5 space-y-2.5 shadow">
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="font-mono font-bold text-blue-400">#P08-2026-003</span>
                                <span class="text-gray-400">🕒 Mulai 10:15 WIB</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">L 1234 XY • Eko Prasetyo</p>
                                <p class="text-[10px] text-gray-400">Yamaha NMAX 155</p>
                            </div>
                            <div class="bg-[#111827] p-2 rounded-lg border border-gray-800 text-[11px]">
                                <span class="text-gray-400 block text-[9px]">Pekerjaan:</span>
                                <p class="text-gray-200 font-medium">Tune Up Mesin + Ganti Oli MPX 2</p>
                            </div>
                            <button class="w-full bg-green-600 hover:bg-green-700 text-white text-[11px] font-medium py-1.5 rounded-lg transition shadow">
                                ✓ Tandai Selesai
                            </button>
                        </div>
                    </div>
                </div>

                <!-- KOLOM 3 -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-4 space-y-4 shadow-lg flex flex-col">
                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                        <h3 class="text-xs font-bold text-green-400 uppercase tracking-wider">3. Selesai (Menunggu Bayar)</h3>
                        <span class="text-xs bg-green-500/20 text-green-400 w-5 h-5 rounded-full flex items-center justify-center font-bold">1</span>
                    </div>

                    <div class="space-y-3 flex-1">
                        <div class="bg-[#161e2e] border border-gray-800 rounded-xl p-3.5 space-y-2.5 shadow">
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="font-mono font-bold text-blue-400">#P08-2026-000</span>
                                <span class="text-green-400 font-bold">✅ Selesai</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-white">P 7880 CC • Mas Hendra</p>
                                <p class="text-[10px] text-gray-400">Yamaha Aerox 155</p>
                            </div>
                            <div class="bg-[#111827] p-2 rounded-lg border border-gray-800 text-[11px]">
                                <span class="text-gray-400 block text-[9px]">Total Tagihan:</span>
                                <p class="text-green-400 font-bold text-sm">Rp 135.000</p>
                            </div>
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 rounded-lg transition shadow">
                                💳 Proses Pembayaran (POS)
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

</body>
</html>