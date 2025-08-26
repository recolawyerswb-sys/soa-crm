<?php

namespace App\Helpers;

use App\Models\Team;
use Illuminate\Support\Collection;

class TeamHelper
{
    // Add shared role-related helper methods here

    public static function getTeamsAsArrayWithIdsAsKeys(): array
    {
        return Team::all()
            ->mapWithKeys(fn ($team) => [
                $team->id => $team->name // o full_name
            ])
            ->toArray();
    }
}
