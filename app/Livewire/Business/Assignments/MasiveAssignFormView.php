<?php

namespace App\Livewire\Business\Assignments;

use App\Helpers\AgentHelper;
use App\Livewire\Forms\Business\Assignments\MasiveAssignForm;
use App\Models\Customer;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MasiveAssignFormView extends Component
{
    public ?array $selectedRows, $agents = [];

    #[Validate('required|string|max:255')]
    public string $agent_id = '';

    #[Validate('string|max:255')]
    public string $notes = '';

    public $modalViewName = '';

    #[On('send-selected-customers-table-records')]
    public function loadSelectedCustomers(array $selectedRows) {
        $this->selectedRows = $selectedRows;
    }

    public function mount()
    {
        $this->modalViewName = 'massive-assignment';
        $this->agents = AgentHelper::getAgentsAsArrayWithIdsAsKeys();
    }

    public function hydrate()
    {
        $this->agents = AgentHelper::getAgentsAsArrayWithIdsAsKeys();
    }

    public function save()
    {
        $this->validate();

        foreach ($this->selectedRows as $customer_id => $name) {
            DB::transaction(function () use ($customer_id) {
                Customer::findOrFail($customer_id)->assignment()->update([
                    'agent_id' => $this->agent_id,
                    'customer_id' => $customer_id,
                    'notes' => $this->notes,
                ]);
            });
        }

        // NOTIFICATION EVENT

        $this->dispatch('refreshTableData');
        $this->reset();
        $this->dispatch('unselectTableRows');
        Flux::modals()->close();
    }

    public function render()
    {
        return view('livewire.business.assignments.masive-assign-form-view');
    }
}
