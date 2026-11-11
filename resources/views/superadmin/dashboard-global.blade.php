<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Global - AMAHAY Admin</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex">

    <!-- Sidebar Super Admin (5 Fitur Utama) -->
    <aside class="w-64 bg-[#111827] border-r border-gray-800 flex flex-col justify-between hidden md:flex">
        <div>
            <!-- Brand / Logo -->
            <div class="h-16 flex items-center px-6 border-b border-gray-800 space-x-3">
                <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.9 6.9a2.12 2.12 0 1 1-3-3l6.9-6.9a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                    </svg>
                </div>
                <span class="text-base font-bold tracking-wider text-white">AMAHAY Admin</span>
            </div>

            <!-- Menu Sidebar -->
            <nav class="p-4 space-y-1.5 text-xs">
                <a href="/superadmin/dashboard" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-dashboard') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>📊</span>
                    <span>Dashboard Global</span>
                </a>
                <a href="/superadmin/tenant" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>🏢</span>
                    <span>Kelola Bengkel (Tenant)</span>
                </a>
                <a href="/superadmin/laporan" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-laporan') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>💵</span>
                    <span>Laporan Keuangan</span>
                </a>
                <a href="/superadmin/paket" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-paket') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>📦</span>
                    <span>Manajemen Paket</span>
                </a>
                <a href="/superadmin/pengaturan" class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-pengaturan') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>⚙️</span>
                    <span>Pengaturan Platform</span>
                </a>
            </nav>
        </div>

        <!-- Footer Sidebar & Tombol Logout -->
        <div class="p-4 border-t border-gray-800 space-y-3">
            <div class="text-[10px] text-gray-500">
                Sistem Multi-Tenant v1.0<br>Super Admin Access
            </div>
            <a href="/" class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 text-xs font-medium py-2 px-3 rounded-xl transition flex items-center justify-center space-x-2">
                <span>🚪</span>
                <span>Keluar (Logout)</span>
            </a>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 flex min-w-0 flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <header class="min-h-16 h-auto bg-[#111827] border-b border-gray-800 flex items-center justify-between gap-3 px-4 py-3 sm:px-8">
            <div class="min-w-0">
                <span class="block text-xs font-semibold text-gray-400 tracking-wide uppercase">Dashboard Ringkasan Global Platform</span>
                <time id="admin-clock" class="mt-1 block text-xs font-bold text-white" datetime="{{ now('Asia/Jakarta')->toIso8601String() }}">{{ now('Asia/Jakarta')->format('H:i:s') }} WIB</time>
                <time id="admin-date" class="block text-[10px] text-gray-400" datetime="{{ now('Asia/Jakarta')->toDateString() }}">{{ now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}</time>
            </div>
            <a href="{{ route('superadmin.profile.edit') }}" class="flex min-w-0 items-center gap-2 rounded-full border border-gray-800 bg-[#1f2937] px-3 py-1.5 text-xs transition hover:border-blue-500">
                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-600 font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <span class="min-w-0 text-left">
                    <span class="block truncate font-medium text-white">{{ auth()->user()->name }}</span>
                    <span class="block text-[10px] text-gray-400">Profil Super Admin</span>
                </span>
                <span class="sr-only">Ubah profil</span>
            </a>
        </header>

        <nav class="md:hidden flex items-center gap-2 overflow-x-auto border-b border-gray-800 bg-[#111827] px-4 py-3 text-xs text-gray-400">
            <a href="{{ route('superadmin.home') }}" class="shrink-0 rounded-lg bg-[#1f2937] px-3 py-2 text-white">Dashboard</a>
            <a href="{{ route('superadmin.tenant') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Tenant</a>
            <a href="{{ route('superadmin.laporan') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Laporan</a>
            <a href="{{ route('superadmin.paket') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Paket</a>
            <a href="{{ route('superadmin.pengaturan') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Pengaturan</a>
        </nav>

        <!-- Area Konten Utama -->
        <div class="p-4 sm:p-6 lg:p-8 space-y-6">
            
            <!-- Judul Halaman -->
            <div>
                <h1 class="text-lg font-bold text-white tracking-wide">Ringkasan Ekosistem SaaS AMAHAY</h1>
                <p class="text-xs text-gray-400 mt-0.5">Ringkasan dari data tenant yang aktif dan dapat dibaca pada periode {{ $monthLabel }}.</p>
            </div>

            <!-- 4 Kartu Metrik Utama -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div class="bg-[#111827] border border-gray-800 p-5 rounded-2xl shadow-lg space-y-2">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Tenant Terdaftar</p>
                    <h3 class="text-2xl font-bold text-white">{{ $tenantCount }} Bengkel</h3>
                    <p class="text-[11px] text-gray-400 font-medium">{{ $activeTenantCount }} tenant aktif</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-5 rounded-2xl shadow-lg space-y-2">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Omset Tenant Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-blue-400">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-blue-300 font-medium">Dari transaksi selesai di database tenant</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-5 rounded-2xl shadow-lg space-y-2">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Servis Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-white">{{ number_format($monthlyWorkOrderCount) }} Servis</h3>
                    <p class="text-[11px] text-gray-400 font-medium">{{ number_format($monthlyInvoiceCount) }} nota selesai · {{ $monthLabel }}</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-5 rounded-2xl shadow-lg space-y-2">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Pemantauan Server</p>
                    <h3 class="text-2xl font-bold text-yellow-400">Tidak diukur</h3>
                    <p class="text-[11px] text-gray-400 font-medium">Pemantauan uptime belum dikonfigurasi.</p>
                </div>
            </div>

            @if ($unavailableTenantNames !== [])
                <div class="rounded-xl border border-yellow-700/50 bg-yellow-950/30 px-4 py-3 text-xs text-yellow-200">
                    Data belum lengkap: database {{ count($unavailableTenantNames) }} tenant aktif tidak dapat dibaca.
                </div>
            @endif

            <!-- Bagian Grafik / Aktivitas Terbaru -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Aktivitas Tenant Terbaru -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <h3 class="text-sm font-semibold text-white">Aktivitas & Pendaftaran Terbaru</h3>
                    <div class="space-y-3 text-xs text-gray-300">
                        @forelse ($recentTenants as $tenant)
                            <div class="flex items-center justify-between gap-4 border-b border-gray-800/60 pb-3 last:border-0">
                                <div class="min-w-0">
                                    <p class="break-words font-bold text-white">{{ $tenant->getAttribute('tenant_name') }}</p>
                                    <p class="text-[10px] text-gray-400">
                                        Terdaftar dengan paket {{ ucfirst((string) $tenant->getAttribute('package')) }}
                                    </p>
                                </div>
                                <span class="shrink-0 text-[10px] text-gray-500">{{ $tenant->created_at?->diffForHumans() }}</span>
                            </div>
                        @empty
                            <p class="py-4 text-xs text-gray-400">Belum ada tenant yang terdaftar.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Ringkasan Ketersediaan Data -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <h3 class="text-sm font-semibold text-white">Ketersediaan Database Tenant</h3>
                    <div class="space-y-3 pt-1 text-xs">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-gray-400">Database tenant terbaca</span>
                            <span class="font-medium text-white">{{ $availableDatabaseCount }} / {{ $activeTenantCount }}</span>
                        </div>
                        <p class="text-gray-500">Angka ini menunjukkan keberhasilan pembacaan saat halaman dimuat, bukan metrik uptime.</p>
                        <p class="text-gray-500">Estimasi nilai paket aktif: Rp {{ number_format($estimatedMonthlySubscriptions, 0, ',', '.') }} / bulan. Bukan bukti pembayaran.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        const adminClock = document.getElementById('admin-clock');
        const adminDate = document.getElementById('admin-date');
        const jakartaTimeFormatter = new Intl.DateTimeFormat('en-GB', {
            timeZone: 'Asia/Jakarta',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hourCycle: 'h23',
        });
        const jakartaDateFormatter = new Intl.DateTimeFormat('id-ID', {
            timeZone: 'Asia/Jakarta',
            weekday: 'long',
            day: '2-digit',
            month: 'long',
            year: 'numeric',
        });

        function updateAdminClock() {
            const currentTime = new Date();
            adminClock.textContent = `${jakartaTimeFormatter.format(currentTime)} WIB`;
            adminClock.dateTime = currentTime.toISOString();
            adminDate.textContent = jakartaDateFormatter.format(currentTime);
            adminDate.dateTime = new Intl.DateTimeFormat('en-CA', {
                timeZone: 'Asia/Jakarta',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
            }).format(currentTime);
        }

        updateAdminClock();
        window.setInterval(updateAdminClock, 1000);
    </script>
</body>
</html>