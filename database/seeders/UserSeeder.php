<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@hireflix.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create reviewer user
        User::firstOrCreate(
            ['email' => 'reviewer@hireflix.com'],
            [
                'name' => 'Reviewer User',
                'password' => Hash::make('password'),
                'role' => 'reviewer',
            ]
        );

        // Create candidate user
        User::firstOrCreate(
            ['email' => 'candidate@hireflix.com'],
            [
                'name' => 'Candidate User',
                'password' => Hash::make('password'),
                'role' => 'candidate',
            ]
        );

        // Create additional test users
        User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'role' => 'candidate',
            ]
        );

        User::firstOrCreate(
            ['email' => 'jane@example.com'],
            [
                'name' => 'Jane Smith',
                'password' => Hash::make('password'),
                'role' => 'candidate',
            ]
        );
    }
}
