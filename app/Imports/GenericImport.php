<?php

namespace App\Imports;

use App\Helpers\ClientHelper;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithStartRow; // Para empezar desde la segunda fila

class GenericImport implements ToModel, WithCustomCsvSettings, WithStartRow, SkipsEmptyRows
{
    protected $modelClass;

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $fullName = $row[2];
        $phoneNumber = Str::substr($row[3], 2);
        $email = $row[4];
        $country = $row[5];
        $genPwrd = Str::substr(Str::lower($fullName), 0, 3) . '-' . Str::substr(Str::lower($email), 0, 3);

        // dd($fullName);

        DB::transaction(function () use ($fullName, $phoneNumber, $email, $country, $genPwrd) {
            $assignedAgentId = Agent::whereHas('profile', function ($query) {
                $query->where('full_name', 'crm');
            })->first()->id;


            // 1. Crear usuario
            $user = User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => Hash::make($genPwrd),
            ]);

            // 2. Asignar rol de cliente
            $user->assignRole('customer');

            // 3. Crear perfil relacionado
            $profile = $user->profile()->create([
                'full_name' => $fullName,
                'country' => $country,
                'phone_1' => $phoneNumber,
                'preferred_contact_method' => 'telefono',
            ]);

            // 3.1. Crear cliente relacionado con el perfil
            $customer = $profile->customer()->create([
                'type' => 'lead',
                'status' => 'new',
                'origin' => 'meta',
                'phase' => 'activo',
            ]);

            // 4. Crear una asignacion para el cliente
            $customer->assignment()->create([
                'agent_id' => $assignedAgentId,
                'notes' => 'Importado',
                'status' => '1',
            ]);

            // 5. Crear wallet relacionada
            $user->wallet()->create([
                'coin_currency' => config('cm.local.wallet.coin'),
                'address' => config('cm.local.wallet.address'),
                'network' => config('cm.local.wallet.network'),
            ]);

            return $customer;
        });
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1'
        ];
    }

    public function startRow(): int
    {
        return 2;
    }
}
