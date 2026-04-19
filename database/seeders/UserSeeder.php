<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'hawraz@gmail.com'],
            [
                'name' => 'hawraz',
                'username' => 'hawraz',
                'phone' => '+9647700000000',
                'password' => Hash::make('19931993'),
                'email_verified_at' => now(),
            ]
        );
    }
}
