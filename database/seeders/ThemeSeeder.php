<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\Destination;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $shimla = Destination::where('name', 'Shimla')->first();
        $manali = Destination::where('name', 'Manali')->first();
        $goa    = Destination::where('name', 'North Goa')->first();
        $dubai  = Destination::where('name', 'Dubai Marina')->first();

        Theme::insert([
            // Shimla / Manali
            ['destination_id' => $shimla->id, 'name' => 'Honeymoon', 'status' => 1],
            ['destination_id' => $shimla->id, 'name' => 'Family', 'status' => 1],

            ['destination_id' => $manali->id, 'name' => 'Adventure', 'status' => 1],
            ['destination_id' => $manali->id, 'name' => 'Couple', 'status' => 1],

            // Goa
            ['destination_id' => $goa->id, 'name' => 'Beach Party', 'status' => 1],
            ['destination_id' => $goa->id, 'name' => 'Relax', 'status' => 1],

            // Dubai
            ['destination_id' => $dubai->id, 'name' => 'Luxury', 'status' => 1],
            ['destination_id' => $dubai->id, 'name' => 'Shopping', 'status' => 1],
        ]);
    }
}
