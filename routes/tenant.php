<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| TENANT ROUTES (Khusus untuk masing-masing Bengkel)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class, // Pelindung tenant sudah diaktifkan kembali
])->group(function () {

    // ==========================================
    // AREA MANAJEMEN INTERNAL BENGKEL
    // ==========================================

    // Dashboard Admin Bengkel (Pemilik Bengkel)
    Route::get('/dashboard-bengkel', function () {
        return view('tenant.dashboard');
    })->name('tenant.dashboard');
    
    // Manajemen Antrean Kendaraan
    Route::get('/antrean', function () {
        return view('tenant.antrean');
    })->name('tenant.antrean');

    // Kasir & Pembayaran
    Route::get('/kasir', function () {
        return view('tenant.kasir');
    })->name('tenant.kasir');

    // Manajemen Stok / Sparepart
    Route::get('/stok', function () {
        return view('tenant.stok');
    })->name('tenant.stok');

    // Manajemen Mekanik
    Route::get('/mekanik', function () {
        return view('tenant.mekanik');
    })->name('tenant.mekanik');

    // Pengingat Servis
    Route::get('/pengingat', function () {
        return view('tenant.pengingat');
    })->name('tenant.pengingat');

});