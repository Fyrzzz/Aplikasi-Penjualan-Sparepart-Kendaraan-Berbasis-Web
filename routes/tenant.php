<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\OwnerOperationsController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| TENANT ROUTES (Khusus untuk masing-masing Bengkel)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',
    'auth',
    'role:Owner,Kasir,Mekanik',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class, // Pelindung tenant sudah diaktifkan kembali
])->group(function () {

    // ==========================================
    // AREA MANAJEMEN INTERNAL BENGKEL
    // ==========================================

    // Dashboard Admin Bengkel (Pemilik Bengkel)
    Route::get('/dashboard-bengkel', OwnerDashboardController::class)->name('tenant.dashboard');

    // Manajemen Antrean Kendaraan
    Route::get('/antrean', [OwnerOperationsController::class, 'queue'])->name('tenant.antrean');

    // Kasir & Pembayaran
    Route::get('/kasir', [OwnerOperationsController::class, 'pos'])->name('tenant.kasir');

    // Manajemen Stok / Sparepart
    Route::get('/stok', [OwnerOperationsController::class, 'stock'])->name('tenant.stok');

    // Manajemen Mekanik
    Route::get('/mekanik', [OwnerOperationsController::class, 'people'])->name('tenant.mekanik');

    // Pengingat Servis
    Route::get('/pengingat', [OwnerOperationsController::class, 'reminders'])->name('tenant.pengingat');

});
