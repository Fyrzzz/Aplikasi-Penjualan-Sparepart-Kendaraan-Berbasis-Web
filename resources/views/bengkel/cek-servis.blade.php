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
        <header
            class="border-b border-gray-800/80 bg-[#0b0f19]/80 backdrop-blur sticky top-0 z-50 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('user.menu') }}"
                    class="text-xs bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-lg text-gray-400 hover:text-white transition">
                    ← Kembali ke Menu
                </a>
                <span class="text-sm font-bold text-white hidden md:inline">Status Pengerjaan Servis</span>
            </div>

            <!-- User Profile dengan Dropdown Klik -->
            <div class="relative">
                <!-- Tombol Profile -->
                <button onclick="toggleDropdown()"
                    class="flex items-center space-x-2 bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-full text-xs cursor-pointer hover:border-gray-700 transition focus:outline-none">
                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center font-bold text-white">
                        P</div>
                    <span class="text-gray-200 font-medium">Panda</span>
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Kotak Menu Dropdown -->
                <div id="profile-dropdown"
                    class="absolute right-0 mt-2 w-48 bg-[#111827] border border-gray-800 rounded-2xl shadow-xl py-2 hidden z-50 text-xs">
                    <div class="px-4 py-2 border-b border-gray-800/80">
                        <p class="font-bold text-white">Panda</p>
                        <p class="text-[10px] text-gray-400">panda@gmail.com</p>
                    </div>
                    <a href="{{ route('user.profil.edit') }}"
                        class="block px-4 py-2 text-gray-300 hover:bg-[#1f2937] hover:text-white transition">⚙️ Edit
                        Profil & Motor</a>
                    <a href="{{ route('user.riwayat') }}"
                        class="block px-4 py-2 text-gray-300 hover:bg-[#1f2937] hover:text-white transition">📜 Riwayat
                        Servis Saya</a>
                    <div class="border-t border-gray-800/80 my-1"></div>
                    <a href="{{ route('home') }}"
                        class="block px-4 py-2 text-red-400 hover:bg-red-500/10 transition font-medium">🚪 Keluar
                        (Logout)</a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto px-6 py-10">

            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-white mb-2">Lacak Status Servis Motor Anda</h1>
                <p class="text-xs text-gray-400">Masukkan nomor plat nomor atau kode booking untuk melihat progres
                    real-time dari bengkel.</p>
            </div>

            <!-- Search / Tracking Box -->
            <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-6 shadow-lg mb-8">
                <div class="flex flex-col md:flex-row gap-3">
                    <input type="text" placeholder="Masukkan Plat Nomor (Contoh: L 1234 AB) atau Kode Booking..."
                        class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-4 py-3 text-xs text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-xs font-medium transition shadow-md shadow-blue-600/30 whitespace-nowrap">
                        Lacak Status 🔍
                    </button>
                </div>
            </div>

            <!-- Hasil Tracking (Simulasi Status Aktif) -->
            <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-6 shadow-lg space-y-8">

                <!-- Info Header Kendaraan -->
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-800 pb-5 gap-3">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span
                                class="text-[10px] bg-blue-500/10 text-blue-400 font-semibold px-2.5 py-0.5 rounded-md border border-blue-500/20">#AMH-88921</span>
                            <span class="text-[10px] bg-gray-800 text-gray-300 px-2 py-0.5 rounded">Bengkel Maju
                                Jaya</span>
                        </div>
                        <h2 class="text-lg font-bold text-white">Honda BeAT 2022 <span
                                class="text-xs font-normal text-gray-400">(L 4567 XY)</span></h2>
                        <p class="text-xs text-gray-400 mt-0.5">Paket: Servis Ringan + Ganti Oli MPX2</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <span
                            class="text-xs bg-yellow-500/10 text-yellow-400 font-semibold px-3 py-1.5 rounded-xl border border-yellow-500/20 inline-block">
                            ⚡ Sedang Dikerjakan (60%)
                        </span>
                        <p class="text-[11px] text-gray-400 mt-1">Estimasi Selesai: <span
                                class="text-white font-medium">10:15 WIB</span></p>
                    </div>
                </div>

                <!-- Step Progress Bar Visual -->
                <div>
                    <h3 class="text-xs font-bold text-gray-400 mb-4 uppercase tracking-wider">Tahapan Pengerjaan</h3>
                    <div class="grid grid-cols-3 gap-2 text-center text-xs">
                        <!-- Step 1 (Selesai) -->
                        <div class="bg-[#161e2e] border border-blue-500/50 p-3 rounded-xl flex flex-col items-center">
                            <div
                                class="w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-[10px] mb-1">
                                ✓</div>
                            <span class="text-white font-medium text-[11px]">Terdaftar</span>
                            <span class="text-[9px] text-gray-400 mt-0.5">08:30 WIB</span>
                        </div>
                        <!-- Step 2 (Aktif) -->
                        <div
                            class="bg-blue-600/10 border border-blue-500 p-3 rounded-xl flex flex-col items-center shadow-lg shadow-blue-500/10">
                            <div
                                class="w-6 h-6 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-[10px] mb-1 animate-pulse">
                                2</div>
                            <span class="text-blue-400 font-bold text-[11px]">Servis Mesin</span>
                            <span class="text-[9px] text-gray-400 mt-0.5">Sedang Proses</span>
                        </div>
                        <!-- Step 3 (Pending) -->
                        <div
                            class="bg-[#161e2e] border border-gray-800 p-3 rounded-xl flex flex-col items-center opacity-50">
                            <div
                                class="w-6 h-6 rounded-full bg-gray-700 text-gray-400 flex items-center justify-center font-bold text-[10px] mb-1">
                                3</div>
                            <span class="text-gray-400 text-[11px]">Selesai & Kasir</span>
                            <span class="text-[9px] text-gray-500 mt-0.5">Menunggu</span>
                        </div>
                    </div>
                </div>

                <!-- Info Mekanik & Rincian Pekerjaan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kartu Mekanik -->
                    <div class="bg-[#161e2e] border border-gray-800 rounded-xl p-4 flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gray-800 border border-gray-700 rounded-full flex items-center justify-center text-base">
                            👨‍🔧</div>
                        <div>
                            <p class="text-[10px] text-gray-400">Mekanik Penanggung Jawab</p>
                            <p class="text-xs font-bold text-white">Budi Santoso</p>
                            <p class="text-[10px] text-green-400">Spesialis Matik Honda</p>
                        </div>
                    </div>

                    <!-- Ringkasan Biaya -->
                    <div class="bg-[#161e2e] border border-gray-800 rounded-xl p-4 flex justify-between items-center">
                        <div>
                            <p class="text-[10px] text-gray-400">Total Biaya Servis</p>
                            <p class="text-sm font-bold text-blue-400">Rp 75.000</p>
                        </div>
                        <span class="text-[10px] bg-yellow-500/20 text-yellow-400 px-2.5 py-1 rounded font-medium">Belum
                            Dibayar</span>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- Footer -->
    <footer
        class="border-t border-gray-800/80 py-4 px-6 text-center text-[11px] text-gray-500 flex justify-between max-w-4xl mx-auto w-full mt-10">
        <span>© AMAHAY 2026</span>
        <span>SaaS Manajemen Bengkel & Konsumen Portal</span>
    </footer>

    <!-- Script untuk Toggle Dropdown Klik -->
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.classList.toggle('hidden');
        }

        window.addEventListener('click', function (e) {
            const dropdown = document.getElementById('profile-dropdown');
            const button = dropdown.previousElementSibling;
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

</body>

</html>