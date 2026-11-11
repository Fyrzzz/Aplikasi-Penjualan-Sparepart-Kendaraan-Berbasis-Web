<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Konsumen - AMAHAY</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0b0f19] text-gray-200 min-h-screen flex items-center justify-center font-sans py-10">

    <div class="bg-[#111827] border border-gray-800/80 p-8 md:p-10 rounded-3xl shadow-2xl w-full max-w-lg relative">

        <div class="text-center mb-6">
            <div
                class="w-12 h-12 bg-blue-600 rounded-2xl mx-auto flex items-center justify-center shadow-lg shadow-blue-600/30 mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.9 6.9a2.12 2.12 0 1 1-3-3l6.9-6.9a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                    </path>
                </svg>
            </div>
            <h1 class="text-lg font-bold text-white tracking-wide">Registrasi Konsumen</h1>
            <p class="text-xs text-gray-400 mt-1">Buat akun untuk booking dan melihat riwayat servis</p>
        </div>

        <form action="{{ route('register.customer.proses') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-800 bg-red-950/40 px-4 py-3 text-xs text-red-300">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="space-y-1.5">
                <label class="block text-xs font-medium text-gray-300">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="contoh: budi123"
                    required minlength="3" maxlength="30" autocomplete="username"
                    class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
            </div>

            <div class="space-y-1.5 mt-4">
                <label class="block text-xs font-medium text-gray-300">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" required
                    autocomplete="name"
                    class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
            </div>

            <div class="space-y-1.5 mt-4">
                <label class="block text-xs font-medium text-gray-300">Email atau No. WhatsApp</label>
                <input type="text" name="contact" value="{{ old('contact') }}"
                    placeholder="nama@email.com atau 08123456789" required autocomplete="email"
                    class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
            </div>

            <div class="space-y-1.5 mt-4">
                <label class="block text-xs font-medium text-gray-300">Password</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required minlength="8"
                    autocomplete="new-password"
                    class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
            </div>

            <div class="space-y-1.5 mt-4">
                <label class="block text-xs font-medium text-gray-300">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" required
                    minlength="8" autocomplete="new-password"
                    class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl shadow-lg shadow-blue-600/30 transition duration-200 text-sm mt-6">
                Buat Akun Konsumen
            </button>
        </form>

        <div class="text-center mt-5 text-xs text-gray-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-400 hover:underline font-medium">Masuk</a>
        </div>
        <p class="text-center mt-3 text-xs text-gray-500">
            Pembuatan tenant bengkel tersedia setelah Anda masuk ke akun utama.
        </p>

    </div>

</body>

</html>
