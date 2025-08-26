<?php

namespace Database\Seeders;

use App\Helpers\ClientHelper;
use App\Models\Agent;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ClientUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assignedAgentId = Agent::whereHas('profile', function ($query) {
            $query->where('full_name', 'crm');
        })->first()->id;

        // 1. Crear usuario
        $user = User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'), // ⚠️ cambia en producción
        ]);

        // 2. Asignar rol de cliente
        $user->assignRole('cliente');

        // 3. Crear perfil relacionado
        $profile = $user->profile()->create([
            'full_name' => $user->name,
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

        // 3.1. Crear cliente relacionado con el perfil
        $customer = $profile->customer()->create([
            'type' => 'lead',
            'status' => fake()->randomElement(array_keys(ClientHelper::getStatus())),
            'origin' => fake()->randomElement(array_keys(ClientHelper::getOrigins())),
            'phase' => fake()->randomElement(array_keys(ClientHelper::getPhases())),
        ]);

        // 4. Crear una asignacion para el cliente
        $customer->assignment()->create([
            'agent_id' => $assignedAgentId,
            'notes' => 'Automatico',
            'status' => '1', // Asignado
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
