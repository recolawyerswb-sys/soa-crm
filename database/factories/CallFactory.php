<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Call;
use App\Models\Customer;

class CallFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Call::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'agent_id' => ::factory(),
            'duration' => fake()->numberBetween(-10000, 10000),
            'status' => fake()->word(),
            'note' => fake()->text(),
        ];
    }
}
