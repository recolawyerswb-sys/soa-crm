<?php

namespace App\Traits;

trait AgentTrait
{
    // Add shared methods or properties for agents here

    /**
     * Example method for demonstration.
     *
     * @return string
     */
    public function getTeam(): string
    {
        return $this->agent->team->name ?? 'No cuenta con un equipo asignado';
    }

    public static function getAgentsCount(): int
    {
        return self::count();
    }

    public static function getDefaultAgentId(): ?int
    {
        return self::whereHas('profile', function ($query) {
            $query->where('full_name', 'crm');
        })->first()?->id;
    }

    public function getTotalAssignedCustomers(): int
    {
        return $this->assignments()->count();
    }

    public function getLastAttendanceStatus()
    {
        // 1. Busca la asistencia de este agente ('$this') donde la fecha
        //    'attendance_date' coincida con la fecha de hoy.
        $todaysAttendance = $this->attendances()
                                ->whereDate('att_date', today())
                                ->first();

        // 2. Si se encuentra un registro, devuelve su estado.
        //    Si no se encuentra (es null), devuelve un estado por defecto.
        return $todaysAttendance->att_status ?? 'No registrado';
    }
}
