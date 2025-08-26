<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            SuperadminSeeder::class,
            TeamSeeder::class,
            AgentSeeder::class,
            ClientUserSeeder::class,
        ]);
    }
}
