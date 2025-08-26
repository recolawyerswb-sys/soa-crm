<?php

namespace App\Helpers\Views;

use Illuminate\Support\Facades\Auth;

class MiscHelper
{
    // Add your helper methods here
    public static function getGreeting()
    {
        $hour = (int)date('H');
        $userName = strtolower(Auth::check() ? Auth::user()->name : 'Usuario');

        if ($hour >= 6 && $hour < 12) {
            return 'Buenos días ' . $userName . '!';
        } elseif ($hour >= 12 && $hour < 20) {
            return 'Buenas tardes ' . $userName . '!';;
        } else {
            return 'Buenas noches ' . $userName . '!';;
        }
    }
}
