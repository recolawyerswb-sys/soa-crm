<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class WebDeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear el usuario superadmin
        $admin = User::create([
            'email' => 'dev@recolawyers.com',
            'name' => 'Mantenimiento y configuracion',
            'password' => Hash::make('dev.password'),
        ]);

        // Asignar rol, perfil y wallet al admin
        $admin->assignRole('developer');
        $admin->profile()->create([
            'full_name' => 'Pandita de sistemas',
            'phone_1' => '122222121'
        ]);
        $admin->wallet()->create([
            'coin_currency' => 'USDT',
            'address' => 'TBooJ4etgXUXKf2QuQ87JwjqtsBnXM762G',
            'network' => 'TRX',
        ]);
    }
}
