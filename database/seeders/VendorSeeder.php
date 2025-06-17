<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendorUsers = User::where('role', 'vendor')->get();

        foreach ($vendorUsers as $user) {
            Vendor::create([
                'user_id' => $user->id,
                'company_name' => $user->name . "'s Business",
                'phone' => '+1234567890',
            ]);
        }
    }
} 