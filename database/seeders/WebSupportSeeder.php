<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class WebSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear el usuario superadmin
        $admin = User::create([
            'email' => 'support@recolawyers.com',
            'name' => 'Soporte',
            'password' => Hash::make('6AK;GT2&lCAv'),
        ]);

        // Asignar rol, perfil y wallet al admin
        $admin->assignRole('admin');
        $admin->profile()->create([
            'full_name' => 'Soporte CRM',
            'phone_1' => '31331'
        ]);
        $admin->wallet()->create([
            'coin_currency' => fake()->randomElement(['USDT', 'BTC', 'ETH', 'BNB']),
            'address' => fake()->text(20),
            'network' => fake()->randomElement(['TRC20', 'TRX']),
        ]);
    }
}
