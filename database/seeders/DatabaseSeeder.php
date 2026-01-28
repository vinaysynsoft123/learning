<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StateSeeder::class,
            DestinationSeeder::class,
            ThemeSeeder::class,
            PackageSeeder::class,
            HotelCategorySeeder::class,
            VehicleSeeder::class,
        ]);
    }
}
