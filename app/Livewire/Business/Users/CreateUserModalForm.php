<?php

namespace App\Livewire\Business\Users;

use App\Helpers\RoleHelper;
use App\Livewire\Forms\Business\Users\CreateUserFom;
use App\Models\User;
use App\Traits\Notifies;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateUserModalForm extends Component
{
    use Notifies;

    public User $user;

    public CreateUserFom $form;

    public $isEditEnabled = false;

    public ?string $userId;

    public ?array $roles = [];

    public $modalViewName = '';

    public function mount()
    {
        $this->modalViewName = 'create-user-modal';
        $this->roles = RoleHelper::getRolesAsArray();
    }

    public function save()
    {
        if ($this->isEditEnabled) {
            $this->form->save($this->isEditEnabled, $this->userId);
        } else {
            $this->form->save();
        }
        // NOTIFICATION EVENT
        $this->dispatch('refreshTableData');
        $this->notify('Operacion exitosa');
        Flux::modals()->close();
    }

    #[On('enable-edit-for-create-user-modal')]
    public function enableEdit($userId) {
        $this->form->reset();
        $this->isEditEnabled = true;
        $this->user = User::findOrFail($userId)->load('roles');
        $this->userId = $this->user->id;

        // FILL THE FORM
        $this->form->name = $this->user->name;
        $this->form->email = $this->user->email;
        $this->form->role = $this->user->getCurrentRoleAsString();
    }

    #[On('unable-edit-for-create-user-modal')]
    public function unableEdit() {
        $this->isEditEnabled = false;
        $this->form->reset();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.dashboards.forms.form-skeleton');
    }


    public function render()
    {
        return view('livewire.business.users.create-user-modal-form');
    }
}
