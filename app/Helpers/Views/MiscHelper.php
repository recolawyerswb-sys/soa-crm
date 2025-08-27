<?php

namespace App\Helpers\Views;

use Illuminate\Support\Facades\Auth;

class MiscHelper
{
    // Add your helper methods here
    public static function getGreeting()
    {
        $hour = (int)date('H');

        if ($hour < 6 || $hour >= 20) {
            return 'Buenas noches';
        } elseif ($hour < 12) {
            return 'Buenos días';
        } else {
            return 'Buenas tardes';
        }
    }
}
