<?php

namespace App\Livewire\Business\Assignments;

use App\Helpers\AgentHelper;
use App\Helpers\ClientHelper;
use App\Livewire\Forms\Business\Assignments\CreateAssignmentForm;
use App\Models\Assignment;
use App\Traits\Notifies;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateAssignmentModalForm extends Component
{
    use Notifies;

    public Assignment $assignment;

    public CreateAssignmentForm $form;

    public $isEditEnabled = false;

    public ?string $assignmentId;

    public array $agents, $customers = [];

    public $modalViewName = '';

    public function mount()
    {
        $this->modalViewName = 'create-assignment';
        $this->agents = AgentHelper::getAgentsAsArrayWithIdsAsKeys();
        $this->customers = ClientHelper::getCustomersAsArrayWithIdsAsKeys();
    }

    public function save()
    {
        if ($this->isEditEnabled) {
            $this->form->save($this->isEditEnabled, $this->assignmentId);
            $this->notify('Asignacion actualizada correctamente');
        } else {
            $this->form->save();
            $this->notify('Asignacion creado correctamente', 'Ahora puede hacer seguimiento de esta asignacion');
        }
        // NOTIFICATION EVENT
        $this->dispatch('refreshTableData');
        Flux::modals()->close();
    }

    #[On('enable-edit-for-create-assignment-modal')]
    public function enableEdit($assignmentId) {
        $this->form->reset();
        $this->isEditEnabled = true;
        $this->assignment = Assignment::findOrFail($assignmentId);
        $this->assignmentId = $this->assignment->id;

        // AGENT FIELDS
        $this->form->customer_id = $this->assignment->customer_id;
        $this->form->agent_id = $this->assignment->agent_id;
        $this->form->status = $this->assignment->status;
        $this->form->notes = $this->assignment->notes;
    }

    #[On('unable-edit-for-create-assignment-modal')]
    public function unableEdit() {
        $this->isEditEnabled = false;
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.business.assignments.create-assignment-modal-form');
    }
}
