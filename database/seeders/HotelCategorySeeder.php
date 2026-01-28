<?php

namespace Database\Seeders;

use App\Models\HotelCategory;
use Illuminate\Database\Seeder;

class HotelCategorySeeder extends Seeder
{
    public function run(): void
    {
        HotelCategory::insert([
            ['name' => '3 Star', 'status' => 1],
            ['name' => '4 Star', 'status' => 1],
            ['name' => '5 Star', 'status' => 1],
            ['name' => 'Luxury', 'status' => 1],
        ]);
    }
}
