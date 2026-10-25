<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat akun uji coba untuk Owner (Pemilik Bengkel)
        User::create([
            'name' => 'Pemilik Bengkel',
            'email' => 'owner@bengkel.com',
            'password_hash' => Hash::make('password123'),
            'role' => 'Owner',
            'tenant_id' => 'bengkel1', // Sesuaikan dengan ID tenant yang terdaftar
        ]);

        // Membuat akun uji coba untuk Kasir
        User::create([
            'name' => 'Kasir Toko',
            'email' => 'kasir@bengkel.com',
            'password_hash' => Hash::make('password123'),
            'role' => 'Kasir',
            'tenant_id' => 'bengkel1',
        ]);

        // Membuat akun uji coba untuk Mekanik
        User::create([
            'name' => 'Mekanik Bengkel',
            'email' => 'mekanik@bengkel.com',
            'password_hash' => Hash::make('password123'),
            'role' => 'Mekanik',
            'tenant_id' => 'bengkel1',
        ]);
    }
}