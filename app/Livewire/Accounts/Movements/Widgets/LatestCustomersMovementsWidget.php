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
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class LatestCustomersMovementsWidget extends SoaTableLight
{
    use Notifies;

    protected string $model = Movement::class;
    public string $title = 'Tus ultimos ultimos movimientos'; // Set the widget title

    public function query(): Builder
    {
        if (auth()->check() && auth()->user()->isCliente()) {
            // Obtenemos el ID del usuario actual para usarlo en la consulta.
            $userId = auth()->id();

            // Traemos solo los 10 últimos movimientos del cliente actual.
            return Movement::query()
                // AÑADIDO: Filtra los movimientos que pertenecen a una billetera
                // donde el 'user_id' coincide con el del usuario autenticado.
                ->whereHas('wallet', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->with(['wallet.user'])
                ->latest()
                ->take(10);
        }
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
                }),
            LightColumn::make('Fecha', 'created_at')
                ->date(),
        ];
    }

    protected function actions(): array
    {
        return [
            //
        ];
    }
}
