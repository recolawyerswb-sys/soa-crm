<?php

namespace App\Livewire\Modals\Assignment;

use Livewire\Component;

class FastAssign extends Component
{
    public string $agent = '';

    public function updateAssignment(): void
    {
        // Logic for fast assignment can be added here
        // This method can be used to handle the assignment logic
        dd($this->all());
    }

    public function render()
    {
        return view('livewire.modals.business.assignment.fast-assign');
    }
}
