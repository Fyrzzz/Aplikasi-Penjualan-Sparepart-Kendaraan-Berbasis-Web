<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Baru - AMAHAY</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#0b0f19] px-4 py-10 text-gray-200">
    <main class="mx-auto w-full max-w-md rounded-2xl border border-gray-800 bg-[#111827] p-6 shadow-xl sm:p-8">
        <h1 class="text-xl font-bold text-white">Buat Password Baru</h1>
        <p class="mt-2 text-sm text-gray-400">Gunakan password minimal 8 karakter.</p>

        <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <label class="block space-y-1 text-sm text-gray-300">
                <span>Email</span>
                <input name="email" type="email" value="{{ old('email', $email) }}" required autocomplete="email"
                    class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-white focus:border-blue-500 focus:outline-none">
                @error('email')
                    <span role="alert" class="block text-xs text-red-400">{{ $message }}</span>
                @enderror
            </label>
            <label class="block space-y-1 text-sm text-gray-300">
                <span>Password baru</span>
                <input name="password" type="password" required autocomplete="new-password"
                    class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-white focus:border-blue-500 focus:outline-none">
                @error('password')
                    <span role="alert" class="block text-xs text-red-400">{{ $message }}</span>
                @enderror
            </label>
            <label class="block space-y-1 text-sm text-gray-300">
                <span>Konfirmasi password</span>
                <input name="password_confirmation" type="password" required autocomplete="new-password"
                    class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-white focus:border-blue-500 focus:outline-none">
            </label>
            <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700">Simpan password baru</button>
        </form>
    </main>
</body>
</html>
