<?php

namespace App\Helpers;

use App\Helpers\Agent\FormatHelper;
use App\Models\Agent;
use Illuminate\Support\Collection;

class AgentHelper extends FormatHelper
{
    // Add shared role-related helper methods here

    public static function getAgentsAsArrayWithIdsAsKeys(): array
    {
        return Agent::with('profile')
            ->get()
            ->filter(fn ($agent) => $agent->profile) // Evita agentes sin perfil
            ->mapWithKeys(fn ($agent) => [
                $agent->id => $agent->profile->full_name // o full_name
            ])
            ->toArray();
    }

    public static function getPositionsOptions(): array
    {
        return [
            'A',
            'B',
            'C',
            // Agrega más posiciones según sea necesario
        ];
    }
}
