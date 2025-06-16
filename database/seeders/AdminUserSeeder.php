<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@demo.com'], // unique constraint
            [
                'name' => 'Admin',
                'email' => 'admin@demo.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // change this to something secure
                'role' => 'admin', // assuming you use a 'role' column
            ]
        );
    }
}