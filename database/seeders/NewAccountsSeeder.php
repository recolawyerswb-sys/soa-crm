<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class NewAccountsSeeder extends Seeder
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

        // 2. Crear un agente inicial (Andrés Castillo)
        $agenteAndres = User::create([
            'email' => 'andrescastillo@recolawyers.com',
            'name' => 'andrescastillo', // Mejorado para ser único
            'password' => Hash::make('9BxsY9WBpbNe'),
        ]);

        // Asignar rol, perfil y wallet a Andrés
        $agenteAndres->assignRole('agent');
        $agenteAndres->profile()->create([
            'full_name' => 'Andres Castillo', // Mejorado
            'phone_1' => '31331'
        ]);
        $agenteAndres->wallet()->create([
            'coin_currency' => fake()->randomElement(['USDT', 'BTC', 'ETH', 'BNB']),
            'address' => fake()->text(20),
            'network' => fake()->randomElement(['TRC20', 'TRX']),
        ]);

        // 3. Array con la información de los nuevos agentes
        $agentes = [
            [
                'email' => 'carlosguerrero@recolawyers.com',
                'password' => '{+Ld;~a[9CEV',
            ],
            [
                'email' => 'felipemora@recolawyers.com',
                'password' => '45p2P-,50t?J',
            ],
            [
                'email' => 'joelmartinez@recolawyers.com',
                'password' => '.C?1gGNbSh,M',
            ],
            [
                'email' => 'alexissantiago@recolawyers.com',
                'password' => 'o%x$7?jDxf-A',
            ],
            [
                'email' => 'luciahernandez@recolawyers.com',
                'password' => '$)zR,D4{M0G{',
            ],
        ];

        // 4. Bucle para crear cada agente con sus relaciones
        foreach ($agentes as $agenteData) {

            // Extraer el nombre del email para usarlo en 'name' y 'full_name'
            $nameFromEmail = explode('@', $agenteData['email'])[0];

            // Crear el usuario
            $agente = User::create([
                'email' => $agenteData['email'],
                'name' => $nameFromEmail,
                'password' => Hash::make($agenteData['password']),
            ]);

            // Asignar el rol de 'agente'
            $agente->assignRole('agent');

            // Crear el perfil relacionado
            $agente->profile()->create([
                // Convierte 'carlosguerrero' en 'Carlos Guerrero'
                'full_name' => Str::title(str_replace(['.', '_'], ' ', $nameFromEmail)),
                'phone_1' => '31331'
            ]);

            // Crear la wallet relacionada
            $agente->wallet()->create([
                'coin_currency' => fake()->randomElement(['USDT', 'BTC', 'ETH', 'BNB']),
                'address' => fake()->text(20),
                'network' => fake()->randomElement(['TRC20', 'TRX']),
            ]);
        }
    }
}
