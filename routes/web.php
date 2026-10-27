<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AREA PUBLIK & AUTENTIKASI
|--------------------------------------------------------------------------
*/

// Landing Page Publik
Route::get('/', function () {
    return view('bengkel.landing-bengkel');
})->name('home');

// Halaman Login & Register Publik
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Rute Bawaan Tenant/Superadmin (Diarahkan ke login utama)
Route::get('/tenant/login', function () {
    return view('auth.login'); 
})->name('tenant.login');

Route::get('/superadmin/login', function () {
    return view('auth.login'); 
})->name('superadmin.login');

// Proses Login Pintar (Mendeteksi 3 Peran Berdasarkan Email)
Route::post('/login', function (\Illuminate\Http\Request $request) {
    $email = strtolower($request->input('email')); // Ubah ke huruf kecil agar aman

    // 1. Cek Superadmin
    if ($email === 'soutakitagawa307@gmail.com' || str_contains($email, 'admin')) {
        return redirect()->route('superadmin.home');
    }

    // 2. Cek Owner / Tenant Bengkel
    if (str_contains($email, 'owner') || str_contains($email, 'bengkel') || str_contains($email, 'tenant') || str_contains($email, 'kasir')) {
        return redirect()->route('owner.home');
    }

    // 3. Konsumen Umum / User (Jika tidak ada kata admin/owner/bengkel/tenant/kasir)
    return redirect()->route('user.menu');
})->name('login.proses');


/*
|--------------------------------------------------------------------------
| AREA KONSUMEN / PENGGUNA BENGKEL
|--------------------------------------------------------------------------
*/
Route::prefix('user-menu')->name('user.')->group(function () {
    
    // Halaman Menu Utama Konsumen
    Route::get('/', function () {
        return view('bengkel.user-menu');
    })->name('menu');

    // Halaman Detail Bengkel
    Route::get('/bengkel/{id}', function ($id) {
        return view('bengkel.detail', ['bengkel_id' => $id]);
    })->name('bengkel.detail');

    // Halaman Cek Servis
    Route::get('/cek-servis', function () {
        return view('bengkel.cek-servis');
    })->name('cek.servis');

    // Halaman Promo
    Route::get('/promo', function () {
        return view('bengkel.promo');
    })->name('promo');

    // Halaman Profil & Motor
    Route::get('/riwayat', function () {
        return view('bengkel.riwayat');
    })->name('riwayat');

    // Halaman Edit Profil & Motor
    Route::get('/profil/edit', function () {
        return view('bengkel.edit-profil');
    })->name('profil.edit');

});


/*
|--------------------------------------------------------------------------
| AREA OWNER BENGKEL (TENANT)
|--------------------------------------------------------------------------
*/
Route::prefix('owner')->name('owner.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('tenant.dashboard');
    })->name('home');

    Route::get('/antrean', function () {
        return view('tenant.antrean');
    })->name('antrean');

    Route::get('/kasir', function () {
        return view('tenant.kasir');
    })->name('kasir');

    Route::get('/stok', function () {
        return view('tenant.stok');
    })->name('stok');

    Route::get('/mekanik', function () {
        return view('tenant.mekanik');
    })->name('mekanik');

    Route::get('/pengingat', function () {
        return view('tenant.pengingat');
    })->name('pengingat');

});


/*
|--------------------------------------------------------------------------
| AREA SUPER ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('superadmin')->name('superadmin.')->group(function () {

    // Halaman Utama / Dashboard Superadmin (Diarahkan ke dashboard-global)
    Route::get('/dashboard', function () {
        return view('superadmin.dashboard-global');
    })->name('home');

    // Manajemen Tenant / Bengkel (Diarahkan ke dashboardsuperadmin)
    Route::get('/tenant', function () {
        return view('superadmin.dashboardsuperadmin');
    })->name('tenant');

    // Laporan Global
    Route::get('/laporan', function () {
        return view('superadmin.laporan');
    })->name('laporan');

    // Manajemen Paket
    Route::get('/paket', function () {
        return view('superadmin.paket');
    })->name('paket');

    // Pengaturan Sistem
    Route::get('/pengaturan', function () {
        return view('superadmin.pengaturan');
    })->name('pengaturan');

});