<?php

namespace App\Listeners;

use App\Models\CheckIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;

class LogUserCheckIn
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        // $event->user contiene el usuario que acaba de iniciar sesión.
        $user = $event->user;

        if (app()->isProduction()) {
            // Creamos el registro en la tabla 'agent_check_ins'
            CheckIn::create([
                'user_id' => $user->id,
                'check_in_time' => now()->format('H:i:s'), // ¡Aquí guardamos la hora exacta!
                'user_type' => $user->getCurrentRole(),
            ]);
        }

        return;
    }
}
