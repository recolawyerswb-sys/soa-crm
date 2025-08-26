<?php

namespace App\Traits;

trait RoleTrait
{
    // Add shared methods or properties for roles here

    public function getCurrentRole($isUpper = false)
    {
        $role = $this->getRoleNames()->first();
        if ($isUpper) {
            return strtoupper($role);
        }
        return $role; // Default to 'cliente' if no role is assigned
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isCliente()
    {
        return $this->hasRole('cliente');
    }

    public function isAgente()
    {
        return $this->hasRole('agente');
    }
}
