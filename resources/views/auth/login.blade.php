<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kasir / Owner - AMAHAY</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen flex items-center justify-center font-sans">

    <!-- Card Container Login -->
    <div class="bg-[#111827] border border-gray-800 p-10 rounded-3xl shadow-2xl w-full max-w-md">
        
        <!-- Logo & Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center space-x-2.5 mb-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/30">
                    <!-- Icon Wrench / Kunci Pas Bengkel -->
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.9 6.9a2.12 2.12 0 1 1-3-3l6.9-6.9a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                    </svg>
                </div>
                <span class="text-2xl font-bold tracking-wider text-white">AMAHAY</span>
            </div>
            <h2 id="login-title" class="text-lg font-semibold text-white mt-1">Login Kasir / Owner</h2>
            <p id="login-subtitle" class="text-xs text-gray-400 mt-1">Masuk untuk mengelola operasional bengkel Anda</p>
        </div>

        <!-- Tombol Pilihan Peran -->
        <div class="grid grid-cols-2 gap-2 bg-[#1f2937] p-1.5 rounded-xl mb-6 border border-gray-800">
            <button type="button" id="btn-tenant" onclick="switchRole('tenant')" class="py-2.5 text-xs font-medium bg-blue-600 text-white rounded-lg shadow transition">Tenant Bengkel</button>
            <button type="button" id="btn-admin" onclick="switchRole('admin')" class="py-2.5 text-xs font-medium text-gray-400 hover:text-white transition">Super Admin</button>
        </div>

        <!-- Form Login mengarah ke /test-login dengan metode POST -->
        <form action="/test-login" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-medium text-gray-300 mb-1.5">Email</label>
                <input type="email" name="email" placeholder="nama@email.com" required
                    class="w-full bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-300 mb-1.5">Password</label>
                <input type="password" name="password" placeholder="••••••••" required
                    class="w-full bg-[#1f2937] border border-gray-700 rounded-xl px-4 py-3 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 transition">
            </div>

            <div class="flex items-center justify-between text-xs text-gray-400 py-1">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" class="rounded bg-[#1f2937] border-gray-700 text-blue-600 focus:ring-0 w-4 h-4">
                    <span>Ingat saya</span>
                </label>
                <a href="#" class="text-blue-400 hover:underline">Lupa password?</a>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl shadow-lg shadow-blue-600/30 transition duration-200 text-sm">
                Masuk ke Sistem
            </button>
        </form>

        <!-- Footer link yang sudah terhubung ke /register -->
        <div class="text-center mt-6 text-xs text-gray-400">
            Belum punya akun bengkel? <a href="/register" class="text-blue-400 hover:underline font-medium">Daftar Gratis</a>
        </div>

    </div>

    <!-- Script Sederhana untuk Berpindah Peran Login -->
 <script>
        function switchRole(role) {
            const btnTenant = document.getElementById('btn-tenant');
            const btnAdmin = document.getElementById('btn-admin');
            const title = document.getElementById('login-title');
            const subtitle = document.getElementById('login-subtitle');
            const loginForm = document.querySelector('form'); // Mengambil elemen form

            if (role === 'tenant') {
                btnTenant.className = "py-2.5 text-xs font-medium bg-blue-600 text-white rounded-lg shadow transition";
                btnAdmin.className = "py-2.5 text-xs font-medium text-gray-400 hover:text-white transition";
                title.innerText = "Login Kasir / Owner";
                subtitle.innerText = "Masuk untuk mengelola operasional bengkel Anda";
                loginForm.action = "/test-login"; // Mengarah ke rute tenant
            } else {
                btnAdmin.className = "py-2.5 text-xs font-medium bg-blue-600 text-white rounded-lg shadow transition";
                btnTenant.className = "py-2.5 text-xs font-medium text-gray-400 hover:text-white transition";
                title.innerText = "Login Super Admin";
                subtitle.innerText = "Masuk untuk mengelola panel pusat SaaS AMAHAY";
                loginForm.action = "/test-superadmin-login"; // Mengarah ke rute super admin
            }
        }
    </script>

</body>
</html>