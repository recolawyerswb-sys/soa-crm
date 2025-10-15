<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class SetUsersOfflineCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-users-offline
                            {--target= : El ID del usuario específico a invalidar}
                            {--role= : El rol de los usuarios a invalidar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Establece el estado is_online a falso para todos los usuarios que estén en línea.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Obtener los valores de los flags
        $targetId = $this->option('target');
        $roleName = $this->option('role');

        // 2. Construir la consulta base
        $query = User::query();

        // 3. Aplicar el filtro de rol si se proporcionó
        if ($roleName) {
            // Buena práctica: validar que el rol exista
            if (! Role::where('name', $roleName)->exists()) {
                $this->error("El rol '{$roleName}' no existe.");
                return Command::FAILURE;
            }
            $query->role($roleName);
        }

        // 4. Decidir si la acción es para un target específico o para un grupo
        if ($targetId) {
            // --- LÓGICA PARA UN TARGET ESPECÍFICO (posiblemente filtrado por rol) ---

            // Buscamos al usuario dentro de la consulta ya construida
            $user = $query->find($targetId);

            if (!$user) {
                $message = "No se encontró un usuario con el ID {$targetId}";
                if ($roleName) {
                    $message .= " y el rol '{$roleName}'";
                }
                $this->error($message . ".");
                return Command::FAILURE;
            }

            if (!$user->is_online) {
                $this->warn("El usuario {$user->name} (ID: {$targetId}) ya está desconectado.");
                return Command::SUCCESS;
            }

            $user->update([
                'is_online' => false,
                'last_session_invalidation_at' => now()
            ]);

            $this->info("La sesión del usuario {$user->name} (ID: {$targetId}) ha sido invalidada.");

        } else {
            // --- LÓGICA PARA UN GRUPO (todos los usuarios o todos los de un rol) ---

            // Añadimos la condición final para afectar solo a los que están en línea
            $query->where('is_online', true);

            $updatedCount = $query->update([
                'is_online' => false,
                'last_session_invalidation_at' => now()
            ]);

            // Mensaje de éxito dinámico
            $message = "Operación completada. Se han invalidado las sesiones de {$updatedCount} usuarios";
            if ($roleName) {
                $message .= " con el rol '{$roleName}'";
            }
            $this->info($message . ".");
        }

        return Command::SUCCESS;
    }
}
