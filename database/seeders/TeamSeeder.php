<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'name' => 'Crm',
            'description' => 'Equipo de CRM',
            'slogan' => 'Siempre atentos, siempre presentes',
            'color_code' => '#1f88ff',
        ]);

        Team::create([
            'name' => 'Fenix',
            'description' => 'El equipo Fenix es un grupo de profesionales comprometidos con la excelencia y la innovación.',
            'slogan' => 'De cada desafio, renacemos mas fuertes',
            'color_code' => '#ffc91f',
        ]);

        Team::create([
            'name' => 'Azul',
            'slogan' => 'Siempre atentos, siempre presentes',
            'color_code' => '#1f88ff',
        ]);

        Team::create([
            'name' => 'Impulso',
            'slogan' => 'Movemos la experiencia al siguiente nivel',
            'color_code' => '#52ff1f',
        ]);
    }
}
