<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom-kolom yang diizinkan untuk diisi (Mass Assignable)
     * Disesuaikan dengan kebutuhan tabel users sistem bengkel (Multi-Tenant & Multi-Role).
     */
    protected $fillable = [
        'name',
        'email',
        'password',       // Cadangan jika ada library bawaan Laravel yang masih memakainya
        'password_hash',  // Sesuai dengan kolom password yang dipakai di AuthController
        'role',           // Peran user: Super Admin, Owner, Kasir, Mekanik, Pelanggan
        'tenant_id',      // Relasi ke tenant (bengkel) tempat user ini terdaftar
    ];

    /**
     * Atribut yang harus disembunyikan saat data user dikonversi ke JSON/Array.
     */
    protected $hidden = [
        'password',
        'password_hash',
        'remember_token',
    ];

    /**
     * Konversi tipe data otomatis (Casts).
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}