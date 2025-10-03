<?php

namespace App\Livewire\Business\Agents;

use App\Helpers\AgentHelper;
use App\Helpers\ClientHelper;
use App\Helpers\TeamHelper;
use App\Livewire\Forms\Business\Agents\CreateAgentForm;
use App\Models\Agent;
use App\Traits\Notifies;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateAgentModalForm extends Component
{
    use Notifies;

    public Agent $agent;

    public CreateAgentForm $form;

    public $isEditEnabled = false;

    public ?string $agentId;

    public array $teams, $positions, $dniTypes, $preferredContactMethods = [];

    public $modalViewName = '';

    public function mount()
    {
        $this->modalViewName = 'create-agent';
        $this->dniTypes = ClientHelper::getDniTypes();
        $this->teams = TeamHelper::getTeamsAsArrayWithIdsAsKeys();
        $this->preferredContactMethods = ClientHelper::getPreferredContactMethods();
        $this->positions = AgentHelper::getPositionsOptions();
    }

    public function save()
    {
        if ($this->isEditEnabled) {
            $this->form->save($this->isEditEnabled, $this->agentId);
            $this->notify('Agente actualizado correctamente');
        } else {
            $this->form->save();
            $this->notify('Agente creado correctamente', 'Ahora puede asignar clientes a este agente');
        }
        // NOTIFICATION EVENT
        $this->dispatch('refreshTableData');
        Flux::modals()->close();
    }

    #[On('enable-edit-for-create-agent-modal')]
    public function enableEdit($agentId) {
        $this->form->reset();
        $this->isEditEnabled = true;
        $this->agent = Agent::with(['profile', 'team'])->findOrFail($agentId);
        $this->agentId = $this->agent->id;

        // FILL THE FORM
        $this->form->full_name = $this->agent->profile->full_name;
        $this->form->email = $this->agent->profile->user->email;
        $this->form->phone_1 = $this->agent->profile->phone_1;
        $this->form->phone_2 = $this->agent->profile->phone_2;
        $this->form->preferred_contact_method = $this->agent->profile->preferred_contact_method;
        $this->form->country = $this->agent->profile->country;
        $this->form->city = $this->agent->profile->city;
        $this->form->address = $this->agent->profile->address;
        $this->form->dni_type = $this->agent->profile->dni_type;
        $this->form->dni_number = $this->agent->profile->dni_number;
        $this->form->birthdate = $this->agent->profile->birthdate?->format('Y-m-d');

        // AGENT FIELDS
        $this->form->position = $this->agent->position;
        $this->form->status = $this->agent->status;
        $this->form->day_off = $this->agent->day_off;
        $this->form->checkin_hour = $this->agent->checkin_hour?->format('H:i');
        $this->form->is_leader = $this->agent->is_leader;
        $this->form->team_id = $this->agent->team_id;
    }

    #[On('unable-edit-for-create-agent-modal')]
    public function unableEdit() {
        $this->isEditEnabled = false;
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.business.agents.create-agent-modal-form');
    }
}
