<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm() {
        return view('auth.login'); // Sesuaikan dengan file view/mockup Figma kalian
    }

    // Memproses data login
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek apakah user ada dan password-nya cocok (Bcrypt)
        if ($user && Hash::check($request->password, $user->password_hash)) {
            // Simpan session login sesuai kebutuhan
            // Auth::login($user);

            // Arahkan berdasarkan role 
            if ($user->role == 'Owner') {
                return redirect()->route('dashboard.owner');
            } elseif ($user->role == 'Kasir') {
                return redirect()->route('dashboard.kasir');
            } elseif ($user->role == 'Mekanik') {
                return redirect()->route('dashboard.mekanik');
            }
            
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }
}