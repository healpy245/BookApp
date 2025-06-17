<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create vendor users
        $vendor1 = User::create([
            'name' => 'John Vendor',
            'email' => 'vendor1@example.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
        ]);

        $vendor2 = User::create([
            'name' => 'Sarah Vendor',
            'email' => 'vendor2@example.com',
                'password' => Hash::make('password'),
                'role' => 'vendor',
            ]);

        // Create staff users
        User::create([
            'name' => 'Staff One',
            'email' => 'staff1@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'vendor_id' => $vendor1->id,
        ]);

        User::create([
            'name' => 'Staff Two',
            'email' => 'staff2@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'vendor_id' => $vendor1->id,
        ]);

            User::create([
            'name' => 'Staff Three',
            'email' => 'staff3@example.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
            'vendor_id' => $vendor2->id,
            ]);

    }
} 