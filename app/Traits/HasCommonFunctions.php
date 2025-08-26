<?php

namespace App\Traits;

trait HasCommonFunctions
{
    public function getTotalRecords(): int
    {
        return $this->count();
    }
}
