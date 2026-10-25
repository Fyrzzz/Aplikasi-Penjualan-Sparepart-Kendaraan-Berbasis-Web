<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

// Landing Page Publik
Route::get('/', function () {
    return view('landing-bengkel');
})->name('home');

// Login Publik
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
});

// Halaman User Menu / Cari Bengkel untuk Konsumen Publik
Route::get('/user-menu', function () {
    return view('user-menu');
})->name('user.menu');


/*
|--------------------------------------------------------------------------
| TENANT
|--------------------------------------------------------------------------
*/

// Login Tenant
Route::get('/tenant/login', function () {
    return view('auth.login');
})->name('tenant.login');


/*
|--------------------------------------------------------------------------
| SUPERADMIN
|--------------------------------------------------------------------------
*/

// Login Superadmin
Route::get('/superadmin/login', function () {
    return view('auth.login');
})->name('superadmin.login');


/*
|--------------------------------------------------------------------------
| TESTING
|--------------------------------------------------------------------------
*/

Route::match(['get', 'post'], '/test-login', function () {
    if (request()->isMethod('post')) {
        return view('dashboard');
    }

    return view('auth.login');
});

Route::get('/test-dashboard', function () {
    return view('dashboard');
});


// Tenant
Route::get('/test-antrean', function () {
    return view('tenant.antrean');
});

Route::get('/test-kasir', function () {
    return view('tenant.kasir');
});

Route::get('/test-stok', function () {
    return view('tenant.stok');
});

Route::get('/test-mekanik', function () {
    return view('tenant.mekanik');
});

Route::get('/test-pengingat', function () {
    return view('tenant.pengingat');
});


// Superadmin (Disinkronkan ke view dashboardsuperadmin)
Route::get('/test-superadmin-dashboard', function () {
    return view('superadmin.dashboard-global');
});

Route::get('/test-superadmin', function () {
    return view('superadmin.dashboardsuperadmin');
});

Route::get('/test-superadmin-laporan', function () {
    return view('superadmin.laporan');
});

Route::get('/test-superadmin-paket', function () {
    return view('superadmin.paket');
});

Route::get('/test-superadmin-pengaturan', function () {
    return view('superadmin.pengaturan');
});