<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'name' => '7 días',
            'order' => 1,
            'duration' => 10,
            'duration_unit' => 'day',
            'price' => 1,
            'uanataca_id' => '7 días',
        ]);
        Plan::create([
            'name' => '30 días',
            'order' => 2,
            'duration' => 30,
            'duration_unit' => 'day',
            'price' => 1,
            'uanataca_id' => '30 días',
        ]);
        Plan::create([
            'name' => '1 Año',
            'order' => 3,
            'duration' => 1,
            'duration_unit' => 'year',
            'price' => 1,
            'uanataca_id' => '1 año',
        ]);
        Plan::create([
            'name' => '2 Años',
            'order' => 4,
            'duration' => 2,
            'duration_unit' => 'year',
            'price' => 1,
            'uanataca_id' => '2 años',
        ]);
        Plan::create([
            'name' => '3 Años',
            'order' => 5,
            'duration' => 3,
            'duration_unit' => 'year',
            'price' => 1,
            'uanataca_id' => '3 años',
        ]);
        Plan::create([
            'name' => '4 Años',
            'order' => 6,
            'duration' => 4,
            'duration_unit' => 'year',
            'price' => 1,
            'uanataca_id' => '4 años',
        ]);
        Plan::create([
            'name' => '5 Años',
            'order' => 7,
            'duration' => 5,
            'duration_unit' => 'year',
            'price' => 1,
            'uanataca_id' => '5 años',
        ]);
    }
}
