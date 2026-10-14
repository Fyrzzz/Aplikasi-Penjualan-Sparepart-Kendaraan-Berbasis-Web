<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Models\SparePart;
use App\Http\Controllers\AuthController;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // Halaman utama toko
    Route::get('/', function () {
        return 'Selamat datang di sistem manajemen: ' . tenant('id');
    });

    // Halaman untuk melihat daftar spare part
    Route::get('/spare-parts', function () {

        // Cek jika tabel masih kosong, kita buat 1 data dummy otomatis
        if (SparePart::count() == 0) {
            SparePart::create([
                'sku' => 'BRK-001',
                'name' => 'Kampas Rem Depan',
                'stock' => 15,
                'price' => 45000
            ]);
        }

        // Ambil semua data spare part dari database toko ini
        $spareParts = SparePart::all();

        return response()->json([
            'nama_toko' => tenant('id'),
            'daftar_barang' => $spareParts
        ]);
    });
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

