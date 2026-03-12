<?php

namespace Database\Seeders;

use App\Models\PurchaseToken;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PurchaseToken::create([
            'token' => '1',
            'plan_id' => 3,
            'user_id' => 1,
            'tx_id'=>'1'
        ]);
        PurchaseToken::create([
            'token' => '2',
            'plan_id' => 3,
            'user_id' => 1,
            'tx_id'=>'2'
        ]);
        PurchaseToken::create([
            'token' => '3',
            'plan_id' => 3,
            'user_id' => 1,

            'tx_id'=>'3'
        ]);
        PurchaseToken::create([
            'token' => '4',
            'plan_id' => 3,
            'user_id' => 1,

            'tx_id'=>'4'
        ]);
    }
}
