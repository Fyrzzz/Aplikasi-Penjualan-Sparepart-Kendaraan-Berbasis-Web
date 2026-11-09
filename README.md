# AMAHAY — Sistem Manajemen Bengkel

AMAHAY adalah aplikasi web untuk membantu bengkel mengelola operasional secara terpisah per tenant. Aplikasi menyediakan akun konsumen, akun utama pemilik bengkel, dashboard operasional bengkel, dan panel Super Admin.

> **Pembaruan dokumentasi:** 9 November 2026
>
> README ini merangkum fitur dan konfigurasi yang tersedia di kode proyek pada tanggal tersebut.

## Fitur

### Konsumen dan akun utama

- Registrasi konsumen menggunakan username, nama, email atau nomor WhatsApp, password, dan konfirmasi password.
- Login berdasarkan username, email, atau nomor WhatsApp serta logout.
- Direktori dan pencarian bengkel yang terdaftar.
- Halaman detail bengkel, promo, riwayat servis, dan pencarian status servis.
- Akun utama dapat mendaftarkan satu tenant bengkel setelah login.

### Operasional tenant bengkel

- Database operasional dipisahkan untuk setiap tenant.
- Dashboard berisi ringkasan berdasarkan data bengkel terkait.
- Halaman antrean servis, kasir/POS, stok sparepart, pelanggan dan mekanik, serta pengingat servis.
- Jam dan tanggal WIB di dashboard diperbarui secara real-time.
- Menu operasional menyediakan navigasi yang dapat digunakan pada layar ponsel.

### Super Admin

- Dashboard global, daftar tenant, laporan keuangan, distribusi paket, dan pengaturan platform.
- Profil Super Admin dapat diperbarui.
- Tenant dapat diaktifkan, dinonaktifkan, diblokir, atau dihapus permanen melalui panel moderasi.
- Ringkasan keuangan dan aktivitas dihitung dari data tenant yang tersedia.
- Estimasi paket bukan catatan pembayaran aktual.
- Uptime server tidak ditampilkan sebagai persentase karena pemantauan uptime belum dikonfigurasi.
- Jam dan tanggal dashboard memakai zona waktu Asia/Jakarta dan diperbarui setiap detik.

## Teknologi

- PHP `^8.3`
- Laravel `^13.17`
- MySQL/MariaDB atau SQLite (sesuaikan konfigurasi database dan tenancy)
- `stancl/tenancy` `^3.10`
- Node.js dan npm
- Vite 8 dan Tailwind CSS 4
- PHPUnit 12

## Persiapan lokal

Pastikan PHP, Composer, Node.js, npm, dan database yang akan digunakan sudah tersedia. Dari PowerShell, jalankan di folder proyek:

```powershell
composer install
Copy-Item .env.example .env
```

Atur `.env` sebelum migrasi. Untuk MySQL, isi setidaknya `APP_NAME`, `APP_URL`, `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`. Buat database pusat terlebih dahulu. Kredensial `.env` bersifat lokal dan **jangan pernah di-commit**.

Kemudian jalankan:

```powershell
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

Buka alamat lokal yang dicetak oleh `php artisan serve` (biasanya `http://127.0.0.1:8000`).

Untuk sistem operasi selain Windows, gunakan `cp .env.example .env` sebagai pengganti `Copy-Item`.

### Tenant dan domain

Tenancy menggunakan database terpisah dan konfigurasi database pusat yang sama. Saat tenant dibuat dari aplikasi, database operasionalnya disiapkan berdasarkan konfigurasi tenancy.

Subdomain pendaftaran saat ini menggunakan akhiran `.autozone.pro`. Agar subdomain bisa diakses di server, siapkan DNS wildcard dan konfigurasi web server/proxy untuk domain tersebut. Untuk domain lain, sesuaikan validasi dan pembuatan domain tenant di aplikasi serta konfigurasi tenancy.

## Pengujian

Jalankan seluruh tes:

```powershell
php artisan test
```

Tes fitur mencakup alur autentikasi dan pendaftaran, isolasi data tenant, layanan konsumen, dan pengelolaan Super Admin.

## Struktur direktori

| Direktori | Isi |
|---|---|
| `app/Http/Controllers` | Controller autentikasi, konsumen, tenant, dan Super Admin |
| `app/Http/Middleware` | Middleware role dan status tenant |
| `app/Services` | Layanan metrik agregat tenant |
| `database/migrations` | Skema database pusat |
| `database/migrations/tenant` | Skema operasional database tenant |
| `resources/views` | Template Blade untuk halaman aplikasi |
| `routes/web.php` | Rute aplikasi web |
| `tests/Feature` | Tes alur dan fitur aplikasi |

## Keamanan dan data

- Jangan unggah `.env`, password, token, dump database, atau data pelanggan ke repository.
- `.env` dan `vendor/` dikecualikan oleh `.gitignore`; tetap periksa `git status` sebelum commit.
- Jangan jalankan seeder pada database berisi data nyata tanpa meninjau isi `database/seeders/DatabaseSeeder.php` terlebih dahulu.
- Pastikan backup database tenant tersedia sebelum melakukan penghapusan permanen tenant.
