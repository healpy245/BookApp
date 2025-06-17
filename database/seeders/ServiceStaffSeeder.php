<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceStaffSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::all();
        $staffMembers = User::where('role', 'staff')->get();

        foreach ($services as $service) {
            // Get staff members for this vendor
            $vendorStaff = $staffMembers->where('vendor_id', $service->vendor_id);
            
            if ($vendorStaff->isNotEmpty()) {
                // Assign 1-2 random staff members to each service
                $randomStaff = $vendorStaff->random(min(rand(1, 2), $vendorStaff->count()));
                
                foreach ($randomStaff as $staff) {
                    $service->staff()->attach($staff->id);
                }
            }
        }
    }
} 