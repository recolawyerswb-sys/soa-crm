<?php

namespace App\Traits\User\Concerns;

use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;

trait Handle2FA
{
    /**
     * Disable two-factor authentication for a user.
     *
     * @param mixed $user
     * @return bool
     */
    public function disable2FA(DisableTwoFactorAuthentication $disableTwoFactorAuthentication, int $user): void {
        $disableTwoFactorAuthentication($user);
    }
}
