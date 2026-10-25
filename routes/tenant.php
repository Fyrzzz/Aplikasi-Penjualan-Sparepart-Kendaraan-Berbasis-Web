<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    // InitializeTenancyByDomain::class,
    // PreventAccessFromCentralDomains::class,
])->group(function () {

    // ==========================================
    // 1. PUBLIC & LANDING PAGE
    // ==========================================
    Route::get('/', function () {
        return view('landing-bengkel');
    })->name('home');

    Route::get('/user-menu', function () {
        return view('user-menu');
    })->name('user.menu');


    // ==========================================
    // 2. AUTHENTICATION (TESTING)
    // ==========================================
    Route::get('/test-login', function () {
        return view('auth.login');
    });

    Route::match(['get', 'post'], '/test-superadmin-login', function () {
        return view('superadmin.dashboardsuperadmin');
    });


    // ==========================================
    // 3. TENANT BENGKEL ROUTES
    // ==========================================
    Route::match(['get', 'post'], '/test-dashboard', function () {
        return view('dashboard');
    });


    // ==========================================
    // 4. SUPER ADMIN ROUTES (4 FITUR UTAMA)
    // ==========================================
    Route::get('/test-superadmin-tenant', function () {
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

});