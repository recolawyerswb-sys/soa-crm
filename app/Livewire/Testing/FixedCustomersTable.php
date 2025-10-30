<?php

namespace App\Livewire\Testing;

use App\Helpers\ClientHelper;
use App\Http\Controllers\CallController;
use App\Livewire\SoaTable\Column;
use App\Livewire\SoaTable\Action;
use App\Livewire\SoaTable\BulkAction;
use App\Livewire\SoaTable\Filter;
use App\Livewire\SoaTable\SoaTable;
use App\Models\Customer;
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

// Heredamos de nuestra clase base LivewireTable
class FixedCustomersTable extends SoaTable
{

    // protected $listeners = ['reloadCustomersTable' => '$refresh'];

    /**
     * Define el modelo de Eloquent para esta tabla.
     */
    protected string $model = Customer::class;

    public string $title = 'Registros actuales';

    public ?string $viewRouteName = 'business.customers.edit';
    // public string $description = 'Lista de equipos con sus respectivos agentes y clientes.';

    /**
     * Define la consulta base para la tabla.
     * Aquí puedes añadir joins, scopes, etc.
     */
    public function query(): Builder
    {
        return Customer::query()
            ->with(['assignment.agent.profile', 'profile.user.wallet'])
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
            Column::make('Email', 'profile.user.email')
                ->searchable()
                ->canSee(fn () => Auth::user()->isAdmin()),
            Column::make('Fase', 'phase'),
        ];
    }

    /**
     * Define las acciones disponibles para cada fila.
     */
    protected function additionalActions():  array
    {
        return [
            Action::make('showDetails', 'eye')
                ->label('Ver detalles')
                ->canSee(fn() => auth()->user()->isAdmin()),
            Action::make('fastEdit', 'pencil')
                ->label('Editar')
                ->canSee(fn () => auth()->user()->isAdmin()),
        ];
    }

    /**
     * Define las acciones masivas adicionales para esta tabla.
     * "Eliminar Seleccionados" se hereda automáticamente desde el Trait.
     */
    protected function additionalBulkActions(): array
    {
        return [
            BulkAction::make('Cambiar Estados', 'showMassiveChangePhaseForm'),
            BulkAction::make('Asignacion Multiple', 'showMassiveAssignForm'),
        ];
    }

    protected function filters(): array
    {
        return [

            // Filtro de botones para el estado
            Filter::make(
                key: 'phase',
                label: 'Fase',
                options: ClientHelper::getPhases(),
                column: 'phase'
            ),
        ];
    }

    // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES INDIVIDUALES
    // =================================================================

    public function showDetails(Customer $customer)
    {
        return redirect(route('business.customers.show', $customer));
    }

    public function fastEdit($rowId): void
    {
        $this->dispatch('enable-edit-for-create-client-modal', $rowId);
        Flux::modal('create-client')->show();
    }

    public function noAnswerAction($rowId): void
    {
        dd("Sin respuesta para agregar nota y seguimiento junto a cambio de estado noAnswer: {$rowId}");
    }

    public function sendWpMessage(Customer $customer)
    {
        return redirect("https://wa.me/" . substr($customer->profile->phone_1, 1));
    }

    public function makeCall(Customer $customer): void
    {
        $preCustomer = [
            'id' => $customer->id,
            'full_name' => $customer->profile->full_name,
            'country' => $customer->profile->country,
            'status' => $customer->status,
            'balance' => $customer->profile->user->wallet->balance,
        ];
        $this->dispatch('send-client-basic-information-for-call', $preCustomer);
        Flux::modal('init-call')->show();
    }

    // =================================================================
    // MÉTODOS PÚBLICOS PARA LAS ACCIONES MASIVAS
    // =================================================================

    /**
     * Implementación de la acción masiva "Marcar como VIP".
     */
    public function showMassiveChangePhaseForm(): void
    {
        // 1. Obtiene los modelos de las filas seleccionadas.
        $selectedCustomers = $this->getSelectedRowsQuery()
            ->with('profile') // carga la relación
            ->get()
            ->mapWithKeys(function ($customer) {
                return [$customer->id => $customer->profile?->full_name];
            })
            ->toArray();

        $this->dispatch('send-selected-customers-table-records', $selectedCustomers);

        Flux::modal('update-mark-info-modal')->show();
    }

    /**
     * Implementación de la acción masiva "Asignar a Agente Top".
     */
    public function showMassiveAssignForm()
    {
        // $selectedCustomers = $this->getSelectedRowsQuery()->with('profile')->pluck('profile.full_name', 'id')->toArray();

        $selectedCustomers = $this->getSelectedRowsQuery()
            ->with('profile') // carga la relación
            ->get()
            ->mapWithKeys(function ($customer) {
                return [$customer->id => $customer->profile?->full_name];
            })
            ->toArray();

        $this->dispatch('send-selected-customers-table-records', $selectedCustomers);

        Flux::modal('massive-assignment')->show();
    }
}
