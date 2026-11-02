<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create the administrator account
        User::updateOrCreate(
            ['email' => 'admin@medicare.com'],
            [
                'name' => 'Hospital Admin',
                'password' => Hash::make('Admin@123'),
                'role' => 'Admin',
            ]
        );

        // Create the first patient account
        User::updateOrCreate(
            ['email' => 'patient1@example.com'],
            [
                'name' => 'Patient One',
                'password' => Hash::make('Patient@123'),
                'role' => 'Patient',
            ]
        );

        // Create the second patient account
        User::updateOrCreate(
            ['email' => 'patient2@example.com'],
            [
                'name' => 'Patient Two',
                'password' => Hash::make('Patient@123'),
                'role' => 'Patient',
            ]
        );
    }
}
