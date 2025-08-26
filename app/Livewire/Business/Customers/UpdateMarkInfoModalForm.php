<?php

namespace App\Livewire\Business\Customers;

use App\Helpers\ClientHelper;
use App\Livewire\SoaNotification\SoaNotification;
use App\Models\Customer;
use App\Traits\Notifies;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateMarkInfoModalForm extends Component
{
    use Notifies;

    #[Validate('string')]
    public ?string $phase = '';

    #[Validate('string')]
    public ?string $status = '';

    #[Validate('string')]
    public ?string $origin = '';

    public ?array $selectedRows = [];

    public $modalViewName = '';

    #[On('send-selected-customers-table-records')]
    public function loadSelectedCustomers(array $selectedRows) {
        $this->selectedRows = $selectedRows;
    }

    public function mount()
    {
        $this->modalViewName = 'massive-change-phase';
    }

    public function save()
    {
        $this->validate();

        foreach ($this->selectedRows as $customerId => $name) {
            # code...
            DB::transaction(function () use ($customerId) {
                $customer = Customer::findOrFail($customerId);

                // Lista de campos que queremos validar y actualizar dinámicamente
                $fields = ['phase', 'origin', 'status'];

                $updateData = collect($fields)
                    ->filter(fn($field) => !empty($this->{$field})) // solo campos no vacíos
                    ->mapWithKeys(fn($field) => [$field => $this->{$field}])
                    ->toArray();

                if (!empty($updateData)) {
                    $customer->update($updateData);
                }
            });
        }

        $this->dispatch('refreshTableData');
        $this->reset();
        $this->dispatch('unselectTableRows');
        $this->notify('Exito', status: '200');
        Flux::modals()->close();
    }

    public function render()
    {
        return view('livewire.business.customers.update-mark-info-modal-form', [
            'phases' => ClientHelper::getPhases(),
            'origins' => ClientHelper::getOrigins(),
            'statuses' => ClientHelper::getStatus(),
        ]);
    }
}
