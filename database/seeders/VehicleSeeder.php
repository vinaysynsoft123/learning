<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        Vehicle::insert([
            ['name' => 'Sedan', 'capacity' => 4, 'price_per_day' => 2500, 'status' => 1],
            ['name' => 'SUV', 'capacity' => 6, 'price_per_day' => 3500, 'status' => 1],
            ['name' => 'Tempo Traveller', 'capacity' => 12, 'price_per_day' => 5500, 'status' => 1],
        ]);
    }
}
