<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Movement;
use App\Models\Wallet;

class MovementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movement::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(0, 0, 9999999999.),
            'type' => fake()->word(),
            'status' => fake()->word(),
            'note' => fake()->text(),
            'wallet_id' => Wallet::factory(),
        ];
    }
}
