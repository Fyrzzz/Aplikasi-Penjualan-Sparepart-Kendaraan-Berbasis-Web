<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil & Motor - AMAHAY</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex flex-col justify-between">

    <div class="max-w-xl mx-auto w-full px-4 py-8 sm:px-6 sm:py-12">
        <!-- Tombol Kembali -->
        <a href="{{ route('user.menu') }}" class="text-xs bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-lg text-gray-400 hover:text-white transition inline-block mb-6">
            ← Kembali ke Menu Utama
        </a>

        <!-- Card Form Edit -->
        <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-5 shadow-xl space-y-6 sm:p-8">
            <div>
                <h1 class="text-lg font-bold text-white">Pengaturan Profil & Kendaraan</h1>
                <p class="text-xs text-gray-400 mt-0.5">Perbarui informasi akun konsumen dan data motor kesayangan Anda.</p>
            </div>

            @if (session('success'))
                <p class="rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-xs text-green-300">{{ session('success') }}</p>
            @endif
            @if ($errors->any())
                <div class="rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-xs text-red-300">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('user.profil.update') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-gray-400 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required maxlength="255" class="w-full bg-[#161e2e] border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-400 mb-1.5">Email atau Nomor WhatsApp</label>
                    <input type="text" name="contact" value="{{ old('contact', auth()->user()->phone ?: (str_ends_with(auth()->user()->email, '@accounts.amahay.invalid') ? '' : auth()->user()->email)) }}" required maxlength="255" class="w-full bg-[#161e2e] border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                </div>

                @php($vehicle = $vehicles->first())
                @if ($vehicle)
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                @endif
                <div>
                    <label class="block text-gray-400 mb-1.5">Nomor Plat Kendaraan Utama</label>
                    <input type="text" name="license_plate" value="{{ old('license_plate', $vehicle->license_plate ?? '') }}" maxlength="20" placeholder="Contoh: B 1234 XYZ" class="w-full bg-[#161e2e] border border-gray-700 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-gray-400 mb-1.5">Merek Kendaraan</label>
                        <input type="text" name="brand" value="{{ old('brand', $vehicle->brand ?? '') }}" maxlength="100" placeholder="Contoh: Honda" class="w-full bg-[#161e2e] border border-gray-700 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-400 mb-1.5">Model Kendaraan</label>
                        <input type="text" name="model" value="{{ old('model', $vehicle->model ?? '') }}" maxlength="100" placeholder="Contoh: BeAT" class="w-full bg-[#161e2e] border border-gray-700 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-gray-400 mb-1.5">Tahun</label>
                        <input type="number" name="year" value="{{ old('year', $vehicle->year ?? '') }}" min="1900" max="{{ now()->year + 1 }}" class="w-full bg-[#161e2e] border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-400 mb-1.5">Odometer (km)</label>
                        <input type="number" name="odometer" value="{{ old('odometer', $vehicle->odometer ?? 0) }}" min="0" class="w-full bg-[#161e2e] border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-800 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('user.menu') }}" class="w-full rounded-xl bg-gray-800 px-5 py-2.5 text-center text-gray-300 transition hover:bg-gray-700 sm:w-auto">Batal</a>
                    <button type="submit" class="w-full rounded-xl bg-blue-600 px-5 py-2.5 text-white font-medium transition shadow-lg shadow-blue-600/30 hover:bg-blue-700 sm:w-auto">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            @if ($vehicles->count() > 1)
                <div class="border-t border-gray-800 pt-4">
                    <h2 class="mb-2 text-xs font-semibold text-white">Kendaraan lainnya</h2>
                    <ul class="space-y-2 text-xs text-gray-400">
                        @foreach ($vehicles->skip(1) as $savedVehicle)
                            <li>{{ $savedVehicle->license_plate }} — {{ $savedVehicle->brand }} {{ $savedVehicle->model }} ({{ $savedVehicle->year ?: 'Tahun tidak dicatat' }})</li>
                        @endforeach
                    </ul>
                    <p class="mt-2 text-[10px] text-gray-500">Pilih kendaraan yang tersimpan saat membuat booking untuk memperbarui datanya.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-gray-800/80 py-4 px-6 text-center text-[11px] text-gray-500 max-w-xl mx-auto w-full">
        <span>© AMAHAY 2026</span>
    </footer>

</body>
</html>