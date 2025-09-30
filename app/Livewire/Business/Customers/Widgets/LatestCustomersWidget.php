<?php

namespace App\Livewire\Business\Customers\Widgets;

use App\Helpers\ClientHelper;
use App\Livewire\SoaTable\Column;
use App\Livewire\SoaTable\Action;
use App\Livewire\SoaTable\BulkAction;
use App\Livewire\SoaTable\Filter;
use App\Livewire\SoaTable\Light\LightAction;
use App\Livewire\SoaTable\Light\LightColumn;
use App\Livewire\SoaTable\Light\SoaTableLight;
use App\Models\Customer;
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

// Heredamos de nuestra clase base LivewireTable
class LatestCustomersWidget extends SoaTableLight
{

    /**
     * Define el modelo de Eloquent para esta tabla.
     */
    protected string $model = Customer::class;

    public string $title = 'Ultimos Clientes Registrados';

    /**
     * Define la consulta base para la tabla.
     * Aquí puedes añadir joins, scopes, etc.
     */
    public function query(): Builder
    {
        // Usamos el modelo definido para iniciar la consulta.
        // Puedes agregar relaciones que necesites con with().
        return Customer::query()
            ->with(['profile'])
            ->latest()
            ->take(10);
    }

    /**
     * Define las columnas que se mostrarán en la tabla.
     */
    protected function columns(): array
    {
        return [
            LightColumn::make('Nombre', 'profile.full_name'),
            LightColumn::make('Fecha', 'created_at')
                ->date(),
        ];
    }

    protected function actions(): array
    {
        return [
            // Acción #2: Un botón que ejecuta lógica en el backend
            LightAction::make('Ver detalles', 'business.customers.show')
                ->foreground('dark:text-indigo-300 text-indigo-500 hover:underline')
                ->canSee(fn($row) => auth()->user()->isAdmin()),
        ];
    }
}
