<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil & Motor - AMAHAY</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-gray-200 min-h-screen font-sans flex flex-col justify-between">

    <div class="max-w-xl mx-auto px-6 py-12 w-full">
        <!-- Tombol Kembali -->
        <a href="{{ route('user.menu') }}" class="text-xs bg-[#161e2e] border border-gray-800 px-3 py-1.5 rounded-lg text-gray-400 hover:text-white transition inline-block mb-6">
            ← Kembali ke Menu Utama
        </a>

        <!-- Card Form Edit -->
        <div class="bg-[#111827] border border-gray-800/80 rounded-2xl p-8 shadow-xl space-y-6">
            <div>
                <h1 class="text-lg font-bold text-white">Pengaturan Profil & Kendaraan</h1>
                <p class="text-xs text-gray-400 mt-0.5">Perbarui informasi akun konsumen dan data motor kesayangan Anda.</p>
            </div>

            <form action="{{ route('user.menu') }}" method="GET" class="space-y-4 text-xs">
                <div>
                    <label class="block text-gray-400 mb-1.5">Nama Lengkap</label>
                    <input type="text" value="Panda" class="w-full bg-[#161e2e] border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-400 mb-1.5">Alamat Email</label>
                    <input type="email" value="panda@gmail.com" class="w-full bg-[#161e2e] border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-400 mb-1.5">Nomor Plat Kendaraan Utama</label>
                    <input type="text" value="L 4567 XY (Honda BeAT 2022)" class="w-full bg-[#161e2e] border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500">
                </div>

                <div class="pt-4 border-t border-gray-800 flex justify-end space-x-3">
                    <a href="{{ route('user.menu') }}" class="px-5 py-2.5 rounded-xl bg-gray-800 text-gray-300 hover:bg-gray-700 transition">Batal</a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition shadow-lg shadow-blue-600/30">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="border-t border-gray-800/80 py-4 px-6 text-center text-[11px] text-gray-500 max-w-xl mx-auto w-full">
        <span>© AMAHAY 2026</span>
    </footer>

</body>
</html>