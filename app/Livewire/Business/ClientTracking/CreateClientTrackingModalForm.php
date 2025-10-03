<?php

namespace App\Livewire\Business\ClientTracking;

use App\Helpers\AgentHelper;
use App\Helpers\ClientHelper;
use App\Livewire\Forms\Business\ClientTracking\CreateClientTrackingForm;
use App\Models\ClientTracking;
use App\Models\Customer;
use App\Traits\Notifies;
use Flux\Flux;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateClientTrackingModalForm extends Component
{
    use Notifies;

    public ClientTracking $clientTracking;

    public CreateClientTrackingForm $form;

    public $isEditEnabled = false;

    public ?string $clientTrackingId;

    public array $customers, $agents = [];
    // public array $agents, $origins, $phases, $statuses, $dniTypes, $types, $preferredContactMethods = [];

    public $modalViewName = '';

    public function mount()
    {
        $this->modalViewName = 'create-client-tracking';
        if (auth()->user()->isAgente()){
            $this->customers = ClientHelper::getRelatedAgentCustomersAsArrayWithIdsAsKeys();
        } else if (auth()->user()->isAdmin()) {
            $this->customers = ClientHelper::getCustomersAsArrayWithIdsAsKeys();
        }
        $this->agents = AgentHelper::getAgentsAsArrayWithIdsAsKeys();
    }

    public function save()
    {
        if ($this->isEditEnabled) {
            $this->form->save($this->isEditEnabled, $this->clientTrackingId);
        } else {
            $this->form->save();
        }
        // NOTIFICATION EVENT
        $this->dispatch('refreshTableData');
        $this->notify('Operacion exitosa');
        Flux::modals()->close();
    }

    #[On('enable-edit-for-create-client-tracking-modal')]
    public function enableEdit($clientTrackingId) {
        $this->form->reset();
        $this->isEditEnabled = true;
        $this->clientTracking = ClientTracking::findOrFail($clientTrackingId)
            ->with(['assignment'])
            ->first();
        $this->clientTrackingId = $this->clientTracking->id;

        // FILL THE FORM
        // $this->form->customer_id = $this->clientTracking->customer_id;
        $this->form->assignment_id = $this->clientTracking->assignment_id;
        $this->form->agent_id = $this->clientTracking->assignment->agent_id;
        $this->form->customer_id = $this->clientTracking->assignment->customer_id;
        $this->form->notes = $this->clientTracking->notes;
    }

    #[On('unable-edit-for-create-client-tracking-modal')]
    public function unableEdit() {
        $this->isEditEnabled = false;
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.business.client-tracking.create-client-tracking-modal-form');
    }
}
