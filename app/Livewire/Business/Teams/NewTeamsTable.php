<?php

namespace App\Livewire\Business\Teams;

use App\Livewire\SoaTable\Column;
use App\Livewire\SoaTable\Action;
use App\Livewire\SoaTable\Filter;
use App\Livewire\SoaTable\SoaTable;
use App\Models\Team; // Asegúrate de importar tu modelo Team
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;

// Heredamos de nuestra clase base LivewireTable
class NewTeamsTable extends SoaTable
{
    /**
     * Define el modelo de Eloquent para esta tabla.
     */
    protected string $model = Team::class;

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
        return $this->model::query()->orderByDesc('id');
    }

    /**
     * Define las columnas que se mostrarán en la tabla.
     */
    protected function columns(): array
    {
        return [
            Column::make('ID', 'id')->searchable(),
            Column::make('Nombre', 'name')->searchable(),
            Column::make('Clientes Totales', 'total_customers'),
            Column::make('Miembros activos', 'no_members'),
            Column::make('Slogan', 'slogan')
                ->addClasses('font-bold'),

            // Ejemplo de una columna con vista personalizada
            Column::makeView('Color', 'livewire.business.teams.table.team-color-column'),

            // Si 'no_members' y 'total_customers' son relaciones,
            // necesitarás cargarlos con withCount en el query()
            // Column::make('Agentes', 'members_count'),
            // Column::make('Clientes', 'customers_count'),
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
                column: 'name'
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
        $this->dispatch('enable-edit-for-create-team-modal', $rowId);
        Flux::modal('create-team')->show();
    }

    // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES MASIVAS
    // =================================================================
}
