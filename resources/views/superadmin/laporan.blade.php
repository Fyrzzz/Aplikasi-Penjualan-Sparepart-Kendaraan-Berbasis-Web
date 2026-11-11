<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan Platform - AMAHAY Admin</title>
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

        <!-- Footer Sidebar & Logout -->
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
        <header class="min-h-16 h-auto bg-[#111827] border-b border-gray-800 flex flex-col justify-between gap-3 px-4 py-3 lg:flex-row lg:items-center lg:px-8">
            <span class="text-xs font-semibold text-gray-400 tracking-wide uppercase">Laporan Konsolidasi Finansial Platform</span>
            <div class="flex items-center space-x-2 bg-[#1f2937] px-3 py-1.5 rounded-full border border-gray-800 text-xs">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                <span class="text-white font-medium">Admin Line (Super Admin)</span>
            </div>
        </header>

        <nav aria-label="Navigasi Super Admin" class="md:hidden flex items-center gap-2 overflow-x-auto border-b border-gray-800 bg-[#111827] px-4 py-3 text-xs text-gray-400">
            <a href="{{ route('superadmin.home') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Dashboard</a>
            <a href="{{ route('superadmin.tenant') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Tenant</a>
            <a href="{{ route('superadmin.laporan') }}" class="shrink-0 rounded-lg bg-[#1f2937] px-3 py-2 text-white">Laporan</a>
            <a href="{{ route('superadmin.paket') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Paket</a>
            <a href="{{ route('superadmin.pengaturan') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Pengaturan</a>
        </nav>

        <div class="space-y-6 p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h1 class="text-lg font-bold text-white tracking-wide">Laporan Keuangan & Aktivitas Tenant</h1>
                    <p class="mt-1 text-xs text-gray-400">Omset hanya menghitung transaksi selesai pada tenant aktif yang databasenya dapat dibaca.</p>
                </div>
                <div class="rounded-xl border border-gray-800 bg-[#111827] px-4 py-2 text-xs">
                    <span class="text-gray-400">Periode:</span>
                    <span class="ml-2 rounded-lg border border-gray-700 bg-[#1f2937] px-3 py-1 font-bold text-white">{{ $monthLabel }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                <div class="space-y-2 rounded-2xl border border-gray-800 bg-[#111827] p-5 shadow-lg">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Omset Tenant Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-white">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-gray-400">{{ number_format($monthlyInvoiceCount) }} nota selesai</p>
                </div>
                <div class="space-y-2 rounded-2xl border border-gray-800 bg-[#111827] p-5 shadow-lg">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Estimasi Nilai Paket Aktif</p>
                    <h3 class="text-2xl font-bold text-blue-400">Rp {{ number_format($estimatedMonthlySubscriptions, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-gray-400">Perkiraan dari harga paket, bukan pembayaran yang tercatat.</p>
                </div>
                <div class="space-y-2 rounded-2xl border border-gray-800 bg-[#111827] p-5 shadow-lg">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Servis Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-white">{{ number_format($monthlyWorkOrderCount) }} Servis</h3>
                    <p class="text-[11px] text-gray-400">Database tenant terbaca {{ $availableDatabaseCount }} dari {{ $activeTenantCount }}</p>
                </div>
            </div>

            @if ($unavailableTenantNames !== [])
                <div class="rounded-xl border border-yellow-700/50 bg-yellow-950/30 px-4 py-3 text-xs text-yellow-200">
                    Laporan belum lengkap. Database tidak dapat dibaca:
                    {{ implode(', ', $unavailableTenantNames) }}
                </div>
            @endif

            <section class="space-y-4 rounded-2xl border border-gray-800 bg-[#111827] p-5 shadow-lg sm:p-6">
                <div>
                    <h2 class="text-sm font-semibold text-white">Rincian Omset per Bengkel</h2>
                    <p class="mt-1 text-xs text-gray-400">Nilai berasal dari tabel penjualan tenant; angka kontrak tidak tersedia sebagai pembayaran.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[720px] text-left text-xs text-gray-300">
                        <thead class="border-b border-gray-800 text-[10px] uppercase tracking-wider text-gray-400">
                            <tr>
                                <th class="pb-3">Bengkel</th>
                                <th class="pb-3">Paket</th>
                                <th class="pb-3 text-right">Servis</th>
                                <th class="pb-3 text-right">Nota Selesai</th>
                                <th class="pb-3 text-right">Omset Bulan Ini</th>
                                <th class="pb-3">SPK Terbaru</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/60">
                            @forelse ($tenantReportRows as $row)
                                <tr>
                                    <td class="py-3 font-semibold text-white">{{ $row['tenant']->getAttribute('tenant_name') }}</td>
                                    <td class="py-3">{{ ucfirst((string) $row['tenant']->getAttribute('package')) }}</td>
                                    <td class="py-3 text-right">{{ number_format($row['work_order_count']) }}</td>
                                    <td class="py-3 text-right">{{ number_format($row['invoice_count']) }}</td>
                                    <td class="py-3 text-right font-mono">Rp {{ number_format($row['revenue'], 0, ',', '.') }}</td>
                                    <td class="py-3">
                                        @forelse ($row['recent_work_orders'] as $workOrderNumber)
                                            <span class="block font-mono text-[10px]">{{ $workOrderNumber }}</span>
                                        @empty
                                            <span class="text-gray-500">Belum ada SPK</span>
                                        @endforelse
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-400">Belum ada data tenant aktif yang dapat dilaporkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

</body>
</html>