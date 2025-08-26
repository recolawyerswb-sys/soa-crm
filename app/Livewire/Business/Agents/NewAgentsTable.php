<?php

namespace App\Livewire\Business\Agents;

use App\Livewire\SoaTable\Column;
use App\Livewire\SoaTable\Action;
use App\Livewire\SoaTable\Filter;
use App\Livewire\SoaTable\SoaTable;
use App\Models\Agent;
use App\Models\Customer;
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;

// Heredamos de nuestra clase base LivewireTable
class NewAgentsTable extends SoaTable
{

    // protected $listeners = ['reloadCustomersTable' => '$refresh'];

    /**
     * Define el modelo de Eloquent para esta tabla.
     */
    protected string $model = Agent::class;

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
        return Agent::query()
            ->with(['profile.user.roles', 'team'])
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
            Column::make('Nombre', 'profile.full_name')
                ->searchable(),
            Column::make('Usuario', 'profile.user.name')
                ->searchable(),
            Column::make('Posicion', 'position'),
            Column::make('Estado', 'status'),
            Column::make('Equipo', 'team.name'),
        ];
    }

    /**
     * Define las acciones disponibles para cada fila.
     */
    protected function additionalActions(): array
    {
        return [
            Action::make('fastEdit', 'pencil'),
            // Action::make('Llamar', 'makeCall')
            //     ->classes('text-green-600 hover:text-green-900 font-bold'), // Clases personalizadas
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
                key: 'name',
                label: 'Nombre del Equipo',
                column: 'team.name'
            ),

            // Filtro de botones para el estado
            // Filter::make(
            //     key: 'status',
            //     label: 'Estado',
            //     options: [
            //         1 => 'Activos',
            //         0 => 'Inactivos',
            //     ],
            //     column: 'is_active'
            // ),
        ];
    }

   // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES INDIVIDUALES
    // =================================================================

    public function fastEdit($rowId): void
    {
        $this->dispatch('enable-edit-for-create-agent-modal', $rowId);
        Flux::modal('create-agent')->show();
    }

    // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES MASIVAS
    // =================================================================


}
