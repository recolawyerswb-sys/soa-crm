<?php

namespace App\Traits;

trait AgentTrait
{
    // Add shared methods or properties for agents here

    /**
     * Example method for demonstration.
     *
     * @return string
     */
    public function getTeam(): string
    {
        return $this->agent->team->name ?? 'No cuenta con un equipo asignado';
    }
}
