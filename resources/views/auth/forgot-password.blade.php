<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - AMAHAY</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#0b0f19] px-4 py-10 text-gray-200">
    <main class="mx-auto w-full max-w-md rounded-2xl border border-gray-800 bg-[#111827] p-6 shadow-xl sm:p-8">
        <h1 class="text-xl font-bold text-white">Atur Ulang Password</h1>
        <p class="mt-2 text-sm text-gray-400">Masukkan email akun Anda. Jika terdaftar, tautan pengaturan ulang akan dikirim ke email tersebut.</p>

        @if (session('status'))
            <p role="status" class="mt-4 rounded-xl border border-green-500/30 bg-green-500/10 p-3 text-sm text-green-300">{{ session('status') }}</p>
        @endif
        @error('email')
            <p role="alert" class="mt-4 rounded-xl border border-red-500/30 bg-red-500/10 p-3 text-sm text-red-300">{{ $message }}</p>
        @enderror

        <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
            @csrf
            <label class="block text-sm text-gray-300" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                class="w-full rounded-xl border border-gray-700 bg-[#1f2937] px-4 py-3 text-sm text-white focus:border-blue-500 focus:outline-none">
            <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700">Kirim tautan reset</button>
        </form>

        <a href="{{ route('login') }}" class="mt-5 inline-block text-sm text-blue-400 hover:underline">Kembali ke login</a>
    </main>
</body>
</html>
