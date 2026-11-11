<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\OwnerOperationsController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SuperAdminProfileController;
use App\Http\Controllers\TenantDirectoryController;
use App\Http\Controllers\TenantModerationController;
use App\Http\Controllers\TenantRegistrationController;
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
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::get('/register/konsumen', [AuthController::class, 'showCustomerRegistrationForm'])->name('register.customer');

// Login tenant hanya tersedia setelah masuk ke akun utama.
Route::middleware(['auth', 'role:Pelanggan,Owner'])->group(function () {
    Route::get('/tenant/login', [AuthController::class, 'showTenantLoginForm'])->name('tenant.login');
    Route::post('/tenant/login', [AuthController::class, 'loginTenant'])->name('tenant.login.proses');
});

Route::get('/superadmin/login', [AuthController::class, 'showAdminLoginForm'])->name('superadmin.login');

Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendLink'])
        ->middleware('throttle:6,1')
        ->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])
        ->middleware('throttle:6,1')
        ->name('password.update');
});

Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/register', [AuthController::class, 'registerCustomer'])->name('register.proses');
Route::post('/register/konsumen', [AuthController::class, 'registerCustomer'])->name('register.customer.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/create', [TenantRegistrationController::class, 'create'])->name('create');
    Route::post('/create', [TenantRegistrationController::class, 'store'])->name('store');
});

/*
|--------------------------------------------------------------------------
| AREA KONSUMEN / PENGGUNA BENGKEL
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Pelanggan,Owner'])->prefix('user-menu')->name('user.')->group(function () {

    // Halaman Menu Utama Konsumen
    Route::get('/', [TenantDirectoryController::class, 'consumerIndex'])->name('menu');

    // Halaman Detail Bengkel
    Route::get('/bengkel/{id}', [CustomerBookingController::class, 'show'])->name('bengkel.detail');
    Route::post('/bengkel/{id}/booking', [CustomerBookingController::class, 'store'])->name('bengkel.booking');

    // Halaman Cek Servis
    Route::get('/cek-servis', [CustomerServiceController::class, 'status'])->name('cek.servis');

    // Halaman Promo
    Route::get('/promo', function () {
        return view('bengkel.promo');
    })->name('promo');

    // Halaman Profil & Motor
    Route::get('/riwayat', [CustomerServiceController::class, 'history'])->name('riwayat');

    // Halaman Edit Profil & Motor
    Route::get('/profil/edit', [CustomerProfileController::class, 'edit'])->name('profil.edit');
    Route::patch('/profil/edit', [CustomerProfileController::class, 'update'])->name('profil.update');

});

/*
|--------------------------------------------------------------------------
| AREA OWNER BENGKEL (TENANT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Owner,Kasir,Mekanik', 'tenant.active'])->prefix('owner')->name('owner.')->group(function () {

    Route::get('/dashboard', OwnerDashboardController::class)->name('home');

    Route::get('/antrean', [OwnerOperationsController::class, 'queue'])->name('antrean');

    Route::get('/kasir', [OwnerOperationsController::class, 'pos'])->name('kasir');

    Route::get('/stok', [OwnerOperationsController::class, 'stock'])->name('stok');

    Route::get('/mekanik', [OwnerOperationsController::class, 'people'])->name('mekanik');

    Route::get('/pengingat', [OwnerOperationsController::class, 'reminders'])->name('pengingat');

    Route::post('/stok', [OwnerOperationsController::class, 'storePart'])
        ->middleware('role:Owner')
        ->name('stok.store');
    Route::post('/kasir/checkout', [OwnerOperationsController::class, 'checkout'])
        ->middleware('role:Owner,Kasir')
        ->name('kasir.checkout');
    Route::post('/mekanik', [OwnerOperationsController::class, 'storeEmployee'])
        ->middleware('role:Owner')
        ->name('mekanik.store');
    Route::post('/pengingat', [OwnerOperationsController::class, 'storeReminder'])
        ->middleware('role:Owner')
        ->name('pengingat.store');
    Route::patch('/stok/{part}', [OwnerOperationsController::class, 'adjustPartStock'])
        ->middleware('role:Owner')
        ->whereNumber('part')
        ->name('stok.adjust');
    Route::patch('/antrean/{workOrder}/status', [OwnerOperationsController::class, 'updateWorkOrderStatus'])
        ->middleware('role:Owner,Mekanik')
        ->whereNumber('workOrder')
        ->name('antrean.status');

});

/*
|--------------------------------------------------------------------------
| AREA SUPER ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Super Admin'])->prefix('superadmin')->name('superadmin.')->group(function () {

    // Halaman Utama / Dashboard Superadmin (Diarahkan ke dashboard-global)
    Route::get('/dashboard', [TenantDirectoryController::class, 'adminDashboard'])->name('home');

    // Manajemen Tenant / Bengkel (Diarahkan ke dashboardsuperadmin)
    Route::get('/tenant', [TenantDirectoryController::class, 'adminIndex'])->name('tenant');
    Route::patch('/tenant/{tenant}/status', [TenantModerationController::class, 'updateStatus'])->name('tenant.status');
    Route::delete('/tenant/{tenant}', [TenantModerationController::class, 'destroy'])->name('tenant.destroy');

    Route::get('/profil', [SuperAdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [SuperAdminProfileController::class, 'update'])->name('profile.update');

    // Laporan Global
    Route::get('/laporan', [TenantDirectoryController::class, 'adminReport'])->name('laporan');

    // Manajemen Paket
    Route::get('/paket', [TenantDirectoryController::class, 'adminPackages'])->name('paket');

    // Pengaturan Sistem
    Route::get('/pengaturan', function () {
        return view('superadmin.pengaturan');
    })->name('pengaturan');

});
