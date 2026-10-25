<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir / POS - AMAHAY</title>
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

            <!-- Menu Sidebar (Sudah diarahkan ke /test-mekanik) -->
            <nav class="p-4 space-y-1.5 text-xs">
                <a href="/test-dashboard" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="/test-antrean" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>🛠️</span>
                    <span>Antrean Service</span>
                </a>
                <a href="/test-kasir" class="flex items-center space-x-3 px-4 py-2.5 bg-[#1f2937] text-white rounded-xl font-medium shadow-sm border border-gray-700/50">
                    <span>💰</span>
                    <span>Kasir / POS</span>
                </a>
                <a href="/test-stok" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>📦</span>
                    <span>Stok Sparepart</span>
                </a>
                <a href="/test-mekanik" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>👥</span>
                    <span>Pelanggan & Mekanik</span>
                </a>
                <a href="/test-pengingat" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
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

    <!-- Konten Utama Kasir / POS -->
    <main class="flex-1 flex flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-[#111827] border-b border-gray-800 flex items-center justify-between px-8">
            <h1 class="text-xs font-bold text-white tracking-wide uppercase">Kasir / POS</h1>
            <div class="flex items-center space-x-4 w-1/2">
                <input type="text" placeholder="Cari nama, kode sparepart, skuter, atau jasa servis..." class="w-full bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-1.5 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                <span class="text-xs bg-green-500/20 text-green-400 px-3 py-1.5 rounded-xl border border-green-500/30 font-bold whitespace-nowrap">Remote</span>
            </div>
        </header>

        <!-- Area Transaksi Layout 2 Kolom -->
        <div class="p-8 grid grid-cols-1 lg:grid-cols-3 gap-6 flex-1">
            
            <!-- Kolom Kiri: Katalog Produk -->
            <div class="lg:col-span-2 space-y-5 flex flex-col">
                <div class="flex items-center space-x-2 text-xs overflow-x-auto pb-1">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-xl font-medium shadow">Semua Parts</button>
                    <button class="bg-[#111827] hover:bg-[#1f2937] text-gray-300 px-4 py-2 rounded-xl font-medium border border-gray-800 transition">Oli & Pelumas</button>
                    <button class="bg-[#111827] hover:bg-[#1f2937] text-gray-300 px-4 py-2 rounded-xl font-medium border border-gray-800 transition">Sparepart Mesin</button>
                    <button class="bg-[#111827] hover:bg-[#1f2937] text-gray-300 px-4 py-2 rounded-xl font-medium border border-gray-800 transition">Kampas & Rem</button>
                    <button class="bg-[#111827] hover:bg-[#1f2937] text-gray-300 px-4 py-2 rounded-xl font-medium border border-gray-800 transition">Jasa Servis</button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow flex flex-col justify-between hover:border-blue-500 transition cursor-pointer">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-white">Oli MPX2 Matic 0.8L</p>
                                <p class="text-[10px] text-gray-400 font-mono">SKU-OLI-001</p>
                            </div>
                            <span class="text-[10px] bg-green-500/20 text-green-400 px-2 py-0.5 rounded font-medium">Stok: 24</span>
                        </div>
                        <div class="flex justify-between items-end mt-4">
                            <span class="text-sm font-bold text-green-400">Rp 55.000</span>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white w-7 h-7 rounded-xl flex items-center justify-center font-bold text-sm shadow">+</button>
                        </div>
                    </div>

                    <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow flex flex-col justify-between hover:border-blue-500 transition cursor-pointer">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-white">OE Matic Scooter LE AT 10W-30</p>
                                <p class="text-[10px] text-gray-400 font-mono">Synthetics Tech 2026</p>
                            </div>
                            <span class="text-[10px] bg-green-500/20 text-green-400 px-2 py-0.5 rounded font-medium">Stok: 12</span>
                        </div>
                        <div class="flex justify-between items-end mt-4">
                            <span class="text-sm font-bold text-green-400">Rp 65.000</span>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white w-7 h-7 rounded-xl flex items-center justify-center font-bold text-sm shadow">+</button>
                        </div>
                    </div>

                    <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow flex flex-col justify-between hover:border-blue-500 transition cursor-pointer">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-white">Jasa Servis Ringan / Tune Up</p>
                                <p class="text-[10px] text-gray-400 font-mono">Tuneup + Pembersihan CVT</p>
                            </div>
                            <span class="text-[10px] bg-purple-500/20 text-purple-400 px-2 py-0.5 rounded font-medium">Jasa</span>
                        </div>
                        <div class="flex justify-between items-end mt-4">
                            <span class="text-sm font-bold text-green-400">Rp 45.000</span>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white w-7 h-7 rounded-xl flex items-center justify-center font-bold text-sm shadow">+</button>
                        </div>
                    </div>

                    <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow flex flex-col justify-between hover:border-blue-500 transition cursor-pointer">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-white">Kampas Rem Depan Vario</p>
                                <p class="text-[10px] text-gray-400 font-mono">Original Honda</p>
                            </div>
                            <span class="text-[10px] bg-yellow-500/20 text-yellow-400 px-2 py-0.5 rounded font-medium">Stok: 3</span>
                        </div>
                        <div class="flex justify-between items-end mt-4">
                            <span class="text-sm font-bold text-green-400">Rp 45.000</span>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white w-7 h-7 rounded-xl flex items-center justify-center font-bold text-sm shadow">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Keranjang & Pembayaran -->
            <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center border-b border-gray-800 pb-3 mb-4">
                        <div>
                            <span class="text-[9px] text-gray-500 block uppercase font-mono">ORDER NO: POS-2026-009</span>
                            <p class="text-xs font-bold text-white mt-0.5">Pak Ahmad • B 1234 XYZ</p>
                            <p class="text-[10px] text-gray-400">Mekanik: Agus Setiawan</p>
                        </div>
                        <span class="bg-blue-500/20 text-blue-400 text-[10px] px-2 py-1 rounded font-bold">Pelanggan Aktif</span>
                    </div>

                    <div class="space-y-3 text-xs mb-6">
                        <div class="flex justify-between items-center border-b border-gray-800 pb-2.5">
                            <div>
                                <p class="font-bold text-white">Oli MPX2 Matik 0.8L</p>
                                <p class="text-gray-400 font-mono text-[10px]">Rp 55.000</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="bg-gray-800 text-gray-300 w-5 h-5 rounded flex items-center justify-center">-</button>
                                <span class="font-bold text-white">1</span>
                                <button class="bg-gray-800 text-gray-300 w-5 h-5 rounded flex items-center justify-center">+</button>
                            </div>
                        </div>

                        <div class="flex justify-between items-center border-b border-gray-800 pb-2.5">
                            <div>
                                <p class="font-bold text-white">Jasa Servis Ringan / Tune Up</p>
                                <p class="text-gray-400 font-mono text-[10px]">Rp 45.000</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button class="bg-gray-800 text-gray-300 w-5 h-5 rounded flex items-center justify-center">-</button>
                                <span class="font-bold text-white">1</span>
                                <button class="bg-gray-800 text-gray-300 w-5 h-5 rounded flex items-center justify-center">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-gray-800">
                    <div class="space-y-1.5 text-xs text-gray-300">
                        <div class="flex justify-between">
                            <span>Subtotal Parts:</span>
                            <span class="font-mono text-white">Rp 55.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Diskon / Pelanggan:</span>
                            <span class="font-mono text-green-400">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Jasa Servis (1):</span>
                            <span class="font-mono text-white">Rp 45.000</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-gray-800 text-sm font-bold text-white">
                            <span>Total Bayar:</span>
                            <span class="text-green-400 text-base font-mono">Rp 95.000</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <button class="bg-blue-600 text-white text-[11px] font-bold py-2 rounded-xl shadow">Tunai / Cash</button>
                        <button class="bg-[#1f2937] hover:bg-gray-700 text-gray-300 text-[11px] font-medium py-2 rounded-xl border border-gray-700">QRIS</button>
                        <button class="bg-[#1f2937] hover:bg-gray-700 text-gray-300 text-[11px] font-medium py-2 rounded-xl border border-gray-700">Transfer / EDC</button>
                    </div>

                    <button class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-green-600/30 transition text-xs flex items-center justify-center space-x-2">
                        <span>🖨️ Selesaikan Transaksi & Cetak</span>
                    </button>
                </div>
            </div>

        </div>
    </main>

</body>
</html>