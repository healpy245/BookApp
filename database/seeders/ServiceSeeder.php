<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = Vendor::all();

        $services = [
            [
                'name' => 'Haircut',
                'description' => 'Professional haircut service',
                'price' => 30.00,
                'duration' => 30,
                'status' => 'active',
            ],
            [
                'name' => 'Hair Coloring',
                'description' => 'Full hair coloring service',
                'price' => 80.00,
                'duration' => 120,
                'status' => 'active',
            ],
            [
                'name' => 'Manicure',
                'description' => 'Basic manicure service',
                'price' => 25.00,
                'duration' => 45,
                'status' => 'active',
            ],
            [
                'name' => 'Facial',
                'description' => 'Deep cleansing facial treatment',
                'price' => 60.00,
                'duration' => 60,
                'status' => 'active',
            ],
            [
                'name' => 'Massage',
                'description' => 'Full body massage',
                'price' => 70.00,
                'duration' => 60,
                'status' => 'active',
            ],
        ];

        foreach ($vendors as $vendor) {
            foreach ($services as $service) {
                Service::create([
                    'vendor_id' => $vendor->id,
                    'name' => $service['name'],
                    'description' => $service['description'],
                    'price' => $service['price'],
                    'duration' => $service['duration'],
                    'status' => $service['status'],
                ]);
            }
        }
    }
} 