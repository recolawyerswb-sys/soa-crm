<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Profile;
use App\Models\Agent;
use App\Models\Team;

class AgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Agent::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'position' => fake()->word(),
            'no_calls' => fake()->numberBetween(-10000, 10000),
            'status' => fake()->word(),
            'is_leader' => fake()->boolean(),
            'team_id' => Team::factory(),
            'profile_id' => Profile::factory(),
        ];
    }
}
