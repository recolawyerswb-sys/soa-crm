<?php

namespace App\Livewire\Modals\Assignment;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class AssignCustomersModal extends Component
{
    public function render()
    { // Un mejor ejemplo de query
        return view('livewire.modals.business.assignment.assign-customers-modal');
    }
}
