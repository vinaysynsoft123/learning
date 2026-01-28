<?php

namespace Database\Seeders;
use App\Models\Destination;
use App\Models\State;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $hp   = State::where('name', 'Himachal Pradesh')->first();
        $goa  = State::where('name', 'Goa')->first();
        $dubai = State::where('name', 'Dubai')->first();

        Destination::insert([
            // Himachal
            ['state_id' => $hp->id, 'name' => 'Shimla', 'status' => 1],
            ['state_id' => $hp->id, 'name' => 'Manali', 'status' => 1],
            ['state_id' => $hp->id, 'name' => 'Kasol', 'status' => 1],

            // Goa
            ['state_id' => $goa->id, 'name' => 'North Goa', 'status' => 1],
            ['state_id' => $goa->id, 'name' => 'South Goa', 'status' => 1],

            // Dubai
            ['state_id' => $dubai->id, 'name' => 'Dubai Marina', 'status' => 1],
            ['state_id' => $dubai->id, 'name' => 'Palm Jumeirah', 'status' => 1],
        ]);
    }
}
