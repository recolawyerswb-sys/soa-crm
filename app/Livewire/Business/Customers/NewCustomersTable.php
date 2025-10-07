<?php

namespace App\Livewire\Business\Customers;

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
class NewCustomersTable extends SoaTable
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
        $customerQuery = '';

        switch (auth()->check()) {
            case auth()->user()->isAgente():
            $agentId = auth()->user()->profile->agent->id;
            // RETRIEVE RELATED AGENT RESULTS
            $customerQuery = Customer::query()
                ->whereHas('assignment', function ($query) use ($agentId) {

                    // Dentro de esta función, $query es una consulta sobre el modelo Assignment.
                    // Aquí es donde filtramos las asignaciones para que solo nos quedemos
                    // con las que pertenecen al agente actual.
                    // NOTA: Asegúrate de que la columna en tu tabla 'assignments'
                    // que guarda la relación con el agente se llame 'agent_id'.
                    // Si tiene otro nombre, simplemente ajústalo aquí.
                    $query->where('agent_id', $agentId);

                })
                ->with(['assignment.agent.profile', 'profile.user.wallet'])
                ->orderByDesc('id');
            break;
            case auth()->user()->isAdmin():
            // RETRIEVE ALL RESULTS
            $customerQuery = Customer::query()
                ->with(['assignment.agent.profile', 'profile.user.wallet'])
                ->orderByDesc('id');
            break;
        }
        // Usamos el modelo definido para iniciar la consulta.
        // Puedes agregar relaciones que necesites con with().
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
            Column::make('Nombre', 'profile.full_name')
                ->searchable(),
            Column::make('Email', 'profile.user.email')
                ->searchable()
                ->canSee(fn () => Auth::user()->isAdmin()),
            Column::make('Fase', 'phase'),
            Column::make('Origen', 'origin'),
            Column::make('Estado', 'status'),
            Column::make('Tipo de cliente', 'type'),
            Column::make('Numero principal', 'profile.phone_1')
                ->copyable()
                ->canSee(fn () => Auth::user()->isAdmin()),
            Column::make('Llamadas totales', 'no_calls')
                ->sortable(),
            Column::make(__('Asignado a'), 'assignment.agent.profile.full_name'),
            // Column::make(__('ID Wallet'), 'profile.user.wallet.id'),
            Column::make(__('Saldo'), 'profile.user.wallet.balance')
                ->currency(),
        ];
    }

    /**
     * Define las acciones disponibles para cada fila.
     */
    protected function additionalActions():  array
    {
        return [
            // // Action::make('Llamar', 'makeCall')
            // //     ->classes('text-green-600 hover:text-green-900 font-bold'), // Clases personalizadas
            // Action::make('noAnswerAction', 'chat-bubble-bottom-center-text')
            //     ->canSee(fn () => Auth::user()->isAdmin()),
            Action::make('showDetails', 'eye')
                ->label('Ver detalles')
                ->canSee(fn() => auth()->user()->isAdmin()),
            Action::make('fastEdit', 'pencil')
                ->label('Editar')
                ->canSee(fn () => auth()->user()->isAdmin()),
            Action::make('makeCall', 'phone')
                ->label('Llamar'),
            Action::make('sendWpMessage', 'chat-bubble-oval-left-ellipsis')
                ->label('Abrir Whatsapp')
                ->link(fn (Customer $customer) => 'https://wa.me/'.$customer->profile->phone_1)
                ->canSee(fn() => auth()->user()->isAdmin()),
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
            Filter::make(
                key: 'origin',
                label: 'Origen',
                options: ClientHelper::getOrigins(),
                column: 'origin'
            ),
            Filter::make(
                key: 'status',
                label: 'Estado',
                options: ClientHelper::getStatus(),
                column: 'status'
            ),
            Filter::make(
                key: 'type',
                label: 'Tipo',
                options: ClientHelper::getTypes(),
                column: 'type'
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
