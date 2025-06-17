<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $services = Service::all();
        $users = User::where('role', 'staff')->get();

        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        $startDate = Carbon::now()->addDays(1);
        
        foreach ($services as $service) {
            // Get staff for this vendor
            $vendorStaff = $users->where('vendor_id', $service->vendor_id);
            if ($vendorStaff->isEmpty()) {
                continue;
            }
            // Create 2-3 bookings for each service
            for ($i = 0; $i < rand(2, 3); $i++) {
                $staff = $vendorStaff->random();
                $bookingDate = $startDate->copy()->addDays(rand(0, 7));
                $startTime = Carbon::createFromTime(9, 0)->addHours(rand(0, 8));
                $endTime = (clone $startTime)->addMinutes($service->duration);

                Booking::create([
                    'user_id' => $staff->id,
                    'service_id' => $service->id,
                    'staff_id' => $staff->id,
                    'booking_date' => $bookingDate,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'total_price' => $service->price,
                    'status' => $statuses[array_rand($statuses)],
                    'notes' => 'Sample booking notes',
                    'client_name' => 'Sample Client',
                    'client_email' => 'client@example.com',
                    'client_phone' => '+1234567890',
                ]);
            }
        }
    }
} 