<?php

namespace App\Livewire\Business\ClientTracking;

use App\Livewire\SoaTable\Action;
use App\Livewire\SoaTable\Column;
use App\Livewire\SoaTable\Filter;
use App\Livewire\SoaTable\SoaTable;
use App\Models\ClientTracking;
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;

class NewClientTrackingTable extends SoaTable
{
    /**
     * Define el modelo de Eloquent para esta tabla.
     */
    protected string $model = ClientTracking::class;

    public string $title = 'Registros actuales';
    // public string $description = 'Lista de equipos con sus respectivos agentes y clientes.';

    /**
     * Define la consulta base para la tabla.
     * Aquí puedes añadir joins, scopes, etc.
     */
    public function query(): Builder
    {
        // Usamos el modelo definido para iniciar la consulta.
        // Puedes agregar relaciones que necesites con with().
        return ClientTracking::query()
            ->with(['assignment.agent', 'assignment.customer'])
            ->orderByDesc('id');
    }

    /**
     * Define las columnas que se mostrarán en la tabla.
     */
    protected function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable(),
            Column::make('Agente', 'assignment.agent.profile.full_name')
                ->searchable(),
            Column::make('Cliente', 'assignment.customer.profile.full_name')
                ->searchable(),
            Column::make('Notas', 'notes'),
        ];
    }

    /**
     * Define las acciones disponibles para cada fila.
     */
    protected function additionalActions(): array
    {
        return [
            Action::make('fastEdit', 'pencil')
                ->label('Editar'),
        ];
    }

    /**
     * Define las acciones masivas adicionales para esta tabla.
     * "Eliminar Seleccionados" se hereda automáticamente desde el Trait.
     */
    protected function additionalBulkActions(): array
    {
        return [
            // BulkAction::make('Cambiar Estados', 'showMassiveChangePhaseForm'),
        ];
    }

    protected function filters(): array
    {
        return [
            // Filtro de input para buscar por nombre
            Filter::makeInput(
                key: 'customerName',
                label: 'Cliente',
                column: 'assignment.customer.profile.name'
            ),
             Filter::makeInput(
                key: 'agentName',
                label: 'Agente',
                column: 'assignment.agent.profile.name'
            ),
        ];
    }

   // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES INDIVIDUALES
    // =================================================================

    public function fastEdit($rowId): void
    {
        $this->dispatch('enable-edit-for-create-client-tracking-modal', $rowId);
        Flux::modal('create-client-tracking')->show();
    }

    // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES MASIVAS
    // =================================================================

}
