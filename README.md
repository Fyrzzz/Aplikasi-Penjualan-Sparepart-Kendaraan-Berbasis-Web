# AMAHAY — Sistem Manajemen Bengkel & Sparepart Multi-Tenant

AMAHAY adalah aplikasi web untuk mengelola operasional bengkel dan toko sparepart dalam arsitektur multi-tenant. Project ini menyiapkan satu platform pusat untuk pelanggan, owner bengkel, dan super admin dengan data operasional yang terpisah per tenant.

> README ini diperbarui sesuai dengan kondisi proyek saat ini.

## Ringkasan proyek

Aplikasi ini terdiri dari beberapa area utama:

- Area publik: landing page, login/register, katalog bengkel, promo, cek servis, dan profil pelanggan.
- Area konsumen: pencarian bengkel, detail bengkel, riwayat servis, serta registrasi kendaraan dan profil pengguna.
- Area owner/tenant: dashboard operasional, antrean kerja, kasir/POS, stok sparepart, mekanik, pelanggan, dan reminder servis.
- Area super admin: dashboard global, moderasi tenant, laporan, distribusi paket, dan pengaturan sistem.

## Fitur utama

### 1. Konsumen dan autentikasi

- Registrasi pengguna menggunakan username, nama, email atau nomor WhatsApp, password, dan konfirmasi password.
- Login berbasis username, email, atau nomor WhatsApp.
- Logout dan reset password berbasis token.
- Direktori bengkel yang bisa dicari berdasarkan nama atau domain.
- Halaman detail bengkel dan riwayat servis pelanggan.
- Akun utama dapat membuat tenant bengkel setelah login.

### 2. Operasional tenant bengkel

- Setiap tenant menggunakan database operasional yang terpisah.
- Dashboard ringkasan berdasarkan data tenant terkait.
- Antrean servis dan status pekerjaan.
- Kasir/POS untuk transaksi tunai dan pembayaran non-tunai.
- Manajemen stok sparepart dan level minimal stok.
- Data pelanggan dan mekanik.
- Reminder servis dengan periode jatuh tempo.
- Navigasi operasional yang ramah untuk layar ponsel.

### 3. Pembayaran dan QRIS sandbox

- Kasir mendukung pembayaran tunai dan transfer bank manual (BCA, BNI, BRI, Mandiri, BSI).
- Integrasi QRIS sandbox untuk simulasi pembayaran dinamis dengan tagihan 15 menit.
- Status pembayaran dapat dimodelkan melalui simulator yang aman untuk pengujian.
- Fitur QRIS dirancang untuk lingkungan pengujian dan bukan untuk menerima uang sungguhan.
- Sandbox aktif secara default di lingkungan non-production, sedangkan production biasanya memerlukan konfigurasi eksplisit serta variabel seperti `QRIS_FAKE_ENABLED` sesuai kebutuhan.

### 4. Super Admin

- Dashboard global dan laporan data tenant.
- Manajemen tenant: aktif, non-aktif, diblokir, atau dihapus.
- Ringkasan keuangan dan aktivitas berdasarkan tenant yang tersedia.
- Distribusi paket dan pengaturan platform.
- Profil super admin dapat diperbarui.
- Estimasi paket bersifat metrik platform, bukan catatan pembayaran sebenarnya.

## Teknologi yang digunakan

- PHP `^8.3`
- Laravel `^13.17`
- `stancl/tenancy` `^3.10`
- MySQL/MariaDB atau SQLite sesuai konfigurasi local dan tenant
- Node.js + npm
- Vite `^8`
- Tailwind CSS `^4`
- PHPUnit `^12`
- `bacon/bacon-qr-code` untuk alur QRIS

## Persiapan local

Pastikan PHP, Composer, Node.js, npm, dan database yang akan dipakai sudah tersedia. Kemudian jalankan perintah berikut dari root proyek:

### Windows PowerShell

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

### Linux/macOS

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

Setelah `php artisan serve` berjalan, buka URL yang ditampilkan, biasanya:

```text
http://127.0.0.1:8000
```

### Konfigurasi `.env`

Sebelum migrasi, sesuaikan nilai di `.env` sesuai lingkungan Anda. Minimal untuk database local, biasanya diperlukan:

```env
APP_NAME=AMAHAY
APP_ENV=local
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=sqlite
DB_DATABASE=/path/to/project/database/database.sqlite
```

Untuk setup MySQL, gunakan konfigurasi database seperti `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai server Anda.

> `.env` bersifat lokal dan jangan pernah di-commit ke repository.

## Multi-tenant dan domain

Project ini menggunakan struktur multi-tenant dengan database pusat dan database operasional per tenant. Saat tenant dibuat dari aplikasi, database tenant akan dipersiapkan otomatis berdasarkan konfigurasi tenancy.

Subdomain pendaftaran saat ini menggunakan akhiran `.autozone.pro`. Untuk environment server, pastikan wildcard DNS dan konfigurasi reverse proxy/web server sudah siap agar subdomain tenant bisa diakses. Jika memakai domain lain, sesuaikan validasi pembuatan domain tenant di codebase dan konfigurasi tenancy-nya.

## Struktur direktori utama

| Direktori | Keterangan |
| --- | --- |
| `app/Http/Controllers` | Controller login, customer, tenant, owner, dan super admin |
| `app/Http/Middleware` | Middleware autentikasi dan validasi role/status tenant |
| `app/Services` | Layanan metrik tenant dan gateway pembayaran QRIS |
| `database/migrations` | Skema database pusat |
| `database/migrations/tenant` | Skema database operasional per tenant |
| `resources/views` | Blade template untuk landing page, dashboard, dan modul aplikasi |
| `routes/web.php` | Rute aplikasi web |
| `tests/Feature` | Test end-to-end untuk alur fungsional |

## Pengujian

Untuk menjalankan seluruh test yang tersedia:

```bash
php artisan test
```

Tes yang ada mencakup autentikasi, registrasi, isolasi data tenant, pengelolaan super admin, dan simulasi pembayaran QRIS sandbox.

## Catatan penting

- Jangan mengunggah `.env`, token, dump database, atau data pelanggan ke repository.
- Pastikan `git status` selalu dicek sebelum commit.
- Hindari menjalankan seeder pada database yang berisi data nyata tanpa mengecek dulu isi `database/seeders/DatabaseSeeder.php`.
- Sebelum menghapus tenant permanen, pastikan backup database tenant tersedia.
- QRIS sandbox cocok untuk testing, bukan untuk transaksi nyata.

## Status proyek

Proyek ini sudah mencakup fitur inti bisnis untuk platform bengkel dan sparepart berbasis tenant, termasuk operasional bengkel, customer portal, dan panel pengelola platform. Pengembangan selanjutnya dapat ditambah sesuai kebutuhan bisnis dan integrasi gateway pembayaran produksi.
