<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Pago Activo',
            'email' => 'firma.electronica@gusof.com',
            'password' => password_hash('123456789',PASSWORD_DEFAULT),
            'is_admin' => true,
            'api_token'=>'scndafbw38o4gfeofbo3e4zsdfbf3a9'
        ]);
    }
}
