<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CustomerProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $vehicles = DB::table('customer_vehicles')
            ->where('user_id', $request->user()->id)
            ->orderBy('id')
            ->get();

        return view('bengkel.edit-profil', compact('vehicles'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $contact = trim((string) $request->input('contact', ''));
        $isEmail = filter_var($contact, FILTER_VALIDATE_EMAIL) !== false;
        $phone = $isEmail ? null : preg_replace('/\D+/', '', $contact);

        $request->merge([
            'contact' => $isEmail ? Str::lower($contact) : $contact,
            'phone' => $phone,
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail) use ($isEmail, $phone, $user): void {
                    if ($isEmail) {
                        if (DB::table('users')->where('email', Str::lower((string) $value))
                            ->where('id', '!=', $user->id)->exists()) {
                            $fail('Email tersebut sudah digunakan.');
                        }

                        return;
                    }

                    if (! preg_match('/\A\+?[\d\s().-]+\z/', (string) $value)
                        || strlen((string) $phone) < 9
                        || strlen((string) $phone) > 15) {
                        $fail('Masukkan email valid atau nomor WhatsApp yang terdiri dari 9 sampai 15 digit.');

                        return;
                    }

                    if (DB::table('users')->where('phone', $phone)
                        ->where('id', '!=', $user->id)->exists()) {
                        $fail('Nomor WhatsApp tersebut sudah digunakan.');
                    }
                },
            ],
            'vehicle_id' => [
                'nullable',
                Rule::exists('customer_vehicles', 'id')->where('user_id', $user->id),
            ],
            'license_plate' => ['nullable', 'required_with:brand,model', 'string', 'max:20'],
            'brand' => ['nullable', 'required_with:license_plate', 'string', 'max:100'],
            'model' => ['nullable', 'required_with:license_plate', 'string', 'max:100'],
            'year' => ['nullable', 'integer', 'between:1900,'.(now()->year + 1)],
            'odometer' => ['nullable', 'integer', 'min:0'],
        ], [
            'vehicle_id.exists' => 'Kendaraan yang dipilih tidak ditemukan.',
            'license_plate.required_with' => 'Nomor plat wajib diisi bersama merek dan model kendaraan.',
            'brand.required_with' => 'Merek kendaraan wajib diisi bersama nomor plat.',
            'model.required_with' => 'Model kendaraan wajib diisi bersama nomor plat.',
        ]);

        DB::transaction(function () use ($validated, $user, $isEmail, $phone): void {
            $user->forceFill([
                'name' => $validated['name'],
                'email' => $isEmail
                    ? Str::lower($validated['contact'])
                    : 'phone-'.$phone.'@accounts.amahay.invalid',
                'phone' => $phone,
            ])->save();

            if (empty($validated['license_plate'])) {
                return;
            }

            $licensePlate = Str::upper($validated['license_plate']);
            $duplicatePlate = DB::table('customer_vehicles')
                ->where('user_id', $user->id)
                ->where('license_plate', $licensePlate)
                ->when(isset($validated['vehicle_id']), fn ($query) => $query->where('id', '!=', $validated['vehicle_id']))
                ->exists();

            if ($duplicatePlate) {
                throw ValidationException::withMessages([
                    'license_plate' => 'Nomor plat tersebut sudah terdaftar pada profil Anda.',
                ]);
            }

            $vehicle = [
                'license_plate' => $licensePlate,
                'brand' => $validated['brand'],
                'model' => $validated['model'],
                'year' => $validated['year'] ?? null,
                'odometer' => $validated['odometer'] ?? 0,
                'updated_at' => now(),
            ];

            if (isset($validated['vehicle_id'])) {
                DB::table('customer_vehicles')
                    ->where('user_id', $user->id)
                    ->where('id', $validated['vehicle_id'])
                    ->update($vehicle);
            } else {
                DB::table('customer_vehicles')->insert([
                    ...$vehicle,
                    'user_id' => $user->id,
                    'created_at' => now(),
                ]);
            }
        });

        return redirect()->route('user.profil.edit')->with('success', 'Profil dan kendaraan berhasil disimpan.');
    }
}
