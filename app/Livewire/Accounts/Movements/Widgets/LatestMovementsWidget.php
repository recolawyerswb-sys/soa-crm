<?php

namespace App\Livewire\Accounts\Movements\Widgets;

use App\Enums\Accounts\Movements\MovementStatus;
use App\Enums\Accounts\Movements\MovementType;
use App\Livewire\SoaTable\Light\LightAction;
use App\Livewire\SoaTable\Light\LightColumn;
use App\Livewire\SoaTable\Light\SoaTableLight;
use App\Models\Movement;
use App\Traits\Notifies;
use Flux\Flux;
use Livewire\Attributes\On;

class LatestMovementsWidget extends SoaTableLight
{
    use Notifies;

    protected string $model = Movement::class;
    public string $title = 'Últimos Movimientos Por Aprobar'; // Set the widget title

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        // Traemos solo los 5 últimos movimientos con sus relaciones
        return Movement::query()
            ->with(['wallet.user'])
            ->where('status', '2')
            ->latest()
            ->take(10);
    }

    protected function columns(): array
    {
        return [
            LightColumn::make('Cliente', 'wallet.user.name'),
            LightColumn::make('Monto', 'amount')
                ->currency(),
            LightColumn::make('Tipo', 'type')
                ->badge(function ($row) {
                    return match ($row->type) {
                        MovementType::DEPOSIT->value => ['color' => 'teal', 'label' => 'Deposito'],
                        MovementType::WITHDRAWAL->value => ['color' => 'red', 'label' => 'Retiro'],
                        MovementType::BONUS->value => ['color' => 'indigo', 'label' => 'Bono'],
                        default => ['color' => 'gray', 'label' => $row->status],
                    };
                }),
            LightColumn::make('Estado', 'status')
                ->badge(function ($row) {
                    // Tu lógica de `match` va aquí.
                    // Debe retornar un array con 'color' y 'label'.
                    return match ($row->status) {
                        MovementStatus::APPROVED->value => ['color' => 'green', 'label' => 'Aprobado'],
                        MovementStatus::PENDING->value => ['color' => 'yellow', 'label' => 'Pendiente'],
                        MovementStatus::REJECTED->value => ['color' => 'red', 'label' => 'Rechazado'],
                        default => ['color' => 'gray', 'label' => $row->status],
                    };
                })->canSee(fn() => auth()->user()->isAdmin()),
            LightColumn::make('Fecha', 'created_at')
                ->date(),
        ];
    }

    #[On('light-approve-movement')]
    public function approveMovement($id, string $note = 'Aprobado desde el widget'): void
    {
        $movement = Movement::findOrFail($id);
        $movement->approve($note);
        $this->dispatch('refreshLightTableData');
        Flux::modal('generic-confirmation-modal')->close();
        $this->notify('Movimiento aprobado correctamente.');
    }

    #[On('light-decline-movement')]
    public function declineMovement($id, string $note = 'Rechazado desde el widget'): void
    {
        $movement = Movement::findOrFail($id);
        $movement->decline($note);
        $this->dispatch('refreshLightTableData');
        Flux::modal('generic-confirmation-modal')->close();
        $this->notify('Movimiento rechazado correctamente.', status: '400');
    }

    protected function actions(): array
    {
        return [
            // Acción #2: Un botón que ejecuta lógica en el backend
            LightAction::make('Aprobar')
                ->canSee(fn($row) => auth()->user()->isAdmin()) // Solo mostrar si está pendiente
                ->bgBtn('green')
                ->exec(function (Movement $movement) {
                    if ($movement->status !== '2') {
                        $this->notify('Solo se pueden aprobar movimientos pendientes.', status: '400');
                        return;
                    }
                    // FILL CONFIRMATION MODAL PROPS
                    $this->dispatch('fill-confirmation-modal-props', [
                        'actionTitleName' => 'aprobar este movimiento',
                        'actionBtnLabel' => 'aprobar',
                        'actionEventName' => 'light-approve-movement',
                        'actionEnableNote' => true
                    ], $movement->id);
                    // CALL MODAL
                    Flux::modal('generic-confirmation-modal')->show();
                }),

            LightAction::make('Rechazar')
                ->canSee(fn($row) => auth()->user()->isAdmin()) // Solo mostrar si está pendiente
                ->bgBtn('red')
                ->exec(function (Movement $movement) {
                    if ($movement->status !== '2') {
                        $this->notify('Solo se pueden aprobar movimientos pendientes.', status: '400');
                        return;
                    }
                    // FILL CONFIRMATION MODAL PROPS
                    $this->dispatch('fill-confirmation-modal-props', [
                        'actionTitleName' => 'rechazar este movimiento',
                        'actionBtnLabel' => 'rechazar',
                        'actionEventName' => 'light-decline-movement',
                        'actionEnableNote' => true
                    ], $movement->id);
                    // CALL MODAL
                    Flux::modal('generic-confirmation-modal')->show();
                }),
        ];
    }
}
