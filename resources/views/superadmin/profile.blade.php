<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Super Admin - AMAHAY</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#0b0f19] font-sans text-gray-200">
    <main class="mx-auto flex min-h-screen w-full max-w-3xl flex-col px-4 py-8 sm:px-6 sm:py-12">
        <a href="{{ route('superadmin.home') }}" class="mb-6 inline-flex w-fit items-center gap-2 text-xs text-gray-400 transition hover:text-white">
            <span aria-hidden="true">←</span>
            Kembali ke Dashboard Global
        </a>

        <section class="rounded-3xl border border-gray-800 bg-[#111827] p-6 shadow-2xl sm:p-10">
            <div class="mb-7 flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-600 text-lg font-bold text-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-lg font-bold text-white">Profil Super Admin</h1>
                    <p class="mt-1 text-xs text-gray-400">Perbarui identitas akun atau ganti password.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-5 rounded-xl border border-green-800 bg-green-950/40 px-4 py-3 text-xs text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-800 bg-red-950/40 px-4 py-3 text-xs text-red-300">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('superadmin.profile.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div class="space-y-1.5">
                        <label for="username" class="block text-xs font-medium text-gray-300">Username</label>
                        <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" required minlength="3" maxlength="30" autocomplete="username" class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-sm text-white focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label for="name" class="block text-xs font-medium text-gray-300">Nama</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required maxlength="255" autocomplete="name" class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-sm text-white focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-medium text-gray-300">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required maxlength="255" autocomplete="email" class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-sm text-white focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label for="phone" class="block text-xs font-medium text-gray-300">Nomor WhatsApp</label>
                        <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}" maxlength="20" autocomplete="tel" class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-sm text-white focus:border-blue-500 focus:outline-none">
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-5">
                    <h2 class="text-sm font-semibold text-white">Ganti Password</h2>
                    <p class="mt-1 text-xs text-gray-400">Kosongkan jika tidak ingin mengganti password.</p>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div class="space-y-1.5 sm:col-span-2">
                        <label for="current_password" class="block text-xs font-medium text-gray-300">Password saat ini</label>
                        <input id="current_password" name="current_password" type="password" autocomplete="current-password" class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-sm text-white focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label for="password" class="block text-xs font-medium text-gray-300">Password baru</label>
                        <input id="password" name="password" type="password" minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-sm text-white focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-xs font-medium text-gray-300">Konfirmasi password baru</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-sm text-white focus:border-blue-500 focus:outline-none">
                    </div>
                </div>

                <button type="submit" class="w-full rounded-xl bg-blue-600 py-3 text-sm font-medium text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 sm:w-auto sm:px-8">
                    Simpan Profil
                </button>
            </form>
        </section>
    </main>
</body>

</html>
