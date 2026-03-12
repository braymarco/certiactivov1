<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Config::create([
            'key' => 'WHATAPI_CONFIG',
            'value' => json_encode([
                'server' => '',
                'key' => '',
            ]),
        ]);
        Config::create([
            'key' => 'WHATAPI_PHONES',
            'value' => json_encode([
                'certiactivo' => '',
            ]),
        ]);
        Config::create([
            'key' => 'TELEGRAM_NOTIFICATIONS_BOT',
            'value' => '',
        ]);
        Config::create([
            'key' => 'FIRMA_NOTIFY_GROUP',
            'value' => 1,
        ]);
        Config::create([
            'key' => 'SUPPORT_GROUP',
            'value' => '',
        ]);
        Config::create([
            'key' => 'SUPPORT_GROUP',
            'value' => '',
        ]);

    }
}
