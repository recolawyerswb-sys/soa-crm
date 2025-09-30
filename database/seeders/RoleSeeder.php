<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ADMINISTRATIVOS
        $rsAdmin = [
            'admin',
            'manager',
            'crm_manager',
        ];

        // BANCARIO
        $rsBancario = [
            'banki',
        ];

        // LIDERES
        $rsLideres = [
            'lead_agent',
        ];

        // AGENTES
        $rsAsesores = [
            'crm_agent',
            'agent',
        ];

        // CLIENTES
        $rsClientes = [
            'customer',
        ];

        // COMBINANDO TODOS LOS ROLES
        // y creando los registros en la base de datos
        $roles = array_merge($rsAdmin, $rsBancario, $rsLideres, $rsAsesores, $rsClientes);

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
