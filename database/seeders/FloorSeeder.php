<?php

namespace Database\Seeders;

use App\Models\Floors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FloorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $floors = 21;

        for ($i = 1; $i <= $floors; $i++) {

            Floors::factory()->create([
                'floor_number' => $i,
            ]);
        }
    }
}
