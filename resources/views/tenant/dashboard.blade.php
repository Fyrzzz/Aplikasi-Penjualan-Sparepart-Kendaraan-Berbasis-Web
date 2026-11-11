<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Tenant - AMAHAY</title>
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
                <a href="/owner/dashboard" class="flex items-center space-x-3 px-4 py-2.5 bg-[#1f2937] text-white rounded-xl font-medium shadow-sm border border-gray-700/50">
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
                <a href="/owner/pengingat" class="flex items-center space-x-3 px-4 py-2.5 text-gray-400 hover:bg-[#1f2937] hover:text-white rounded-xl transition">
                    <span>🔔</span>
                    <span>Pengingat Service</span>
                </a>
            </nav>
        </div>

        <!-- Profil Owner / Mekanik di Sidebar Bawah & Tombol Logout -->
        <div class="p-4 border-t border-gray-800 space-y-3">
            <div class="flex items-center space-x-3 bg-[#161e2e] p-2.5 rounded-xl border border-gray-800">
                <div class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold flex items-center justify-center text-xs">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="text-xs">
                    <p class="font-bold text-white">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-gray-400">{{ auth()->user()->role }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 text-xs font-medium py-2 px-3 rounded-xl transition flex items-center justify-center space-x-2">
                    <span>🚪</span>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama Dashboard Tenant -->
    <main class="flex-1 flex min-w-0 flex-col min-h-screen">
        
        <!-- Top Navbar -->
        <header class="min-h-16 h-auto bg-[#111827] border-b border-gray-800 flex flex-col justify-between gap-3 px-4 py-3 lg:flex-row lg:items-center lg:px-8">
            <div class="min-w-0">
                <div class="flex items-center space-x-2">
                    <h1 class="text-xs font-bold text-white tracking-wide">{{ $tenantName }} — Ringkasan Bengkel</h1>
                </div>
                <p class="text-[10px] text-gray-400">Ringkasan berdasarkan data operasional bengkel Anda.</p>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('user.menu') }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-700 px-3 py-2 text-[10px] font-medium text-gray-300 transition hover:border-blue-500 hover:text-white sm:text-xs">
                    <span aria-hidden="true">←</span>
                    <span>Kembali ke Akun Utama</span>
                </a>
                <div class="text-right hidden sm:block">
                    <p id="dashboard-clock" class="text-xs font-bold text-white">{{ now()->format('H:i:s') }} WIB</p>
                    <p id="dashboard-date" class="text-[10px] text-gray-400">{{ now()->locale('id')->translatedFormat('d M Y') }}</p>
                </div>
            </div>
        </header>

        <nav aria-label="Navigasi tenant" class="md:hidden flex items-center gap-2 overflow-x-auto border-b border-gray-800 bg-[#111827] px-4 py-3 text-xs text-gray-400">
            <a href="{{ route('owner.home') }}" class="shrink-0 rounded-lg px-3 py-2 {{ request()->routeIs('owner.home') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white' }}">Dashboard</a>
            <a href="{{ route('owner.antrean') }}" class="shrink-0 rounded-lg px-3 py-2 {{ request()->routeIs('owner.antrean') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white' }}">Antrean</a>
            <a href="{{ route('owner.kasir') }}" class="shrink-0 rounded-lg px-3 py-2 {{ request()->routeIs('owner.kasir') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white' }}">Kasir</a>
            <a href="{{ route('owner.stok') }}" class="shrink-0 rounded-lg px-3 py-2 {{ request()->routeIs('owner.stok') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white' }}">Stok</a>
            <a href="{{ route('owner.mekanik') }}" class="shrink-0 rounded-lg px-3 py-2 {{ request()->routeIs('owner.mekanik') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white' }}">Pelanggan & Mekanik</a>
            <a href="{{ route('owner.pengingat') }}" class="shrink-0 rounded-lg px-3 py-2 {{ request()->routeIs('owner.pengingat') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white' }}">Pengingat</a>
            <a href="{{ route('user.menu') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Akun Utama</a>
        </nav>

        <!-- Area Konten Dashboard -->
        <div class="min-w-0 p-4 sm:p-6 lg:p-8 space-y-6">
            
            <!-- 4 Kartu Metrik Utama Atas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow-lg relative">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Pendapatan Hari Ini</p>
                    <h3 class="text-xl font-bold text-white mt-1">Rp {{ number_format($revenueToday, 0, ',', '.') }}</h3>
                    <p class="text-[10px] text-gray-400 font-medium mt-1">Penjualan selesai hari ini</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow-lg relative">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Total Unit Servis</p>
                    <h3 class="text-xl font-bold text-white mt-1">{{ $workOrdersToday }} Unit</h3>
                    <p class="text-[10px] text-blue-400 font-medium mt-1">🔧 {{ $activeWorkOrdersCount }} Antrean Aktif</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow-lg relative">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Pengingat Terkirim</p>
                    <h3 class="text-xl font-bold text-white mt-1">{{ $remindersSentToday }}</h3>
                    <p class="text-[10px] text-yellow-400 font-medium mt-1">{{ $pendingRemindersCount }} Perlu Tindakan</p>
                </div>
                <div class="bg-[#111827] border border-gray-800 p-4 rounded-2xl shadow-lg relative">
                    <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Stok Sparepart Kritis</p>
                    <h3 class="text-xl font-bold text-red-400 mt-1">{{ $criticalParts->count() }} Item</h3>
                    <p class="text-[10px] text-red-400 font-medium mt-1">🚨 Di bawah stok minimum</p>
                </div>
            </div>

            <!-- Grid Tengah: Grafik & Widget Samping -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Grafik Pendapatan (2 Kolom) - Tinggi disesuaikan agar tidak terpotong -->
                <div class="lg:col-span-2 bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xs font-bold text-white">Grafik Pendapatan & Volume Servis Pekan Ini</h3>
                            <p class="text-[10px] text-gray-400">Pendapatan dari transaksi selesai per hari</p>
                        </div>
                        <span class="text-[10px] bg-[#1f2937] text-gray-300 px-3 py-1 rounded-lg border border-gray-700">7 Hari Terakhir</span>
                    </div>

                    <div class="min-h-60 bg-[#161e2e]/50 rounded-xl border border-gray-800 p-4">
                        @php
                            $maxRevenue = max(1, $weeklyActivity->max('revenue'));
                        @endphp
                        <div class="flex h-48 items-end justify-around gap-2">
                            @foreach ($weeklyActivity as $day)
                                <div class="flex h-full min-w-0 flex-1 flex-col items-center justify-end gap-2">
                                    <span class="text-[9px] text-gray-400">Rp {{ number_format($day['revenue'], 0, ',', '.') }}</span>
                                    <div class="w-full max-w-10 rounded-t bg-blue-500"
                                        style="height: {{ $day['revenue'] > 0 ? max(4, ($day['revenue'] / $maxRevenue) * 100) : 2 }}%"></div>
                                    <span class="text-[9px] text-gray-400">{{ $day['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                        @if ($weeklyActivity->sum('revenue') === 0.0 && $weeklyActivity->sum('work_orders') === 0)
                            <p class="mt-4 text-center text-[10px] text-gray-400">Belum ada transaksi atau servis dalam 7 hari terakhir.</p>
                        @endif
                    </div>
                </div>

                <!-- Widget Samping Kanan: Pengingat Servis Otomatis -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-5 shadow-lg space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                        <div>
                            <h4 class="text-xs font-bold text-white">Pengingat Servis Otomatis</h4>
                            <p class="text-[9px] text-gray-400">Jadwal ganti oli/sparepart berkala</p>
                        </div>
                        <span class="text-[9px] bg-green-500/20 text-green-400 px-2 py-0.5 rounded font-bold">{{ $pendingRemindersCount }} Perlu Tindakan</span>
                    </div>

                    <div class="space-y-3 text-xs">
                        @forelse ($pendingReminders as $reminder)
                            <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800 space-y-2">
                                <div class="flex justify-between items-start gap-3">
                                    <div>
                                        <p class="font-bold text-white">{{ $reminder->customer_name ?? 'Pelanggan' }}{{ $reminder->vehicle_brand ? ' ('.$reminder->vehicle_brand.' '.$reminder->vehicle_model.')' : '' }}</p>
                                        <p class="text-[10px] text-gray-400">Jatuh tempo: {{ \Illuminate\Support\Carbon::parse($reminder->due_date)->translatedFormat('d M Y') }}</p>
                                        @if ($reminder->message)
                                            <p class="mt-1 text-[10px] text-gray-400">{{ $reminder->message }}</p>
                                        @endif
                                    </div>
                                    <span class="text-[9px] bg-yellow-500/20 text-yellow-400 px-1.5 py-0.5 rounded">Tertunda</span>
                                </div>
                            </div>
                        @empty
                            <p class="py-4 text-center text-[10px] text-gray-400">Belum ada pengingat servis yang perlu ditindaklanjuti.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Bagian Bawah: Status Bay & Antrean Servis Aktif & Stok Kritis -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Tabel Antrean Aktif (2 Kolom) -->
                <div class="lg:col-span-2 bg-[#111827] border border-gray-800 rounded-2xl p-6 shadow-lg space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xs font-bold text-white">Status Bay & Antrean Servis Aktif</h3>
                            <p class="text-[10px] text-gray-400">Daftar kendaraan yang sedang berada dalam penanganan atau antrean</p>
                        </div>
                        <button class="text-xs text-blue-400 hover:underline">Refresh Status</button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-gray-300">
                            <thead class="text-gray-400 uppercase text-[9px] tracking-wider border-b border-gray-800 pb-2">
                                <tr>
                                    <th class="pb-3">No. Antrean</th>
                                    <th class="pb-3">Pelanggan / Kendaraan</th>
                                    <th class="pb-3">Jenis Pekerjaan</th>
                                    <th class="pb-3">Mekanik</th>
                                    <th class="pb-3">Status</th>
                                    <th class="pb-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800/60">
                                @forelse ($activeWorkOrders as $workOrder)
                                    <tr class="hover:bg-[#161e2e]/40">
                                        <td class="py-3 font-mono font-bold text-blue-400">{{ $workOrder->work_order_number }}</td>
                                        <td class="py-3">
                                            <p class="font-bold text-white">{{ $workOrder->customer_name }}</p>
                                            <p class="text-[10px] text-gray-400">{{ $workOrder->license_plate }} • {{ $workOrder->vehicle_brand }} {{ $workOrder->vehicle_model }}</p>
                                        </td>
                                        <td class="py-3 text-gray-300">{{ $workOrder->complaint ?: 'Belum dicatat' }}</td>
                                        <td class="py-3 text-gray-300">{{ $workOrder->mechanic_name ?: 'Belum ditentukan' }}</td>
                                        <td class="py-3">
                                            <span class="{{ $workOrder->status === 'waiting' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-blue-500/20 text-blue-400' }} px-2 py-0.5 rounded text-[10px] font-bold">
                                                {{ $workOrder->status === 'waiting' ? 'MENUNGGU' : 'DIKERJAKAN' }}
                                            </span>
                                        </td>
                                        <td class="py-3 text-right text-gray-500">—</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 text-center text-xs text-gray-400">
                                            Belum ada antrean atau servis yang sedang berjalan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Widget Samping: Stok Sparepart Kritis -->
                <div class="bg-[#111827] border border-gray-800 rounded-2xl p-5 shadow-lg space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                        <div>
                            <h4 class="text-xs font-bold text-white">Stok Sparepart Kritis</h4>
                            <p class="text-[9px] text-gray-400">Item di bawah batas minimum</p>
                        </div>
                        <span class="text-[9px] bg-red-500/20 text-red-400 px-2 py-0.5 rounded font-bold">{{ $criticalParts->count() }} Item</span>
                    </div>

                    <div class="space-y-3 text-xs">
                        @forelse ($criticalParts as $part)
                            <div class="bg-[#161e2e] p-3 rounded-xl border border-gray-800 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-bold text-white">{{ $part->name }}</p>
                                    <p class="text-[10px] text-red-400 font-medium">
                                        Stok: <strong class="text-white">{{ $part->stock }} {{ $part->unit }}</strong>
                                        (Min: {{ $part->minimum_stock }})
                                    </p>
                                </div>
                                <a href="{{ route('owner.stok') }}" class="shrink-0 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow">Kelola Stok</a>
                            </div>
                        @empty
                            <p class="py-4 text-center text-[10px] text-gray-400">Tidak ada sparepart yang berada di bawah stok minimum.</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </main>

    <script>
        const dashboardClock = document.getElementById('dashboard-clock');
        const dashboardDate = document.getElementById('dashboard-date');
        const jakartaTimeFormatter = new Intl.DateTimeFormat('en-GB', {
            timeZone: 'Asia/Jakarta',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hourCycle: 'h23',
        });
        const jakartaDateFormatter = new Intl.DateTimeFormat('id-ID', {
            timeZone: 'Asia/Jakarta',
            day: '2-digit',
            month: 'short',
            year: 'numeric',
        });

        function updateDashboardClock() {
            const currentTime = new Date();

            dashboardClock.textContent = `${jakartaTimeFormatter.format(currentTime)} WIB`;
            dashboardDate.textContent = jakartaDateFormatter.format(currentTime);
        }

        updateDashboardClock();
        window.setInterval(updateDashboardClock, 1000);
    </script>
</body>
</html>