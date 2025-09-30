<?php

namespace App\Enums\Accounts\Movements;

enum MovementType: string
{
    case DEPOSIT = '1';
    case WITHDRAWAL = '2';
    case BONUS = '3';
}
