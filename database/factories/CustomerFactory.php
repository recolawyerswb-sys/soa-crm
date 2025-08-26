<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Profile;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'source' => fake()->word(),
            'type' => fake()->word(),
            'phase' => fake()->word(),
            'origin' => fake()->word(),
            'status' => fake()->word(),
            'no_calls' => fake()->numberBetween(-10000, 10000),
            'last_contact_at' => fake()->dateTime(),
            'profile_id' => Profile::factory(),
        ];
    }
}
