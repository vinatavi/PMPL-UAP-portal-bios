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
        // 1. Akun Presiden Direktur (Zaka)
        User::create([
            'name' => 'Zaka',
            'email' => 'zaka@bios.com',
            'password' => Hash::make('password123'),
            'role' => 'bpi',
        ]);

        // 2. Akun Staff (Nevi)
        User::create([
            'name' => 'Nevi',
            'email' => 'nevi@bios.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        // 3. Akun BPH / BPI (Viaa)
        User::create([
            'name' => 'Viaa',
            'email' => 'viaa@bios.com',
            'password' => Hash::make('password123'),
            'role' => 'bph',
        ]);

        // 4. Akun Admin (Luna)
        User::create([
            'name' => 'Luna',
            'email' => 'luna@bios.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}