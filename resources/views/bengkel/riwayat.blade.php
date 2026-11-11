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
        <header
            class="border-b border-gray-800/80 bg-[#0b0f19]/80 backdrop-blur sticky top-0 z-50 flex items-center justify-between gap-2 px-4 py-3 sm:px-6 sm:py-4">
            <div class="flex min-w-0 items-center gap-2 sm:gap-4">
                <a href="{{ route('user.menu') }}"
                    class="text-xs bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-lg text-gray-400 hover:text-white transition">
                    ← Kembali ke Menu
                </a>
                <span class="text-sm font-bold text-white hidden md:inline">Riwayat Servis & Transaksi</span>
            </div>
            <!-- User Profile dengan Dropdown Klik -->
            <div class="relative">
                <button onclick="toggleDropdown()"
                    class="flex max-w-[45vw] shrink-0 items-center space-x-2 bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-full text-xs cursor-pointer hover:border-gray-700 transition focus:outline-none">
                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center font-bold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <span class="max-w-[25vw] truncate text-gray-200 font-medium">{{ auth()->user()->name }}</span>
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div id="profile-dropdown"
                    class="absolute right-0 mt-2 w-48 bg-[#111827] border border-gray-800 rounded-2xl shadow-xl py-2 hidden z-50 text-xs">
                    <div class="px-4 py-2 border-b border-gray-800/80">
                        <p class="font-bold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-gray-400">{{ auth()->user()->phone ?: auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('user.profil.edit') }}" class="block px-4 py-2 text-gray-300 hover:bg-[#1f2937] hover:text-white transition">⚙️ Edit Profil & Motor</a>
                    <a href="{{ route('user.riwayat') }}"
                        class="block px-4 py-2 text-gray-300 hover:bg-[#1f2937] hover:text-white transition">📜 Riwayat
                        Servis Saya</a>
                    <div class="border-t border-gray-800/80 my-1"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-red-400 hover:bg-red-500/10 transition font-medium">🚪 Keluar (Logout)</button>
                    </form>
                </div>
            </div>
        </header>

        <nav aria-label="Navigasi konsumen" class="md:hidden flex items-center gap-2 overflow-x-auto border-b border-gray-800/80 px-4 py-2 text-xs text-gray-400">
            <a href="{{ route('user.menu') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#161e2e] hover:text-white">Cari Bengkel</a>
            <a href="{{ route('user.cek.servis') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#161e2e] hover:text-white">Cek Status</a>
            <a href="{{ route('user.promo') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#161e2e] hover:text-white">Promo</a>
            <a href="{{ route('user.riwayat') }}" class="shrink-0 rounded-lg bg-[#161e2e] px-3 py-2 text-blue-400">Riwayat</a>
        </nav>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto px-4 py-8 sm:px-6 sm:py-10">

            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-white mb-2">Riwayat Perawatan Kendaraan</h1>
                <p class="text-xs text-gray-400">Daftar seluruh catatan servis, penggantian sparepart, dan transaksi
                    yang pernah Anda lakukan.</p>
            </div>

            <!-- List Riwayat -->
            <div class="space-y-4">
                @forelse ($workOrders as $workOrder)
                    @php
                        $statusStyle = match ($workOrder->status) {
                            'completed' => 'bg-green-500/10 text-green-400 border-green-500/20',
                            'in_progress' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                            'waiting' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                            default => 'bg-gray-500/10 text-gray-400 border-gray-500/20',
                        };
                    @endphp
                    <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="text-[10px] {{ $statusStyle }} font-semibold px-2.5 py-0.5 rounded-md border">{{ $workOrder->status_label }}</span>
                                <span class="text-[10px] text-gray-400">{{ \Illuminate\Support\Carbon::parse($workOrder->created_at)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y • H:i') }} WIB</span>
                            </div>
                            @if ($workOrder->entry_type === 'sale')
                                <h3 class="text-sm font-bold text-white">Transaksi Sparepart / Jasa</h3>
                            @else
                                <h3 class="text-sm font-bold text-white">
                                    {{ $workOrder->vehicle_brand }} {{ $workOrder->vehicle_model }} {{ $workOrder->vehicle_year }}
                                    <span class="text-xs font-normal text-gray-400">({{ $workOrder->license_plate }})</span>
                                </h3>
                            @endif
                            <p class="text-xs text-gray-400 mt-0.5">{{ $workOrder->tenant_name }} — {{ $workOrder->service_summary ?: $workOrder->complaint ?: 'Servis kendaraan' }}</p>
                        </div>
                        <div class="text-left md:text-right w-full md:w-auto flex md:flex-col justify-between items-center md:items-end border-t md:border-t-0 pt-3 md:pt-0 border-gray-800">
                            <span class="text-xs font-bold text-blue-400">Rp {{ number_format((float) $workOrder->total, 0, ',', '.') }}</span>
                            <span class="mt-2 text-[10px] text-gray-400">{{ $workOrder->work_order_number }}</span>
                        </div>
                    </div>
                @empty
                    <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-8 text-center shadow-lg">
                        <p class="text-sm font-medium text-white">Belum ada riwayat servis untuk akun Anda.</p>
                        <p class="text-xs text-gray-400 mt-2">Riwayat akan muncul setelah bengkel menghubungkan data servis dengan akun atau kontak Anda.</p>
                    </div>
                @endforelse
            </div>

        </main>
    </div>

    <!-- Footer -->
    <footer
        class="border-t border-gray-800/80 py-4 px-6 text-center text-[11px] text-gray-500 flex justify-between max-w-4xl mx-auto w-full mt-12">
        <span>© AMAHAY 2026</span>
        <span>SaaS Manajemen Bengkel & Konsumen Portal</span>
    </footer>
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