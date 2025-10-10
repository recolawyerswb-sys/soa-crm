<?php

namespace App\Livewire\Business\AccessControl;

use App\Livewire\Forms\Business\AccessControl\CreateAccesscontrolRoleForm;
use App\Traits\Notifies;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class CreateRoleModalForm extends Component
{
    use Notifies;

    public Role $role;

    public CreateAccesscontrolRoleForm $form;

    public $isEditEnabled = false;

    public ?string $roleId;

    public $modalViewName = '';

    public function mount()
    {
        $this->modalViewName = 'create-access-control-role';;
    }

    public function save()
    {
        if ($this->isEditEnabled) {
            $this->form->save($this->isEditEnabled, $this->roleId);
            $this->notify('Rol actualizado correctamente');
        } else {
            $this->form->save();
            $this->notify('Rolcreado correctamente', 'Ahora asignar este rol a los usuarios');
        }
        // NOTIFICATION EVENT
        $this->dispatch('refreshTableData');
        Flux::modals()->close();
    }

    #[On('enable-edit-for-create-access-control-role-modal')]
    public function enableEdit($roleId) {
        $this->form->reset();
        $this->isEditEnabled = true;
        $this->role = Role::findOrFail($roleId);
        $this->roleId = $this->role->id;

        // AGENT FIELDS
        $this->form->name = $this->role->name;
    }

    #[On('unable-edit-for-create-access-control-role-modal')]
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
        return view('livewire.business.access-control.create-role-modal-form');
    }
}
