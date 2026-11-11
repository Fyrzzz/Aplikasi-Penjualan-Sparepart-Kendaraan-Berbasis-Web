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
        <header class="border-b border-gray-800/80 bg-[#0b0f19]/80 backdrop-blur sticky top-0 z-50 px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 sm:gap-8 min-w-0">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/30">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.9 6.9a2.12 2.12 0 1 1-3-3l6.9-6.9a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                        </svg>
                    </div>
                    <span class="text-base sm:text-lg font-bold tracking-wider text-white">AMAHAY</span>
                </div>
                <!-- Menu Navigasi -->
                <nav class="hidden md:flex items-center space-x-6 text-xs text-gray-400">
                    <a href="#" class="text-blue-400 font-medium">Cari Bengkel</a>
                    <a href="{{ route('user.cek.servis') }}" class="hover:text-white transition">Cek Status Servis</a>
                    <a href="{{ route('user.promo') }}" class="hover:text-white transition">Promo</a>
                    <a href="{{ route('user.riwayat') }}" class="hover:text-white transition">Riwayat</a>
                </nav>
            </div>

            <!-- User Profile dengan Dropdown Klik -->
            <div class="relative">
                <!-- Tombol Profile -->
                <button onclick="toggleDropdown()" 
                    class="flex items-center space-x-2 bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-full text-xs cursor-pointer hover:border-gray-700 transition focus:outline-none">
                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <span class="text-gray-200 font-medium max-w-[25vw] sm:max-w-none truncate">{{ auth()->user()->name }}</span>
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Kotak Menu Dropdown (Awalnya tersembunyi dengan class 'hidden') -->
                <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-[#111827] border border-gray-800 rounded-2xl shadow-xl py-2 hidden z-50 text-xs">
                    <div class="px-4 py-2 border-b border-gray-800/80">
                        <p class="font-bold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-gray-400">{{ auth()->user()->phone ?: auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('user.profil.edit') }}" class="block px-4 py-2 text-gray-300 hover:bg-[#1f2937] hover:text-white transition">⚙️ Edit Profil & Motor</a>
                    <a href="{{ route('user.riwayat') }}" class="block px-4 py-2 text-gray-300 hover:bg-[#1f2937] hover:text-white transition">📜 Riwayat Servis Saya</a>
                    <div class="border-t border-gray-800/80 my-1"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-red-400 hover:bg-red-500/10 transition font-medium">🚪 Keluar (Logout)</button>
                    </form>
                </div>
            </div>
        </header>

        <nav class="md:hidden flex items-center gap-2 overflow-x-auto border-b border-gray-800/80 px-4 py-2 text-xs text-gray-400">
            <a href="{{ route('user.menu') }}" class="shrink-0 rounded-lg bg-[#161e2e] px-3 py-2 text-blue-400">Cari Bengkel</a>
            <a href="{{ route('user.cek.servis') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#161e2e] hover:text-white">Cek Status Servis</a>
            <a href="{{ route('user.promo') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#161e2e] hover:text-white">Promo</a>
            <a href="{{ route('user.riwayat') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#161e2e] hover:text-white">Riwayat</a>
        </nav>

        <!-- Hero Search Section -->
        <section class="max-w-5xl mx-auto px-4 sm:px-6 py-10 sm:py-16 text-center">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Temukan Bengkel Terbaik di Sekitar Anda</h1>
            <p class="text-xs text-gray-400 mb-8">Temukan servis panggilan, lokasi bengkel, paket promo, dan sparepart motor</p>
            
            <!-- Search Bar -->
            <form action="{{ route('user.menu') }}" method="GET" class="max-w-xl mx-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-2 bg-[#161e2e] border border-gray-700/80 rounded-2xl p-1.5 shadow-xl">
                <input type="search" name="search" value="{{ $search }}" placeholder="Cari nama bengkel atau domain..."
                    aria-label="Cari nama bengkel atau domain"
                    class="w-full min-w-0 bg-transparent px-4 py-2.5 text-xs text-white placeholder-gray-500 focus:outline-none">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-xs font-medium transition shadow-md shadow-blue-600/30">
                    Cari
                </button>
            </form>

            <!-- Quick Filter Badges -->
            <div class="flex flex-wrap items-center justify-center gap-3 mt-6 text-xs text-gray-400">
                <button class="bg-[#161e2e] border border-gray-800 px-3.5 py-1.5 rounded-lg hover:border-blue-500 transition">🔧 Terdekat</button>
                <button class="bg-[#161e2e] border border-gray-800 px-3.5 py-1.5 rounded-lg hover:border-blue-500 transition">⚡ Ganti Oli</button>
                <button class="bg-[#161e2e] border border-gray-800 px-3.5 py-1.5 rounded-lg hover:border-blue-500 transition">🛠️ Servis Besar</button>
                <button class="bg-[#161e2e] border border-gray-800 px-3.5 py-1.5 rounded-lg hover:border-blue-500 transition">🛵 Booking & Antrean</button>
                <button class="bg-[#161e2e] border border-gray-800 px-3.5 py-1.5 rounded-lg hover:border-blue-500 transition">📦 Stok Suku Cadang</button>
            </div>

            <div class="mt-8 rounded-2xl border border-blue-500/20 bg-[#111827] p-5 text-left shadow-lg sm:flex sm:items-center sm:justify-between sm:gap-6">
                <div>
                    <h2 class="text-sm font-bold text-white">Punya bengkel?</h2>
                    <p class="mt-1 text-xs text-gray-400">
                        @if (auth()->user()->role === 'Owner' && $accountTenant?->isActive())
                            Akun utama Anda sudah terhubung dengan tenant bengkel.
                        @elseif (auth()->user()->role === 'Owner')
                            Akses tenant bengkel Anda sedang dinonaktifkan atau diblokir. Hubungi administrator platform.
                        @else
                            Login ke akun tenant atau daftarkan bengkel menggunakan akun utama Anda.
                        @endif
                    </p>
                </div>
                <div class="mt-4 flex w-full flex-col gap-2 sm:mt-0 sm:w-auto sm:flex-row">
                    @if (auth()->user()->role === 'Owner' && $accountTenant?->isActive())
                        <a href="{{ route('owner.home') }}" class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-xs font-medium text-white transition hover:bg-blue-700 sm:w-auto">
                            Masuk ke Dashboard Tenant
                        </a>
                    @elseif (auth()->user()->role === 'Owner')
                        <span class="inline-flex w-full items-center justify-center rounded-xl border border-red-500/30 px-5 py-2.5 text-center text-xs font-medium text-red-300 sm:w-auto">
                            Tenant tidak aktif
                        </span>
                    @else
                        <a href="{{ route('tenant.login') }}" class="inline-flex w-full items-center justify-center rounded-xl border border-gray-700 px-5 py-2.5 text-xs font-medium text-gray-200 transition hover:border-blue-500 hover:text-white sm:w-auto">
                            Login Tenant
                        </a>
                        <a href="{{ route('tenant.create') }}" class="inline-flex w-full items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-xs font-medium text-white transition hover:bg-blue-700 sm:w-auto">
                            Daftarkan Bengkel
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- Rekomendasi Terdekat -->
        <section class="max-w-6xl mx-auto px-4 sm:px-6 pb-12 sm:pb-20">
            <div class="mb-4 flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-sm font-bold text-white">Bengkel Terdaftar</h2>
                <p class="text-xs text-gray-400">{{ $tenants->total() }} bengkel</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @forelse ($tenants as $tenant)
                    @php
                        $tenantPhone = $tenant->getAttribute('phone');
                        $tenantDomain = $tenant->domains->first()?->domain;
                    @endphp
                    <article class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-lg flex flex-col justify-between gap-5">
                        <div>
                            <div class="text-[10px] text-gray-500 mb-2">
                                Paket {{ ucfirst((string) $tenant->getAttribute('package')) }}
                            </div>
                            <h3 class="text-sm font-bold text-white mb-3 break-words">
                                {{ $tenant->getAttribute('tenant_name') }}
                            </h3>
                            <div class="space-y-2 text-xs text-gray-400">
                                @if ($tenantDomain)
                                    <p class="break-all">🌐 {{ $tenantDomain }}</p>
                                @endif
                                @if ($tenantPhone)
                                    <p>📞 {{ $tenantPhone }}</p>
                                @endif
                                @if ($tenant->owner)
                                    <p>👤 {{ $tenant->owner->name }}</p>
                                @endif
                            </div>
                        </div>
                        @if ($tenantPhone)
                            <a href="tel:{{ $tenantPhone }}" class="block w-full text-center bg-[#1f2937] hover:bg-blue-600 hover:text-white text-gray-300 font-medium py-2.5 rounded-xl text-xs transition duration-200 border border-gray-700/50">
                                Hubungi Bengkel
                            </a>
                        @endif
                    </article>
                @empty
                    <div class="sm:col-span-2 lg:col-span-3 rounded-2xl border border-dashed border-gray-700 bg-[#111827] px-5 py-10 text-center">
                        <p class="text-sm font-semibold text-white">
                            {{ $search ? 'Bengkel tidak ditemukan.' : 'Belum ada bengkel yang terdaftar.' }}
                        </p>
                        <p class="mt-2 text-xs text-gray-400">
                            {{ $search ? 'Coba kata kunci lain.' : 'Bengkel baru akan muncul di sini setelah mendaftar.' }}
                        </p>
                        @if (! $search)
                            <a href="{{ route('tenant.create') }}" class="mt-5 inline-flex rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-medium text-white transition hover:bg-blue-700">
                                Daftarkan Bengkel
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            @if ($tenants->hasPages())
                <div class="mt-6">{{ $tenants->links() }}</div>
            @endif
        </section>
    </div>

    <!-- Footer -->
    <footer class="border-t border-gray-800/80 py-4 px-4 sm:px-6 text-center text-[11px] text-gray-500 flex flex-col sm:flex-row gap-2 sm:justify-between max-w-6xl mx-auto w-full">
        <span>© AMAHAY 2026</span>
        <span>SaaS Manajemen Bengkel & Konsumen Portal</span>
    </footer>

    <!-- Script untuk Toggle Dropdown Klik -->
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.classList.toggle('hidden');
        }

        // Menutup dropdown jika pengguna mengklik di luar area menu
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profile-dropdown');
            const button = dropdown.previousElementSibling;
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

</body>
</html>