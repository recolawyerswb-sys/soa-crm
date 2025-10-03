<?php

namespace App\Livewire\Business\Agents\Widgets;

use App\Enums\Business\Assignments\AssignmentStatus;
use App\Livewire\SoaTable\Light\LightAction;
use App\Livewire\SoaTable\Light\LightColumn;
use App\Livewire\SoaTable\Light\SoaTableLight;
use App\Models\Assignment;
use Illuminate\Database\Eloquent\Builder;

class LatestAssignedCustomersTable extends SoaTableLight
{
    /**
     * Define el modelo de Eloquent para esta tabla.
     */
    protected string $model = Assignment::class;

    public string $title = 'Tus ultimas asignaciones';

    /**
     * Define la consulta base para la tabla.
     * Aquí puedes añadir joins, scopes, etc.
     */
    public function query(): Builder
    {
        $agentId = auth()->user()->profile->agent->id;
        // Usamos el modelo definido para iniciar la consulta.
        // Puedes agregar relaciones que necesites con with().
        return Assignment::query()
            ->with(['agent.profile', 'customer.profile'])
            ->where('agent_id', $agentId)
            ->latest()
            ->take(10);
    }

    /**
     * Define las columnas que se mostrarán en la tabla.
     */
    protected function columns(): array
    {
        return [
            LightColumn::make('Agente', 'agent.profile.full_name'),
            LightColumn::make('Cliente', 'customer.profile.full_name'),
            LightColumn::make('Fase del cliente', 'customer.phase'),
            LightColumn::make('Estado del cliente', 'customer.status'),
            LightColumn::make('Estado actual', 'status')
                ->badge(function ($row) {
                    // Tu lógica de `match` va aquí.
                    // Debe retornar un array con 'color' y 'label'.
                    return match ($row->status) {
                        AssignmentStatus::ACTIVE->value => ['color' => 'green', 'label' => 'Activa'],
                        AssignmentStatus::INACTIVE->value => ['color' => 'red', 'label' => 'Inactiva'],
                        default => ['color' => 'gray', 'label' => $row->status],
                    };
                }),
            LightColumn::make('Notas generales', 'notes'),
            LightColumn::make('Fecha de asignacion', 'created_at')
                ->date(),
        ];
    }

    protected function actions(): array
    {
        return [
            // Acción #2: Un botón que ejecuta lógica en el backend
            // LightAction::make('Ver detalles', 'business.customers.show')
            //     ->foreground('dark:text-indigo-300 text-indigo-500 hover:underline')
            //     ->canSee(fn($row) => auth()->user()->isAdmin()),
        ];
    }
}
