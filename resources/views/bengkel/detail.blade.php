<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail & Booking - AMAHAY</title>
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
                    ← Kembali ke Pencarian
                </a>
                <span class="text-sm font-bold text-white hidden md:inline">Detail Bengkel & Booking</span>
            </div>
            <!-- User Profile Pill -->
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
                    <a href="{{ route('user.profil.edit') }}"
                        class="block px-4 py-2 text-gray-300 hover:bg-[#1f2937] hover:text-white transition">⚙️ Edit
                        Profil & Motor</a>
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
            <a href="{{ route('user.menu') }}" class="shrink-0 rounded-lg bg-[#161e2e] px-3 py-2 text-blue-400">Cari Bengkel</a>
            <a href="{{ route('user.cek.servis') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#161e2e] hover:text-white">Cek Status</a>
            <a href="{{ route('user.promo') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#161e2e] hover:text-white">Promo</a>
            <a href="{{ route('user.riwayat') }}" class="shrink-0 rounded-lg px-3 py-2 hover:bg-[#161e2e] hover:text-white">Riwayat</a>
        </nav>

        <!-- Main Content -->
        <main class="max-w-6xl mx-auto px-4 py-6 sm:px-6 sm:py-8">

            <!-- Header Info Bengkel -->
            <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-6 mb-8 shadow-lg">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <span class="text-[10px] bg-blue-500/10 text-blue-400 font-semibold px-2.5 py-1 rounded-md">Bengkel Terdaftar</span>
                        <h1 class="text-xl md:text-2xl font-bold text-white mt-2">{{ $tenant->getAttribute('tenant_name') }}</h1>
                        <p class="text-xs text-gray-400 mt-1">{{ $tenant->domains->first()?->domain ?? 'Informasi domain belum tersedia' }}</p>
                    </div>
                    <div>
                        <span class="text-xs bg-green-500/10 text-green-400 font-semibold px-2.5 py-1 rounded">Aktif</span>
                        <p class="text-[11px] text-gray-400 mt-2">Jadwalkan servis melalui formulir booking</p>
                    </div>
                </div>
            </div>

            <!-- Grid 2 Kolom -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Kolom Kiri: Layanan & Fasilitas (2 Span) -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Pilih Paket Servis -->
                    <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
                        <h2 class="text-sm font-bold text-white mb-4">Pilih Jenis Servis / Paket</h2>

                        <div class="space-y-3">
                            @forelse ($services as $service)
                                <label class="flex items-center justify-between gap-3 p-4 bg-[#161e2e] border border-gray-800 rounded-xl cursor-pointer hover:border-blue-500 transition">
                                    <div class="flex items-center space-x-3">
                                        <input type="radio" name="service_id" value="{{ $service->id }}" form="booking-form" data-price="{{ $service->price }}" class="service-option text-blue-600 focus:ring-blue-500 bg-gray-900 border-gray-700" {{ $loop->first ? 'checked' : '' }}>
                                        <div>
                                            <p class="text-xs font-bold text-white">{{ $service->name }}</p>
                                            @if ($service->description)
                                                <p class="text-[11px] text-gray-400">{{ $service->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="shrink-0 text-xs font-bold text-blue-400">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                </label>
                            @empty
                                <p class="rounded-xl border border-gray-800 bg-[#161e2e] p-4 text-xs text-gray-400">Bengkel belum mempublikasikan layanan servis.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Fasilitas Bengkel -->
                    <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-6 shadow-lg">
                        <h2 class="text-sm font-bold text-white mb-4">Fasilitas Bengkel</h2>
                        <p class="text-xs text-gray-400">Informasi fasilitas belum dicantumkan oleh bengkel.</p>
                    </div>

                </div>

                <!-- Kolom Kanan: Form Booking Cepat (1 Span) -->
                <div class="lg:col-span-1">
                    <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-6 shadow-xl sticky top-24">
                        <h2 class="text-sm font-bold text-white mb-4">Formulir Booking Cepat</h2>

                        <form id="booking-form" action="{{ route('user.bengkel.booking', ['id' => $tenant->getTenantKey()]) }}" method="POST" class="space-y-4 text-xs">
                            @csrf
                            @if ($vehicles->isNotEmpty())
                                <div>
                                    <label class="block text-gray-400 mb-1.5">Kendaraan tersimpan</label>
                                    <select name="vehicle_id" id="saved-vehicle" class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-blue-500">
                                        <option value="">Isi kendaraan baru</option>
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" data-plate="{{ $vehicle->license_plate }}" data-brand="{{ $vehicle->brand }}" data-model="{{ $vehicle->model }}" data-year="{{ $vehicle->year }}" data-odometer="{{ $vehicle->odometer }}">{{ $vehicle->license_plate }} — {{ $vehicle->brand }} {{ $vehicle->model }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            <div>
                                <label class="block text-gray-400 mb-1.5">Nomor Plat Kendaraan</label>
                                <input type="text" name="license_plate" id="booking-plate" value="{{ old('license_plate') }}" required maxlength="20" placeholder="Contoh: B 1234 XYZ"
                                    class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-gray-400 mb-1.5">Merek Motor</label>
                                    <input type="text" name="brand" id="booking-brand" required maxlength="100" placeholder="Honda"
                                        class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-gray-400 mb-1.5">Model</label>
                                    <input type="text" name="model" id="booking-model" required maxlength="100" placeholder="BeAT"
                                        class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-gray-400 mb-1.5">Tahun</label>
                                    <input type="number" name="year" id="booking-year" min="1900" max="{{ now()->year + 1 }}"
                                        class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-gray-400 mb-1.5">Odometer (km)</label>
                                    <input type="number" name="odometer" id="booking-odometer" min="0" value="0"
                                        class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-blue-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-400 mb-1.5">Tanggal Kedatangan</label>
                                <input type="date" name="scheduled_date" min="{{ now()->toDateString() }}" value="{{ old('scheduled_date') }}" required
                                    class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-gray-400 mb-1.5">Pilih Jam Sesi Antrean</label>
                                <select name="scheduled_time" required
                                    class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white focus:outline-none focus:border-blue-500">
                                    <option value="09:00">09:00</option>
                                    <option value="10:00">10:00</option>
                                    <option value="13:00">13:00</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-400 mb-1.5">Keluhan / Catatan (Opsional)</label>
                                <textarea name="complaint" rows="2" maxlength="2000" placeholder="Contoh: Rem belakang agak bunyi..."
                                    class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-3.5 py-2.5 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500"></textarea>
                            </div>

                            <div class="pt-2 border-t border-gray-800">
                                <div class="flex justify-between text-gray-400 mb-3">
                                    <span>Estimasi Total</span>
                                    <span id="booking-estimate" class="text-sm font-bold text-blue-400">Rp 0</span>
                                </div>
                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl text-xs transition shadow-lg shadow-blue-600/30">
                                    Konfirmasi & Ambil Antrean 🚀
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- Footer -->
    <footer
        class="border-t border-gray-800/80 py-4 px-6 text-center text-[11px] text-gray-500 flex justify-between max-w-6xl mx-auto w-full mt-12">
        <span>© AMAHAY 2026</span>
        <span>SaaS Manajemen Bengkel & Konsumen Portal</span>
    </footer>
    <script>
        const formatRupiah = (amount) => `Rp ${new Intl.NumberFormat('id-ID').format(amount)}`;
        const serviceOptions = document.querySelectorAll('.service-option');
        const updateEstimate = () => {
            const selectedService = document.querySelector('.service-option:checked');
            document.getElementById('booking-estimate').textContent = formatRupiah(selectedService ? Number(selectedService.dataset.price) : 0);
        };
        serviceOptions.forEach((option) => option.addEventListener('change', updateEstimate));
        updateEstimate();

        const savedVehicle = document.getElementById('saved-vehicle');
        if (savedVehicle) {
            savedVehicle.addEventListener('change', () => {
                const option = savedVehicle.selectedOptions[0];
                document.getElementById('booking-plate').value = option.dataset.plate || '';
                document.getElementById('booking-brand').value = option.dataset.brand || '';
                document.getElementById('booking-model').value = option.dataset.model || '';
                document.getElementById('booking-year').value = option.dataset.year || '';
                document.getElementById('booking-odometer').value = option.dataset.odometer || '0';
            });
        }

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