<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Wallet;

class WalletFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'coin_currency' => fake()->word(),
            'address' => fake()->text(),
            'network' => fake()->word(),
            'balance' => fake()->randomFloat(0, 0, 9999999999.),
            'total_withdrawn' => fake()->randomFloat(0, 0, 9999999999.),
            'total_ammount' => fake()->randomFloat(0, 0, 9999999999.),
            'last_movement_id' => fake()->randomNumber(),
            'user_id' => User::factory(),
        ];
    }
}
