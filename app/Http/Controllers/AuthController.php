<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login', ['loginRole' => 'user']);
    }

    public function showTenantLoginForm(Request $request): View
    {
        abort_unless(in_array($request->user()->role, ['Pelanggan', 'Owner'], true), 403);

        return view('auth.login', ['loginRole' => 'tenant']);
    }

    public function showAdminLoginForm(): View
    {
        return view('auth.login', ['loginRole' => 'admin']);
    }

    public function showRegistrationForm(): View
    {
        return view('auth.register-customer');
    }

    public function showCustomerRegistrationForm(): View
    {
        return view('auth.register-customer');
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in(['user', 'admin'])],
        ], [
            'role.in' => 'Jenis akun tidak sesuai.',
        ]);

        return $this->loginForRole($request, $validated['role']);
    }

    public function loginTenant(Request $request): RedirectResponse
    {
        return $this->loginForRole($request, 'tenant');
    }

    private function loginForRole(Request $request, string $loginRole): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email atau nomor WhatsApp wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $identifier = trim($validated['email']);
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', Str::lower($identifier))->first();
        } elseif (preg_match('/\A[\d\s()+-]+\z/', $identifier)) {
            $user = User::where('phone', preg_replace('/\D+/', '', $identifier))->first()
                ?? User::where('username', Str::lower($identifier))->first();
        } else {
            $user = User::where('username', Str::lower($identifier))->first();
        }

        $roleMatches = $user !== null && match ($loginRole) {
            'admin' => $user->role === 'Super Admin',
            'tenant' => in_array($user->role, ['Owner', 'Kasir', 'Mekanik'], true)
                && $user->tenant_id !== null
                && Tenant::query()->find($user->tenant_id)?->isActive() === true,
            'user' => in_array($user->role, ['Pelanggan', 'Owner'], true),
        };

        if (! $user || ! Hash::check($validated['password'], $user->password) || ! $roleMatches) {
            return back()->withErrors([
                'email' => 'Email/nomor WhatsApp, password, atau jenis akun tidak sesuai.',
            ])->withInput($request->only('email', 'role'));
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return match ($loginRole) {
            'admin' => redirect()->route('superadmin.home'),
            'tenant' => match ($user->role) {
                'Owner' => redirect()->route('owner.home'),
                'Kasir' => redirect()->route('owner.kasir'),
                default => redirect()->route('owner.mekanik'),
            },
            default => redirect()->route('user.menu'),
        };
    }

    public function registerCustomer(Request $request): RedirectResponse
    {
        $identifier = trim((string) $request->input('contact', ''));
        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL) !== false;
        $username = Str::lower(trim((string) $request->input('username', '')));
        $request->merge([
            'username' => $username,
            'contact' => $isEmail ? Str::lower($identifier) : $identifier,
        ]);

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/\A[a-z0-9_]+\z/',
                Rule::unique('users', 'username'),
            ],
            'name' => ['required', 'string', 'max:255'],
            'contact' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, Closure $fail): void {
                    $contact = trim((string) $value);

                    if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
                        if (User::where('email', Str::lower($contact))->exists()) {
                            $fail('Email tersebut sudah terdaftar.');
                        }

                        return;
                    }

                    if (! preg_match('/\A\+?[\d\s().-]+\z/', $contact)) {
                        $fail('Masukkan email valid atau nomor WhatsApp yang terdiri dari 9 sampai 15 digit.');

                        return;
                    }

                    $phone = preg_replace('/\D+/', '', $contact);

                    if (strlen($phone) < 9 || strlen($phone) > 15) {
                        $fail('Nomor WhatsApp harus berisi 9 sampai 15 digit.');

                        return;
                    }

                    if (User::where('phone', $phone)->exists()) {
                        $fail('Nomor WhatsApp tersebut sudah terdaftar.');
                    }
                },
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'username.regex' => 'Username hanya boleh berisi huruf, angka, dan garis bawah.',
            'username.unique' => 'Username tersebut sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $phone = $isEmail ? null : preg_replace('/\D+/', '', $validated['contact']);
        $email = $isEmail
            ? $validated['contact']
            : 'phone-'.$phone.'@accounts.amahay.invalid';

        $user = User::create([
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $email,
            'phone' => $phone,
            'password' => $validated['password'],
            'role' => 'Pelanggan',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.menu');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar.');
    }
}
