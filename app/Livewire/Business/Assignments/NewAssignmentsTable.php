<?php

namespace App\Livewire\Business\Assignments;

use App\Livewire\SoaTable\Column;
use App\Livewire\SoaTable\Action;
use App\Livewire\SoaTable\Filter;
use App\Livewire\SoaTable\SoaTable;
use App\Models\Agent;
use App\Models\Assignment;
use App\Models\Customer;
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;

// Heredamos de nuestra clase base LivewireTable
class NewAssignmentsTable extends SoaTable
{

    // protected $listeners = ['reloadCustomersTable' => '$refresh'];

    /**
     * Define el modelo de Eloquent para esta tabla.
     */
    protected string $model = Assignment::class;

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
        return Assignment::query()
            ->with(['agent.profile', 'customer.profile'])
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
            Column::make('Agente', 'agent.profile.full_name')
                ->searchable(),
            Column::make('Cliente', 'customer.profile.full_name')
                ->searchable(),
            Column::make('Estado', 'status'),
            Column::make('Notas generales', 'notes'),
            // Column::make('Slogan', 'slogan')
            //     ->addClasses('font-bold'),
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
            // Filtro de botones para el estado
            Filter::make(
                key: 'status',
                label: 'Estado',
                options: [
                    'active' => 'Activos',
                    'unactive' => 'Inactivos',
                ],
                column: 'status'
            ),
        ];
    }

    // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES INDIVIDUALES
    // =================================================================

    public function fastEdit($rowId): void
    {
        $this->dispatch('enable-edit-for-create-assignment-modal', $rowId);
        Flux::modal('create-assignment')->show();
    }

    // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES MASIVAS
    // =================================================================
}
