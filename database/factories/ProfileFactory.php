<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Profile;
use App\Models\User;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->word(),
            'email' => fake()->safeEmail(),
            'phone_1' => fake()->word(),
            'phone_2' => fake()->word(),
            'preferred_contact_method' => fake()->word(),
            'country' => fake()->country(),
            'city' => fake()->city(),
            'address' => fake()->text(),
            'dni_type' => fake()->word(),
            'dni_number' => fake()->word(),
            'birthdate' => fake()->date(),
            'user_id' => User::factory(),
        ];
    }
}
