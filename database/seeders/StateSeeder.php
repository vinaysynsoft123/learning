<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        State::insert([
            [
                'name' => 'Himachal Pradesh',
                'status' => 1
            ],
            [
                'name' => 'Goa',
                'status' => 1
            ],
            [
                'name' => 'Dubai',
                'status' => 1
            ],
        ]);
    }
}
