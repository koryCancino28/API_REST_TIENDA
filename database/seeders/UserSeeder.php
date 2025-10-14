<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('secret'), // contraseña: secret
                'email_verified_at' => now(),
            ]
        );
    }
}
