<?php

namespace App\Helpers;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class RoleHelper
{
    // Add shared role-related helper methods here

    public static function getRolesAsArray(): array
    {
        return Role::get()->pluck('name')->toArray();
    }
}
