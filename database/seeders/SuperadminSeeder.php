<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear o encontrar el rol "superadmin"
        $role = Role::firstOrCreate(['name' => 'admin']);

        // 2. Crear el usuario superadmin
        $user = User::create([
                'email' => 'admin@email.com',
                'name' => 'admin',
                'password' => Hash::make('password'), // ⚠️ cambia en producción
            ],
        );

        // 3. Asignar el rol
        if (!$user->hasRole('admin')) {
            $user->assignRole($role);
        }

        // 3. Crear perfil relacionado
        $profile = $user->profile()->create([
            'full_name' => 'admin',
            'country' => 'Colombia',
            'phone_1' => '+57333322209',
        ]);

        // 5. Crear wallet relacionada
        $wallet = $user->wallet()->create([
            'coin_currency' => fake()->randomElement(['USDT', 'BTC', 'ETH', 'BNB']),
            'address' => fake()->text(20),
            'network' => fake()->randomElement(['TRC20', 'TRX']),
        ]);

        // 6. Crear movimientos
        for ($i=0; $i < 4; $i++) {
            # code...
            $wallet->movements()->create([
                'amount' => rand(10, 500),
                'type' => fake()->randomElement(['1', '2', '3']), // 1: Deposito, 2: Retiro, 3: Bono
                'note' => "Autogenerado",
            ]);
        }
    }
}
