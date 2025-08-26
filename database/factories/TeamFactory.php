<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Team;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'slogan' => fake()->word(),
            'color_code' => fake()->word(),
            'total_customers' => fake()->numberBetween(-10000, 10000),
            'no_members' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
