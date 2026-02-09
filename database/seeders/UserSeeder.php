<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::updateOrCreate(
            ['email' => 'admin@system.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // PETUGAS
        User::updateOrCreate(
            ['email' => 'petugas@system.test'],
            [
                'name' => 'Petugas',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
            ]
        );
    }
}
