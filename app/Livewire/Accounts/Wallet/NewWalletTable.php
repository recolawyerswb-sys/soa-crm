<?php

namespace App\Livewire\Accounts\Wallet;

use App\Livewire\SoaTable\Column;
use App\Livewire\SoaTable\Action;
use App\Livewire\SoaTable\Filter;
use App\Livewire\SoaTable\SoaTable;
use App\Models\Wallet;
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;

// Heredamos de nuestra clase base LivewireTable
class NewWalletTable extends SoaTable
{
    /**
     * Define el modelo de Eloquent para esta tabla.
     */
    protected string $model = Wallet::class;

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
        return Wallet::query()
            ->with(['movements', 'user'])
            ->orderByDesc('created_at');
    }

    /**
     * Define las columnas que se mostrarán en la tabla.
     */
    protected function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable(),
            Column::make('Direccion', 'address')
                ->searchable(),
            Column::make('Propietario', 'user.name')
                ->searchable()
                ->addClasses('font-bold'),
            Column::make('Red', 'network')
                ->searchable(),
            Column::make('Saldo', 'balance')
                ->currency()
                ->addClasses('font-bold'),
            Column::make('Total retirado', 'total_withdrawn')
                ->currency(),
            Column::make('Total ingresado', 'total_deposit')
                ->currency(),
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

    protected function enableBulkActions(): bool
    {
        return auth()->user()->isDev();
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
        $this->dispatch('enable-edit-for-update-wallet-modal', $rowId);
        Flux::modal('update-wallet-modal')->show();
    }

    // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES MASIVAS
    // =================================================================
}
