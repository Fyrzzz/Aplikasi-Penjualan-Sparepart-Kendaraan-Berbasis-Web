<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - AMAHAY</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex">

    <!-- Sidebar Super Admin -->
    <aside class="w-64 bg-[#111827] border-r border-gray-800 flex flex-col justify-between hidden md:flex">
        <div>
            <!-- Brand / Logo -->
            <div class="h-16 flex items-center px-6 border-b border-gray-800 space-x-3">
                <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center shadow-md">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.9 6.9a2.12 2.12 0 1 1-3-3l6.9-6.9a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                        </path>
                    </svg>
                </div>
                <span class="text-base font-bold tracking-wider text-white">AMAHAY Admin</span>
            </div>

            <!-- Menu Sidebar (5 Fitur Super Admin) -->
            <nav class="p-4 space-y-1.5 text-xs">
                <a href="/superadmin/dashboard"
                    class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-dashboard') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>📊</span>
                    <span>Dashboard Global</span>
                </a>
                <a href="/superadmin/tenant"
                    class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>🏢</span>
                    <span>Kelola Bengkel (Tenant)</span>
                </a>
                <a href="/superadmin/laporan"
                    class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-laporan') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>💵</span>
                    <span>Laporan Keuangan</span>
                </a>
                <a href="/superadmin/paket"
                    class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-paket') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>📦</span>
                    <span>Manajemen Paket</span>
                </a>
                <a href="/superadmin/pengaturan"
                    class="flex items-center space-x-3 px-4 py-2.5 {{ Request::is('test-superadmin-pengaturan') ? 'bg-[#1f2937] text-white font-medium shadow-sm border border-gray-700/50' : 'text-gray-400 hover:bg-[#1f2937] hover:text-white transition' }}">
                    <span>⚙️</span>
                    <span>Pengaturan Platform</span>
                </a>
            </nav>
        </div>

        <!-- Footer Sidebar (Info Sistem + Tombol Logout) -->
        <div class="p-4 border-t border-gray-800 space-y-3">
            <div class="text-[10px] text-gray-500">
                Sistem Multi-Tenant v1.0<br>Super Admin Access
            </div>
            <a href="/"
                class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 text-xs font-medium py-2 px-3 rounded-xl transition flex items-center justify-center space-x-2">
                <span>🚪</span>
                <span>Keluar (Logout)</span>
            </a>
        </div>
    </aside>

    <!-- Konten Utama -->
    <main class="flex-1 flex min-w-0 flex-col min-h-screen">

        <!-- Top Navbar -->
        <header class="min-h-16 bg-[#111827] border-b border-gray-800 flex items-center justify-between gap-3 px-4 py-3 sm:px-8">
            <h1 class="text-xs font-semibold text-gray-300 tracking-wide uppercase">Manajemen Tenant</h1>
            <div
                class="flex shrink-0 items-center space-x-2 bg-[#1f2937] px-3 py-1.5 rounded-full border border-gray-800 text-xs">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                <a href="{{ route('superadmin.profile.edit') }}" class="text-white font-medium hover:text-blue-300">{{ auth()->user()->name }}</a>
            </div>
        </header>

        <nav class="md:hidden flex items-center gap-2 overflow-x-auto border-b border-gray-800 bg-[#111827] px-4 py-3 text-xs text-gray-400">
            <a href="{{ route('superadmin.home') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Dashboard</a>
            <a href="{{ route('superadmin.tenant') }}" class="shrink-0 rounded-lg bg-[#1f2937] px-3 py-2 text-white">Tenant</a>
            <a href="{{ route('superadmin.laporan') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Laporan</a>
            <a href="{{ route('superadmin.paket') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Paket</a>
            <a href="{{ route('superadmin.pengaturan') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#1f2937] hover:text-white">Pengaturan</a>
        </nav>

        @if (session('success'))
            <div class="mx-4 mt-4 rounded-xl border border-green-800 bg-green-950/40 px-4 py-3 text-xs text-green-300 sm:mx-6 lg:mx-8">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mx-4 mt-4 rounded-xl border border-red-800 bg-red-950/40 px-4 py-3 text-xs text-red-300 sm:mx-6 lg:mx-8">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Area Konten Tabel -->
        <div class="p-4 sm:p-6 lg:p-8 space-y-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base font-bold text-white">Daftar Bengkel Langganan</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Kelola daftar tenant yang terdaftar pada platform.</p>
                </div>
                <a href="{{ route('register') }}"
                    class="inline-flex w-fit items-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-2 rounded-xl shadow transition">
                    + Daftarkan Bengkel Baru
                </a>
            </div>

            <div class="hidden md:block bg-[#111827] border border-gray-800 rounded-2xl overflow-x-auto shadow-lg">
                <table class="w-full min-w-[760px] text-left text-xs text-gray-300">
                    <thead
                        class="bg-[#161e2e] text-gray-400 uppercase text-[10px] tracking-wider border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-3.5">Identitas Bengkel</th>
                            <th class="px-6 py-3.5">Kontak Pemilik</th>
                            <th class="px-6 py-3.5">Paket Langganan</th>
                            <th class="px-6 py-3.5">Status & Domain</th>
                            <th class="px-6 py-3.5">Tindakan Moderator</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse ($tenants as $tenant)
                            @php
                                $status = $tenant->getAttribute('status') ?? 'active';
                                [$statusLabel, $statusClass] = match ($status) {
                                    'inactive' => ['NONAKTIF', 'border-yellow-500/30 bg-yellow-500/20 text-yellow-300'],
                                    'banned' => ['DIBLOKIR', 'border-red-500/30 bg-red-500/20 text-red-300'],
                                    default => ['AKTIF', 'border-green-500/30 bg-green-500/20 text-green-400'],
                                };
                            @endphp
                            <tr class="hover:bg-[#161e2e]/50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-white">{{ $tenant->getAttribute('tenant_name') }}</p>
                                    <p class="text-[10px] text-gray-400">
                                        Bergabung: {{ $tenant->created_at?->format('d M Y') ?? '—' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-200">{{ $tenant->owner?->name ?? 'Pemilik belum tersedia' }}</p>
                                    <p class="text-[10px] text-gray-400">{{ $tenant->owner?->phone ?? $tenant->getAttribute('phone') ?? 'Kontak belum tersedia' }}</p>
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-200">
                                    {{ ucfirst((string) $tenant->getAttribute('package')) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full border px-3 py-1 text-[10px] font-bold {{ $statusClass }}">{{ $statusLabel }}</span>
                                    <p class="mt-2 text-[10px] text-gray-400">{{ $tenant->domains->first()?->domain ?? 'Domain belum tersedia' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <details class="min-w-52">
                                        <summary class="cursor-pointer text-xs font-medium text-blue-400 hover:text-blue-300">Kelola tenant</summary>
                                        <div class="mt-3 space-y-3">
                                            <form action="{{ route('superadmin.tenant.status', $tenant) }}" method="POST" class="space-y-2">
                                                @csrf
                                                @method('PATCH')
                                                <label class="sr-only" for="tenant-status-{{ $tenant->getTenantKey() }}">Status tenant</label>
                                                <select id="tenant-status-{{ $tenant->getTenantKey() }}" name="status" class="w-full rounded-lg border border-gray-700 bg-[#161e2e] px-2 py-2 text-[11px] text-white">
                                                    <option value="active" @selected($status === 'active')>Aktifkan</option>
                                                    <option value="inactive" @selected($status === 'inactive')>Nonaktifkan</option>
                                                    <option value="banned" @selected($status === 'banned')>Blokir</option>
                                                </select>
                                                <input type="text" name="status_reason" maxlength="500" placeholder="Alasan (opsional)" value="{{ $tenant->getAttribute('status_reason') }}" class="w-full rounded-lg border border-gray-700 bg-[#161e2e] px-2 py-2 text-[11px] text-white placeholder-gray-500">
                                                <button type="submit" class="w-full rounded-lg bg-blue-600 px-3 py-2 text-[11px] font-medium text-white hover:bg-blue-700">Simpan status</button>
                                            </form>
                                            <form action="{{ route('superadmin.tenant.destroy', $tenant) }}" method="POST" class="space-y-2 border-t border-gray-800 pt-3">
                                                @csrf
                                                @method('DELETE')
                                                <label class="block text-[10px] text-red-300">Hapus permanen — ketik nama bengkel</label>
                                                <input type="text" name="confirmation" required autocomplete="off" class="w-full rounded-lg border border-red-900 bg-[#161e2e] px-2 py-2 text-[11px] text-white">
                                                <button type="submit" class="w-full rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-[11px] font-medium text-red-300 hover:bg-red-500/20">Hapus tenant & database</button>
                                            </form>
                                        </div>
                                    </details>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                    Belum ada tenant yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="space-y-4 md:hidden">
                @forelse ($tenants as $tenant)
                    @php
                        $status = $tenant->getAttribute('status') ?? 'active';
                        [$statusLabel, $statusClass] = match ($status) {
                            'inactive' => ['NONAKTIF', 'border-yellow-500/30 bg-yellow-500/20 text-yellow-300'],
                            'banned' => ['DIBLOKIR', 'border-red-500/30 bg-red-500/20 text-red-300'],
                            default => ['AKTIF', 'border-green-500/30 bg-green-500/20 text-green-400'],
                        };
                    @endphp
                    <article class="rounded-2xl border border-gray-800 bg-[#111827] p-5 shadow-lg">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="break-words text-sm font-bold text-white">{{ $tenant->getAttribute('tenant_name') }}</h3>
                                <p class="mt-1 text-[10px] text-gray-400">
                                    Bergabung: {{ $tenant->created_at?->format('d M Y') ?? '—' }}
                                </p>
                            </div>
                            <span class="shrink-0 rounded-full border px-2.5 py-1 text-[10px] font-bold {{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>
                        <dl class="mt-4 grid grid-cols-1 gap-3 text-xs">
                            <div>
                                <dt class="text-gray-500">Pemilik</dt>
                                <dd class="mt-1 text-gray-200">{{ $tenant->owner?->name ?? 'Belum tersedia' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Kontak</dt>
                                <dd class="mt-1 break-all text-gray-200">{{ $tenant->owner?->phone ?? $tenant->getAttribute('phone') ?? 'Belum tersedia' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Paket</dt>
                                <dd class="mt-1 text-gray-200">{{ ucfirst((string) $tenant->getAttribute('package')) }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Domain</dt>
                                <dd class="mt-1 break-all text-gray-200">{{ $tenant->domains->first()?->domain ?? 'Belum tersedia' }}</dd>
                            </div>
                        </dl>
                        <details class="mt-5 border-t border-gray-800 pt-4">
                            <summary class="cursor-pointer text-xs font-medium text-blue-400">Tindakan moderator</summary>
                            <div class="mt-3 space-y-3">
                                <form action="{{ route('superadmin.tenant.status', $tenant) }}" method="POST" class="space-y-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" aria-label="Status tenant" class="w-full rounded-lg border border-gray-700 bg-[#161e2e] px-3 py-2 text-xs text-white">
                                        <option value="active" @selected($status === 'active')>Aktifkan</option>
                                        <option value="inactive" @selected($status === 'inactive')>Nonaktifkan</option>
                                        <option value="banned" @selected($status === 'banned')>Blokir</option>
                                    </select>
                                    <input type="text" name="status_reason" maxlength="500" placeholder="Alasan (opsional)" value="{{ $tenant->getAttribute('status_reason') }}" class="w-full rounded-lg border border-gray-700 bg-[#161e2e] px-3 py-2 text-xs text-white placeholder-gray-500">
                                    <button type="submit" class="w-full rounded-lg bg-blue-600 px-3 py-2 text-xs font-medium text-white hover:bg-blue-700">Simpan status</button>
                                </form>
                                <form action="{{ route('superadmin.tenant.destroy', $tenant) }}" method="POST" class="space-y-2 border-t border-gray-800 pt-3">
                                    @csrf
                                    @method('DELETE')
                                    <label class="block text-[10px] text-red-300">Hapus permanen — ketik nama bengkel</label>
                                    <input type="text" name="confirmation" required autocomplete="off" class="w-full rounded-lg border border-red-900 bg-[#161e2e] px-3 py-2 text-xs text-white">
                                    <button type="submit" class="w-full rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-xs font-medium text-red-300 hover:bg-red-500/20">Hapus tenant & database</button>
                                </form>
                            </div>
                        </details>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-gray-700 bg-[#111827] px-5 py-10 text-center">
                        <p class="text-sm font-semibold text-white">Belum ada tenant yang terdaftar.</p>
                        <p class="mt-2 text-xs text-gray-400">Tenant baru akan muncul setelah mendaftar.</p>
                    </div>
                @endforelse
            </div>

            @if ($tenants->hasPages())
                <div>{{ $tenants->links() }}</div>
            @endif

        </div>
    </main>

</body>

</html>