<?php

namespace App\Traits;

trait UserTrait
{
    public static function getTotalBalance()
    {
        return auth()->user()->wallet ? auth()->user()->wallet->balance : 0.0;
    }

    public static function getTotalDeposit()
    {
        return auth()->user()->wallet ? auth()->user()->wallet->total_deposit : 0.0;
    }

    public static function getTotalWithdrawn()
    {
        return auth()->user()->wallet ? auth()->user()->wallet->total_withdrawn : 0.0;
    }
}
