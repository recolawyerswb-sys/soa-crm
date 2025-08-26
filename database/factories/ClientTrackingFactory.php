<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Assignment;
use App\Models\ClientTracking;

class ClientTrackingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientTracking::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'assignment_id' => Assignment::factory(),
            'action' => fake()->word(),
            'notes' => fake()->text(),
        ];
    }
}
