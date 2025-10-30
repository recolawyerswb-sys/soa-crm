<?php

namespace App\Helpers;

use App\Models\Customer;

class ClientHelper
{
    public static function getCustomersAsArrayWithIdsAsKeys(): array
    {
        return Customer::with('profile')
            ->get()
            ->filter(fn ($customer) => $customer->profile) // Evita agentes sin perfil
            ->mapWithKeys(fn ($customer) => [
                $customer->id => $customer->profile->full_name // o full_name
            ])
            ->toArray();
    }

    public static function getRelatedAgentCustomersAsArrayWithIdsAsKeys(): array
    {
        $agentId = '';

        // Obtenemos el ID del agente autenticado.
        if (
            auth()->check() &&
            auth()->user()->profile &&
            auth()->user()->profile->agent
        ) {
            $agentId = auth()->user()->profile->agent->id;
        }

        return Customer::query()
            // 1. AÑADIDO: Filtramos los clientes que tienen una asignación
            // correspondiente al agente actual.
            ->whereHas('assignment', function ($query) use ($agentId) {
                $query->where('agent_id', $agentId);
            })

            // 2. MEJORADO: Nos aseguramos de que el cliente tenga un perfil.
            // Hacerlo con 'whereHas' es más eficiente que con 'filter()'
            // porque se hace en la base de datos.
            ->whereHas('profile')

            // Cargamos la relación 'profile' para poder usarla después.
            ->with('profile')

            // Ahora sí, obtenemos la colección ya filtrada.
            ->get()

            // La transformación final es la misma, pero ahora se aplica
            // solo sobre los clientes correctos.
            ->mapWithKeys(fn ($customer) => [
                $customer->id => $customer->profile->full_name
            ])
            ->toArray();
    }

    public static function getTypes(): array
    {
        return [
            'lead' => 'Lead',
            'conversion' => 'Conversion',
            'retencion' => 'Retencion',
            'recuperacion' => 'Recuperacion',
        ];
    }

    public static function getStatus(): array
    {
        return [
            'no_answer' => 'No Answer',
            'new' => 'New',
            'interested' => 'Interesado',
            'not_interested' => 'No Interesado',
            'call_again' => 'Call Again',
            'potencial' => 'Cliente Potencial',
            'low_potencial' => 'Cliente Bajo Potencial',
            'dnc' => 'DNC',
            'ftd' => 'FTD',
        ];
    }

    public static function getPhases(): array
    {
        return [
            'activo' => 'Activo',
            'inactivo' => 'Inactivo',
            'archivado' => 'Archivado',
        ];
    }

    public static function getOrigins(): array
    {
        return [
            'web' => 'Web',
            'referido' => 'Referido',
            'social_media' => 'Social Media',
            'other' => 'Other',
            'bityei' => 'Bityei',
        ];
    }

    public static function getDniTypes(): array
    {
        return [
            'dni' => 'DNI',
            'pasaporte' => 'PASAPORTE',
            'LC_COND' => 'Licencia de conducir', #LC_COND
            'LC_CORR' => 'Licencia de corredor', #LC_CORR
        ];
    }

    public static function getPreferredContactMethods(): array
    {
        return [
            'email' => 'CORREO ELECTRÓNICO',
            'telefono' => 'TELEFONO',
            'telegram' => 'TELEGRAM',
            'whatsapp' => 'WHATSAPP',
        ];
    }
}
