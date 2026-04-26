<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Membuat Akun Admin
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@mail.com',
            'password' => Hash::make('password123'), // Ganti dengan password yang aman
            'role'     => 'admin',
        ]);

        // Membuat Akun User Biasa
        User::create([
            'name'     => 'Regular User',
            'email'    => 'user@mail.com',
            'password' => Hash::make('password123'),
            'role'     => 'user',
        ]);
    }
}