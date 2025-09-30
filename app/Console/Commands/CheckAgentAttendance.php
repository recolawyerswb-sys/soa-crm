<?php

namespace App\Console\Commands;

use App\Models\Agent;
use App\Models\Attendance;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckAgentAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-agent-attendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica el estado en línea de los agentes y crea su registro de asistencia diario.';

    public function handle()
    {
        $this->info('Iniciando la verificación de asistencia de agentes...');

        $now = now();
        // Obtenemos el día de la semana actual (1 para Lunes, 7 para Domingo)
        $todayDayOfWeek = $now->dayOfWeekIso;

        // 1. Obtener solo los agentes que DEBEN trabajar hoy según su horario
        $agentsScheduledToWork = Agent::whereHas('schedules', function ($query) use ($todayDayOfWeek) {
            $query->where('day_of_week', $todayDayOfWeek);
        })->with(['schedules', 'profile.user'])->get();

        if ($agentsScheduledToWork->isEmpty()) {
            $this->info('No hay agentes programados para trabajar hoy. Finalizando.');
            return;
        }

        foreach ($agentsScheduledToWork as $agent) {
            // 2. Verificar si el agente ya tiene una asistencia registrada para hoy
            $existingAttendance = Attendance::where('agent_id', $agent->id)
                                            ->whereDate('attendance_date', $now->toDateString())
                                            ->exists();

            if ($existingAttendance) {
                // Si ya existe, saltamos a la siguiente iteración
                $this->warn("El agente {$agent->id} ya tiene un registro de asistencia para hoy.");
                continue;
            }

            // 3. Verificar si hoy es su día libre personal
            if ($agent->day_off == $todayDayOfWeek) {
                Attendance::create([
                    'agent_id' => $agent->id,
                    'attendance_date' => $now->toDateString(),
                    'status' => 'd', // Estado: En descanso
                    'notes' => 'Día libre programado.',
                ]);
                $this->line("Asistencia 'Día Libre' registrada para el agente {$agent->id}.");
                continue;
            }

            // 4. Determinar el estatus de la asistencia basado en la hora
            // Primero, obtenemos el horario del día para este agente
            $schedule = $agent->schedules->where('day_of_week', $todayDayOfWeek)->first();
            if (!$schedule) {
                continue; // Si por alguna razón no se encuentra el horario, saltar
            }

            // **AQUÍ ESTÁ LA INTEGRACIÓN MÁGICA**
            // Usamos el checkin_hour del agente. Si es nulo, usamos el start_time del horario como respaldo.
            $checkinTimeForValidation = $agent->checkin_hour ?? $schedule->start_time;

            // Creamos un objeto Carbon con la hora de entrada que acabamos de determinar
            $startTime = Carbon::parse($checkinTimeForValidation);

            $status = '';
            // Suponemos que la relación es $agent->profile->user->is_online
            $isOnline = $agent->profile->user->is_online ?? false;

            if ($isOnline) {
                $superPunctualLimit = $startTime->copy()->subMinutes(15); // Límite para ser súper puntual
                $punctualLimit = $startTime->copy()->addMinutes(15);      // Límite para aún ser puntual

                if ($now->lessThanOrEqualTo($superPunctualLimit)) {
                    $status = 'a'; // Súper puntual
                } elseif ($now->between($superPunctualLimit, $punctualLimit)) {
                    $status = 'b'; // Puntual
                } else {
                    $status = 'c'; // Tardío
                }
            } else {
                // Si no está en línea, podrías crear un estatus de "Ausente", por ejemplo 'e'
                // Por ahora, no creamos registro si no está online, pero podrías cambiarlo.
                $this->error("El agente {$agent->id} está offline. No se creará registro de asistencia.");
                continue; // Opcional: podrías registrarlo como ausente
            }

            // 5. Crear el registro de asistencia
            Attendance::create([
                'agent_id' => $agent->id,
                'attendance_date' => $now->toDateString(),
                'status' => $status,
                'notes' => "Registro automático a las {$now->toTimeString()}",
            ]);

            $this->info("Asistencia '{$status}' registrada para el agente {$agent->id}.");
        }

        $this->info('Verificación de asistencia completada.');
        return self::SUCCESS;
    }
}
