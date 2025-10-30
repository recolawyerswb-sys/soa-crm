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
        return $role;
    }

    public function getCurrentRoleAsString($isUpper = false)
    {
        $role = $this->roles->pluck('name')->implode(', ');
        if ($isUpper) {
            return strtoupper($role);
        }
        return $role;
    }


    public function isAdmin()
    {
        return $this->hasRole(['admin', 'developer']);
    }

    public function isManager()
    {
        return $this->hasRole('manager');
    }

    public function isCrmManager()
    {
        return $this->hasRole('crm_manager');
    }

    public function isBanki()
    {
        return $this->hasRole('banki');
    }

    public function isAgente()
    {
        return $this->hasRole('agent');
    }

    public function isLeadAgent()
    {
        return $this->hasRole('lead_agent');
    }

    public function isCrmAgent()
    {
        return $this->hasRole('crm_agent');
    }

    public function isCliente()
    {
        return $this->hasRole('customer');
    }
}
