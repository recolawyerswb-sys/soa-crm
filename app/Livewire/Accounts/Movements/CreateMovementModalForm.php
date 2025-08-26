<?php

namespace App\Livewire\Accounts\Movements;

use App\Livewire\Forms\Accounts\Movements\CreateMovementForm;
use App\Models\Movement;
use App\Traits\Notifies;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateMovementModalForm extends Component
{
    use Notifies;

    public Movement $movement;

    public CreateMovementForm $form;

    public $isEditEnabled = false;

    public ?string $movementId;

    public string $authUser, $authUserBalance = '';

    public array $types = [];

    public $modalViewName = '';

    public function mount()
    {
        $this->modalViewName = 'create-movement-modal';
        $this->authUser = auth()->user()->name;
        $this->authUserBalance = auth()->user()->wallet->balance;
        $this->types = \App\Helpers\MovementHelper::getTypes();
    }

    public function save()
    {
        if ($this->isEditEnabled) {
            $this->form->save($this->isEditEnabled, $this->movementId);
        } else {
            $this->form->save();
        }
        // NOTIFICATION EVENT
        $this->dispatch('refreshTableData');
        $this->notify('Movimiento creado exitosamente');
        Flux::modals()->close();
    }

    #[On('enable-edit-for-create-movement-modal')]
    public function enableEdit($movementId) {
        $this->form->reset();
        $this->isEditEnabled = true;
        $this->movement = Movement::findOrFail($movementId);
        $this->movementId = $this->movement->id;

        // FILL THE FORM
        $this->form->amount = $this->movement->amount;
        $this->form->type = $this->movement->type;
        $this->form->note = $this->movement->note;
    }

    #[On('unable-edit-for-create-movement-modal')]
    public function unableEdit() {
        $this->isEditEnabled = false;
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.accounts.movements.create-movement-modal-form');
    }
}
