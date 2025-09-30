<?php

namespace App\Enums\Accounts\Movements;

enum MovementStatus: string
{
    case APPROVED = '1';
    case PENDING = '2';
    case REJECTED = '0';
}
