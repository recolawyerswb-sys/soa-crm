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
        $customerQuery = '';

        switch (auth()->check()) {
            case auth()->user()->isAgente():
                $agentId = auth()->user()->profile->agent->id;
                // RETRIEVE RELATED AGENT RESULTS
                $customerQuery = Assignment::query()
                    ->where('agent_id', $agentId)
                    ->with(['agent.profile', 'customer.profile'])
                    ->orderByDesc('id');
            break;
            case auth()->user()->isAdmin():
                // RETRIEVE ALL RESULTS
                $customerQuery = Assignment::query()
                    ->with(['agent.profile', 'customer.profile'])
                    ->orderByDesc('id');
            break;
        }

        return $customerQuery;
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
            Column::makeView('Estado', 'livewire.business.assignments.table.status-column'),
            Column::make('Notas generales', 'notes'),
            // Column::make('Slogan', 'slogan')
            //     ->addClasses('font-bold'),
        ];
    }

    /**
     * Habilita las acciones de fila solo para usuarios
     * con el permiso 'edit customers'.
     */
    protected function enableActions(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Define las acciones disponibles para cada fila.
     */
    protected function additionalActions(): array
    {
        return [
            Action::make('fastEdit', 'pencil')
                ->label('editar')
                ->canSee(fn () => auth()->user()->isAdmin()),
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
