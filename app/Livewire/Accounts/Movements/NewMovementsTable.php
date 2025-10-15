<?php

namespace App\Livewire\Accounts\Movements;

use App\Livewire\SoaTable\Column;
use App\Livewire\SoaTable\Action;
use App\Livewire\SoaTable\Filter;
use App\Livewire\SoaTable\SoaTable;
use App\Models\Movement;
use App\Models\Wallet;
use App\Traits\Notifies;
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

// Heredamos de nuestra clase base LivewireTable
class NewMovementsTable extends SoaTable
{

    use Notifies;

    /**
     * Define el modelo de Eloquent para esta tabla.
     */
    protected string $model = Movement::class;

    public string $title = 'Registros actuales';

    public bool $enableSearch = false;

    /**
     * Define la consulta base para la tabla.
     * Aquí puedes añadir joins, scopes, etc.
     */
    public function query(): Builder
    {
        // Usamos el modelo definido para iniciar la consulta.
        // Puedes agregar relaciones que necesites con with().
        return Movement::query()
            // ->where('wallet_id', auth()->user()->wallet->id)
            ->with(['wallet.user'])
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
            Column::make('Cliente solicitante', 'wallet.user.name')
                ->searchable(),
            Column::make('Direccion de la wallet', 'wallet.address')
                ->searchable(),
            // Column::make('Tipo', 'type')
            //     ->searchable(),
            Column::makeView('Tipo', 'livewire.accounts.movements.table.type-column'),
            Column::makeView('Estado', 'livewire.accounts.movements.table.status-column'),
            Column::make('Monto', 'amount')
                ->currency()
                ->addClasses('font-bold'),
            Column::make('Fecha de solicitud', 'created_at')
                ->date()
                ->sortable(),
            Column::make('Notas', 'note')
                ->addClasses('font-bold'),
        ];
    }

    protected function enableActions(): bool
    {
        return auth()->user()->isAdmin() ? true : false; // Habilitado por defecto
    }

    /**
     * Define las acciones disponibles para cada fila.
     */
    protected function additionalActions(): array
    {
        return [
            // Action::make('fastEdit', 'pencil'),
            Action::make('approve', 'hand-thumb-up')
                ->label('Aprobar'),
            Action::make('decline', 'hand-thumb-down')
                ->label('Rechazar'),
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
            // Filtro de botones para el estado

            Filter::makeInput(
                key: 'CustomerName',
                label: 'Cliente',
                column: 'wallet.user.name'
            ),

            Filter::make(
                key: 'type',
                label: 'Tipo',
                options: [
                    '1' => 'Deposito',
                    '2' => 'Retiro',
                    '3' => 'Bono',
                ],
                column: 'type'
            ),

            Filter::make(
                key: 'status',
                label: 'Estado',
                options: [
                    '1' => 'Aprobado',
                    '2' => 'Pendiente',
                    '0' => 'Rechazado',
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
        $this->dispatch('enable-edit-for-create-movement-modal', $rowId);
        Flux::modal('create-movement-modal')->show();
    }

    public function approve(Movement $movement): void
    {
        if ($movement->status !== '2') {
            $this->notify('Este movimiento ya fue aprobado.', status: '100');
            return;
        }
        // FILL CONFIRMATION MODAL PROPS
        $this->dispatch('fill-confirmation-modal-props', [
            'actionTitleName' => 'aprobar este movimiento',
            'actionBtnLabel' => 'aprobar',
            'actionEventName' => 'approve-movement',
        ], $movement->id);
        // CALL MODAL
        Flux::modal('generic-confirmation-modal')->show();
    }

    public function decline(Movement $movement): void
    {
        if ($movement->status !== '2') {
            $this->notify('Este movimiento ya fue aprobado.', status: '100');
            return;
        }
        // FILL CONFIRMATION MODAL PROPS
        $this->dispatch('fill-confirmation-modal-props', [
            'actionTitleName' => 'rechazar este movimiento',
            'actionBtnLabel' => 'rechazar',
            'actionEventName' => 'decline-movement',
        ], $movement->id);
        // CALL MODAL
        Flux::modal('generic-confirmation-modal')->show();
    }

    #[On('approve-movement')]
    public function approveMovement($id): void
    {
        $movement = Movement::findOrFail($id);
        $movement->approve();
        $this->dispatch('refreshTableData');
        Flux::modal('generic-confirmation-modal')->close();
        $this->notify('Movimiento aprobado correctamente.');
    }

    #[On('decline-movement')]
    public function declineMovement($id): void
    {
        $movement = Movement::findOrFail($id);
        $movement->decline();
        $this->dispatch('refreshTableData');
        Flux::modal('generic-confirmation-modal')->close();
        $this->notify('Movimiento rechazado correctamente.', status: '400');
    }

    // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES MASIVAS
    // =================================================================
}
