<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class WebSuperAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear el usuario superadmin
        $admin = User::create([
            'email' => 'admin@recolawyers.com',
            'name' => 'administrador',
            'password' => Hash::make(':Ls3S)915")>'),
        ]);

        // Asignar rol, perfil y wallet al admin
        $admin->assignRole('admin');
        $admin->profile()->create([
            'full_name' => 'Administrador',
            'phone_1' => '31331'
        ]);
        $admin->wallet()->create([
            'coin_currency' => fake()->randomElement(['USDT', 'BTC', 'ETH', 'BNB']),
            'address' => fake()->text(20),
            'network' => fake()->randomElement(['TRC20', 'TRX']),
        ]);
    }
}
