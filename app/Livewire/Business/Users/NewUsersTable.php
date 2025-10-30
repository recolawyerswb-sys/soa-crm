<?php

namespace App\Livewire\Business\Users;

use App\Helpers\ClientHelper;
use App\Helpers\User\UserHelper;
use App\Http\Controllers\CallController;
use App\Livewire\SoaTable\Column;
use App\Livewire\SoaTable\Action;
use App\Livewire\SoaTable\BulkAction;
use App\Livewire\SoaTable\Filter;
use App\Livewire\SoaTable\SoaTable;
use App\Models\Customer;
use App\Models\User;
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

// Heredamos de nuestra clase base LivewireTable
class NewUsersTable extends SoaTable
{

    // protected $listeners = ['reloadCustomersTable' => '$refresh'];

    /**
     * Define el modelo de Eloquent para esta tabla.
     */
    protected string $model = User::class;

    public string $title = 'Registros actuales';

    /**
     * Define la consulta base para la tabla.
     * Aquí puedes añadir joins, scopes, etc.
     */
    public function query(): Builder
    {
        return User::query()
            ->with(['roles'])
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
            Column::make('Nombre', 'name')
                ->searchable(),
            Column::make('Email', 'email'),
            Column::make('Rol', 'role_names'),
            Column::make('Wallet ID', 'wallet.id'),
            Column::make('Fecha Creacion', 'created_at')
                ->date(),
            Column::makeView(__('Conexion'), 'livewire.business.users.table.is-online-column'),
        ];
    }

    /**
     * Define las acciones disponibles para cada fila.
     */
    protected function additionalActions():  array
    {
        return [
            Action::make('fastEdit', 'pencil')
                ->label('Editar')
                ->canSee(fn () => auth()->user()->isAdmin()),
        ];
    }


    protected function enableBulkActions(): bool
    {
        return true;
    }

    /**
     * Define las acciones masivas adicionales para esta tabla.
     * "Eliminar Seleccionados" se hereda automáticamente desde el Trait.
     */
    protected function additionalBulkActions(): array
    {
        return [
            // BulkAction::make('Cambiar Rol Masivo', 'showMassiveChangeRoleForm'),
        ];
    }

    protected function filters(): array
    {
        return [

            // Filtro de botones para el estado
            Filter::make(
                key: 'is_online',
                label: 'Conexion',
                options: UserHelper::getConnStatusData(),
                column: 'is_online'
            ),
        ];
    }

    // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES INDIVIDUALES
    // =================================================================

    public function fastEdit($rowId): void
    {
        $this->dispatch('enable-edit-for-create-user-modal', $rowId);
        Flux::modal('create-user-modal')->show();
    }

    // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES MASIVAS
    // =================================================================

    /**
     * Implementación de la acción masiva "Marcar como VIP".
     */
    public function showMassiveChangeRoleForm(): void
    {
        // 1. Obtiene los modelos de las filas seleccionadas.
        $selectedCustomers = $this->getSelectedRowsQuery()
            ->with('roles') // carga la relación
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->name];
            })
            ->toArray();

        $this->dispatch('send-selected-customers-table-records', $selectedCustomers);

        Flux::modal('update-mark-info-modal')->show();
    }
}
