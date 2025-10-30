<?php

namespace App\Traits\User\Concerns;

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

    public static function getOnlineStatus($withLabel = false)
    {
        if ($withLabel){
            return $this->is_online ? 'En linea' : 'No esta conectado';
        }

        return $this->is_online;
    }

    public function lastLogin()
    {
        // 1. Obtiene el último registro de la relación 'checkins'.
        //    Usamos 'latest()->first()' para traer solo el más reciente.
        $lastCheckin = $this->checkins()->latest()->first();

        // 2. Si existe un registro, formatea la fecha.
        if ($lastCheckin) {
            // diffForHumans() crea un formato como "hace 1 día".
            // La propiedad 'created_at' es un objeto Carbon, por eso podemos usarlo.
            return $lastCheckin->created_at->diffForHumans();
        }

        // 3. Si el usuario nunca ha iniciado sesión, devuelve un texto.
        return 'Nunca';
    }

    public function changeOnlineStatus(bool $status = true): void
    {
        $this->is_online = $status;
        $this->save();
    }


}
