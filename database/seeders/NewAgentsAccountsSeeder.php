<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class NewAgentsAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 3. Array con la información de los nuevos agentes
        $agentes = [
            [
                'email' => 'andrescastillo@recolawyers.com',
                'password' => '9BxsY9WBpbNe',
            ],
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

        $team = Team::where('name', 'crm')->first();

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
            $agentProfile = $agente->profile()->create([
                // Convierte 'carlosguerrero' en 'Carlos Guerrero'
                'full_name' => Str::title(str_replace(['.', '_'], ' ', $nameFromEmail)),
                'phone_1' => '31331',
            ]);

            $agentProfile->agent()->create([
                'position' => 'A',
                'is_leader' => false,
                'day_off' => 5, //
                'checkin_hour' => '09:00:00',
                'status' => 1,
                'team_id' => $team->id,
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
