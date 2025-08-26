<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Agent;
use App\Models\AgentLead;

class AgentLeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgentLead::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'agent_id' => Agent::factory(),
            'team_id' => ::factory(),
        ];
    }
}
