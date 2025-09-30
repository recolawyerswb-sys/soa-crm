<?php

namespace App\Livewire\Sells\Calls;

use App\Helpers\ClientHelper;
use App\Models\Customer;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class InitCallForm extends Component
{
    #[Locked]
    public $customerId;

    public ?string $full_name = ' ';

    public ?float $balance = 0.0;

    public ?string $country = ' ';

    #[Locked]
    public array $phases, $statuses = [];

    public $status, $phase = '';

    #[Computed]
    public function customer()
    {
        return Customer::find($this->customerId);
    }

    public function placeholder()
    {
        return view('livewire.placeholders.sells.call-modal-skeleton');
    }

    #[On('send-client-basic-information-for-call')]
    public function loadCustomerId($customer)
    {
        $this->customerId = $customer['id'];
        $this->full_name = $customer['full_name'];
        $this->status = $customer['status'];
        $this->country = $customer['country'];
        $this->balance = $customer['balance'];
    }

    public function mount()
    {
        $this->phases = ClientHelper::getPhases();
        $this->statuses = ClientHelper::getStatus();
    }

    public function render()
    {
        return view('livewire.sells.calls.init-call-form');
    }
}
