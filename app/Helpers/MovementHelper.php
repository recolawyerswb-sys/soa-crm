<?php

namespace App\Helpers;


class MovementHelper
{
    public static function getTypes(): array
    {
        return [
            '1' => 'Deposito',
            '2' => 'Retiro',
            '3' => 'Bono',
        ];
    }
}
