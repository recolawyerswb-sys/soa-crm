<?php

namespace App\Livewire\Business\Customers;

use App\Helpers\AgentHelper;
use App\Helpers\ClientHelper;
use App\Livewire\Forms\Business\Customers\CreateForm;
use App\Models\Customer;
use App\Models\User;
use App\Traits\Notifies;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class CreateClientModalForm extends Component
{
    use Notifies;

    public Customer $customer;

    public CreateForm $form;

    public $isEditEnabled = false;

    public ?string $customerId;

    public array $agents, $origins, $phases, $statuses, $dniTypes, $types, $preferredContactMethods = [];

    public $modalViewName = '';

    public function mount()
    {
        $this->modalViewName = 'create-client';
        $this->agents = AgentHelper::getAgentsAsArrayWithIdsAsKeys();
        $this->origins = ClientHelper::getOrigins();
        $this->phases = ClientHelper::getPhases();
        $this->statuses = ClientHelper::getStatus();
        $this->dniTypes = ClientHelper::getDniTypes();
        $this->types = ClientHelper::getTypes();
        $this->preferredContactMethods = ClientHelper::getPreferredContactMethods();
    }

    public function save()
    {
        if ($this->isEditEnabled) {
            $this->form->save($this->isEditEnabled, $this->customerId);
        } else {
            $this->form->save();
        }
        // NOTIFICATION EVENT
        $this->dispatch('refreshTableData');
        $this->notify('Operacion exitosa');
        Flux::modals()->close();
    }

    #[On('enable-edit-for-create-client-modal')]
    public function enableEdit($customerId) {
        $this->form->reset();
        $this->isEditEnabled = true;
        $this->customer = Customer::with(['profile', 'assignment'])->findOrFail($customerId);
        $this->customerId = $this->customer->id;

        // FILL THE FORM
        $this->form->full_name = $this->customer->profile->full_name;
        $this->form->email = $this->customer->profile->user->email;
        $this->form->phone_1 = $this->customer->profile->phone_1;
        $this->form->phone_2 = $this->customer->profile->phone_2;
        $this->form->preferred_contact_method = $this->customer->profile->preferred_contact_method;
        $this->form->country = $this->customer->profile->country;
        $this->form->city = $this->customer->profile->city;
        $this->form->address = $this->customer->profile->address;
        $this->form->dni_type = $this->customer->profile->dni_type;
        $this->form->dni_number = $this->customer->profile->dni_number;
        $this->form->birthdate = $this->customer->profile->birthdate?->format('Y-m-d');
        $this->form->type = $this->customer->type;
        $this->form->phase = $this->customer->phase;
        $this->form->origin = $this->customer->origin;
        $this->form->status = $this->customer->status;

        $this->form->agent_id = $this->customer->assignment->agent_id ?? null;
    }

    #[On('unable-edit-for-create-client-modal')]
    public function unableEdit() {
        $this->isEditEnabled = false;
        $this->form->reset();
    }

    #[On('setPhoneValue')]
    public function setPhoneValue($model, $value)
    {
        // Usamos la función data_set para asignar el valor dinámicamente.
        // Esto funciona perfectamente para propiedades anidadas como 'form.telefono1'.
        data_set($this, $model, $value);
    }

    public function render()
    {
        return view('livewire.business.customers.create-client-modal-form');
    }
}
