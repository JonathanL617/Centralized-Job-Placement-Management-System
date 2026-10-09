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
        User::firstOrCreate(
            ['email' => 'student@test.com'],
            [
                'name' => 'Student User',
                'password' => Hash::make('password'),
                'role' => 'student'
            ]
        );

        User::firstOrCreate(
            ['email' => 'employer@test.com'],
            [
                'name' => 'Employer User',
                'password' => Hash::make('password'),
                'role' => 'employer'
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );
    }
}
