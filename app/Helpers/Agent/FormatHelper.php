<?php

namespace App\Helpers\Agent;

use Illuminate\Support\Carbon;

class FormatHelper
{
    /**
     * 2. Formatea una fecha y hora para mostrar solo la hora en formato AM/PM.
     * Esto soluciona tu problema con el casteo de datetime.
     *
     * @param string|null $dateTime La fecha y hora (ej: '2025-09-25 08:30:00').
     * @return string
     */
    public static function formatCheckinHour(?string $dateTime): string
    {
        if (!$dateTime) {
            return 'N/A'; // Devuelve 'No aplica' si no hay fecha
        }

        // Carbon parsea el string completo y format() extrae solo la hora.
        return Carbon::parse($dateTime)->format('h:i A');
    }

    /**
     * 3. Convierte el número del día libre al nombre del día.
     *
     * @param int|null $dayNumber El número del día (1=Lunes, 7=Domingo).
     * @return string
     */
    public static function formatDayOff(?int $dayNumber): string
    {
        return match ($dayNumber) {
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo',
            default => 'No especificado',
        };
    }

}
