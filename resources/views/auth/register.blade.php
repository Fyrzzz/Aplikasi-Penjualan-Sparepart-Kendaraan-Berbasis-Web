<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Tenant Bengkel - AMAHAY</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0b0f19] text-gray-200 min-h-screen flex items-center justify-center font-sans py-10">

    <!-- Card Container Register -->
    <div class="bg-[#111827] border border-gray-800/80 p-8 md:p-10 rounded-3xl shadow-2xl w-full max-w-lg relative">

        <!-- Logo & Header -->
        <div class="text-center mb-6">
            <div
                class="w-12 h-12 bg-blue-600 rounded-2xl mx-auto flex items-center justify-center shadow-lg shadow-blue-600/30 mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.9 6.9a2.12 2.12 0 1 1-3-3l6.9-6.9a6 6 0 0 1 7.94-7.94l-3.76 3.76z">
                    </path>
                </svg>
            </div>
            <h1 class="text-lg font-bold text-white tracking-wide">Registrasi Tenant Bengkel</h1>
            <p class="text-xs text-gray-400 mt-1">Mulai uji coba gratis 14 hari tanpa kartu kredit</p>
        </div>

        <!-- Form Register -->
        <form action="/test-dashboard" method="POST" class="space-y-4 text-xs">
            @csrf

            <!-- Nama Bengkel Anda -->
            <div class="space-y-1.5">
                <label class="block font-medium text-gray-300">Nama Bengkel Anda</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </span>
                    <input type="text" name="tenant_name" placeholder="Contoh: Bengkel Amahay" required
                        class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>

            <!-- Domain Akses Bengkel -->
            <div class="space-y-1.5">
                <label class="block font-medium text-gray-300">Domain Akses Bengkel</label>
                <div class="flex rounded-xl overflow-hidden border border-gray-700/80 bg-[#161e2e]">
                    <input type="text" name="subdomain" placeholder="majujaya" required
                        class="w-full bg-transparent px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none">
                    <span
                        class="bg-[#1f2937] text-gray-400 px-4 py-3 text-xs flex items-center border-l border-gray-700/80 font-medium">.autozone.pro</span>
                </div>
            </div>

            <!-- Nama Pemilik & No. WhatsApp -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block font-medium text-gray-300">Nama Pemilik</label>
                    <input type="text" name="owner_name" placeholder="Budi Santoso" required
                        class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block font-medium text-gray-300">No. WhatsApp</label>
                    <input type="text" name="phone" placeholder="08123456789" required
                        class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>

            <!-- Buat Kata Sandi dengan Tombol Mata -->
            <div class="space-y-1.5">
                <label class="block font-medium text-gray-300">Buat Kata Sandi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </span>
                    <input type="password" name="password" id="password" placeholder="••••••••" required
                        class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl pl-10 pr-10 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">

                    <!-- Tombol Toggle Mata -->
                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-white focus:outline-none">
                        <!-- Ikon Mata Tertutup (Default) -->
                        <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Pilih Paket Awal -->
            <div class="space-y-1.5">
                <label class="block font-medium text-gray-300">Pilih Paket Awal</label>
                <select name="package"
                    class="w-full bg-[#161e2e] border border-gray-700/80 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 transition">
                    <option value="pro">Pro Tenant — Rp 249rb / bln (Trial 14 Hari)</option>
                    <option value="starter">Starter Tenant — Rp 149rb / bln</option>
                    <option value="enterprise">Enterprise — Rp 499rb / bln</option>
                </select>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl shadow-lg shadow-blue-600/30 transition duration-200 text-sm mt-2 flex items-center justify-center space-x-2">
                <span>Buat Akun Bengkel</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </form>

        <!-- Footer link ke login -->
        <div class="text-center mt-5 text-xs text-gray-400">
            Sudah punya akun? <a href="/login" class="text-blue-400 hover:underline font-medium">Masuk Ke SaaS</a>
        </div>

    </div>

    <!-- Script JavaScript untuk Toggle Lihat/Sembunyikan Sandi -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Ubah ikon menjadi mata terbuka
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            } else {
                passwordInput.type = 'password';
                // Kembalikan ikon menjadi mata tertutup / coret
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            }
        }
    </script>
</body>

</html>