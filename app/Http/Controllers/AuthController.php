<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLoginForm()
    {
        // Pastikan file view/tampilan login sudah dibuat di resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Memproses data saat tombol login ditekan
     */
    public function login(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 2. Cari data user berdasarkan email di database
        $user = User::where('email', $request->email)->first();

        // 3. Cek apakah user ditemukan dan password-nya cocok (menggunakan Bcrypt hash sesuai SRS)
        if ($user && Hash::check($request->password, $user->password_hash)) {
            
            // Simpan data user ke dalam session aktif Laravel
            // (Menggunakan auth bawaan atau menyimpan manual ke session tenant)
            session([
                'user_id' => $user->user_id,
                'email' => $user->email,
                'role' => $user->role,
                'tenant_id' => $user->tenant_id,
            ]);

            // 4. Arahkan (redirect) berdasarkan role masing-masing pengguna
            switch ($user->role) {
                case 'Super Admin':
                    return redirect()->route('superadmin.dashboard');
                case 'Owner':
                    return redirect()->route('owner.dashboard');
                case 'Kasir':
                    return redirect()->route('kasir.pos');
                case 'Mekanik':
                    return redirect()->route('mekanik.workorder');
                case 'Pelanggan':
                    return redirect()->route('customer.portal');
                default:
                    return redirect('/')->with('success', 'Berhasil login!');
            }
        }

        // 5. Jika gagal (email/password salah), kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->withInput();
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        // Hapus session
        $request->session()->flush();
        
        return redirect()->route('login')->with('success', 'Anda telah keluar.');
    }
}