<?php

namespace Database\Seeders;

use App\Helpers\ClientHelper;
use App\Models\Agent;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teamName = 'crm';
        $fullAgentName = 'crm';

        $team = Team::where('name', $teamName)->first();

        $userAgent = User::create([
            'name' => $fullAgentName,
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'), // ⚠️ cambia en producción
        ]);

        $userAgent->assignRole('agente');

        // $defaultTeam = Team::where('name', 'Crm')->first();
        $profile = $userAgent->profile()->create([
            'full_name' => $fullAgentName,
            'country' => fake()->country(),
            'phone_1' => fake()->phoneNumber(),
            'phone_2' => fake()->phoneNumber(),
            'preferred_contact_method' => fake()->randomElement(ClientHelper::getPreferredContactMethods()),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'dni_type' => fake()->randomElement(['DNI', 'CC', 'PP', 'LICENCIA']),
            'dni_number' => fake()->numerify('########'),
            'birthdate' => fake()->date(),
        ]);

        $agent = $profile->agent()->create([
            'position' => fake()->randomElement(['A', 'B', 'C']),
            'is_leader' => false,
            'status' => fake()->randomElement(['1', '0', '2']),
            'team_id' => $team->id,
        ]);

        // 5. Crear wallet relacionada
        $wallet = $userAgent->wallet()->create([
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
