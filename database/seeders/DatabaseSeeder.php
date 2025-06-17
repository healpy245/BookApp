<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('bookings')->truncate();
        DB::table('service_staff')->truncate();
        DB::table('services')->truncate();
        DB::table('vendors')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            UserSeeder::class,
            VendorSeeder::class,
            ServiceSeeder::class,
            ServiceStaffSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
