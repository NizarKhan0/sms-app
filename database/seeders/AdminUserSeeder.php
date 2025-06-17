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
            ['email' => 'superadmin@demo.com'], // unique constraint
            [
                'name' => 'Nizar',
                'email' => 'superadmin@demo.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // change this to something secure
                'role' => 'super-admin', // assuming you use a 'role' column
            ]
        );

        User::updateOrCreate(
            ['email' => 'azmeer@excelgenius.com.my'], // unique constraint
            [
                'name' => 'Azmeer',
                'email' => 'azmeer@excelgenius.com.my',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'), // change this to something secure
                'role' => 'admin', // assuming you use a 'role' column
            ]
        );

        $names = ['Nadia', 'Aidee', 'Nurul', 'Kye', 'Zuyya', 'Izni'];

        foreach ($names as $name) {
            $email = strtolower($name) . '@excelgenius.com.my';

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'email' => $email,
                    'email_verified_at' => now(),
                    'password' => Hash::make('12345678'), // change this to something secure
                    'role' => 'teacher',
                ]
            );
        }
    }
}
