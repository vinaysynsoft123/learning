<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Theme;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $honeymoon = Theme::where('name', 'Honeymoon')->first();
        $family    = Theme::where('name', 'Family')->first();
        $adventure = Theme::where('name', 'Adventure')->first();
        $luxury    = Theme::where('name', 'Luxury')->first();

        Package::insert([
            [
                'theme_id' => $honeymoon->id,
                'name' => 'Honeymoon Special 3N/4D',
              
                'nights' => 3,
                'base_price' => 25000,
                'status' => 1
            ],
            [
                'theme_id' => $family->id,
                'name' => 'Family Fun 4N/5D',
               
                'nights' => 4,
                'base_price' => 32000,
                'status' => 1
            ],
            [
                'theme_id' => $adventure->id,
                'name' => 'Adventure Trip 5N/6D',
             
                'nights' => 5,
                'base_price' => 40000,
                'status' => 1
            ],
            [
                'theme_id' => $luxury->id,
                'name' => 'Dubai Luxury 3N/4D',
                
                'nights' => 3,
                'base_price' => 90000,
                'status' => 1
            ],
        ]);
    }
}
