<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SuperAdminProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('superadmin.profile', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/\A[a-z0-9_]+\z/i',
                Rule::unique('users', 'username')->ignore($user->getKey()),
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->getKey()),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/\A\+?[\d\s().-]+\z/',
                Rule::unique('users', 'phone')->ignore($user->getKey()),
            ],
            'current_password' => ['required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'username.regex' => 'Username hanya boleh berisi huruf, angka, dan garis bawah.',
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka dan tanda pemisah yang umum.',
        ]);

        $user->fill([
            'username' => $validated['username'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('superadmin.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
