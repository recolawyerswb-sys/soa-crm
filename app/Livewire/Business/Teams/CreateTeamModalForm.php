<?php

namespace App\Livewire\Business\Teams;

use App\Livewire\Forms\Business\Teams\CreateTeamForm;
use App\Models\Team;
use App\Traits\Notifies;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateTeamModalForm extends Component
{

    use Notifies;

    public Team $team;

    public CreateTeamForm $form;

    public $isEditEnabled = false;

    public ?string $teamId;

    public $modalViewName = '';

    public function mount()
    {
        $this->modalViewName = 'create-team';
    }

    public function save()
    {
        if ($this->isEditEnabled) {
            $this->form->save($this->isEditEnabled, $this->teamId);
            $this->notify('Equipo actualizado correctamente');
        } else {
            $this->form->save();
            $this->notify('Equipo creado correctamente', 'Ahora puede incluir agentes en este equipo');
        }
        // NOTIFICATION EVENT
        $this->dispatch('refreshTableData');
        Flux::modals()->close();
    }

    #[On('enable-edit-for-create-team-modal')]
    public function enableEdit($teamId) {
        $this->form->reset();
        $this->isEditEnabled = true;
        $this->team = Team::findOrFail($teamId);
        $this->teamId = $this->team->id;

        // AGENT FIELDS
        $this->form->name = $this->team->name;
        $this->form->description = $this->team->description;
        $this->form->slogan = $this->team->slogan;
        $this->form->color_code = $this->team->color_code;
    }

    #[On('unable-edit-for-create-team-modal')]
    public function unableEdit() {
        $this->isEditEnabled = false;
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.business.teams.create-team-modal-form');
    }
}
