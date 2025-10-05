<?php

namespace App\Livewire\Calls\Reports;

use App\Livewire\SoaTable\Action;
use App\Livewire\SoaTable\Column;
use App\Livewire\SoaTable\Filter;
use App\Livewire\SoaTable\SoaTable;
use App\Models\CallReport;
use App\Models\ClientTracking;
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;

class NewCallReportsTable extends SoaTable
{
    /**
     * Define el modelo de Eloquent para esta tabla.
     */
    protected string $model = CallReport::class;

    public string $title = 'Registros actuales';
    // public string $description = 'Lista de equipos con sus respectivos agentes y clientes.';

    /**
     * Define la consulta base para la tabla.
     * Aquí puedes añadir joins, scopes, etc.
     */
    public function query(): Builder
    {
        return CallReport::query()
            ->with(['assignment.agent', 'assignment.customer'])
            ->orderByDesc('id');
    }

    /**
     * Define las columnas que se mostrarán en la tabla.
     */
    protected function columns(): array
    {
        return [
            Column::make('ID Llamada', 'call_sid')
                ->searchable(),
            Column::make('Estado final', 'call_status'),
            Column::make('Agente que llamo', 'assignment.agent.profile.full_name'),
            Column::make('Cliente contactado', 'assignment.customer.profile.full_name'),
            Column::make('Notas', 'call_notes'),
            Column::make('Fase', 'customer_phase'),
            Column::make('Estado', 'customer_status'),
        ];
    }

    /**
     * Habilita las acciones de fila solo para usuarios
     * con el permiso 'edit customers'.
     */
    protected function enableActions(): bool
    {
        return false;
    }

    /**
     * Define las acciones disponibles para cada fila.
     */
    protected function additionalActions(): array
    {
        return [
            // Action::make('fastEdit', 'pencil')
            //     ->label('Editar'),
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
                key: 'callSid',
                label: 'ID Llamada',
                column: 'call_sid'
            ),
        ];
    }

   // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES INDIVIDUALES
    // =================================================================

    // public function fastEdit($rowId): void
    // {
    //     $this->dispatch('enable-edit-for-create-client-tracking-modal', $rowId);
    //     Flux::modal('create-client-tracking')->show();
    // }

    // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES MASIVAS
    // =================================================================

}
