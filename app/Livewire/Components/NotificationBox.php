<?php

namespace App\Livewire\Components;

use Livewire\Component;

class NotificationBox extends Component
{
    public $type = 'success'; // Default type can be 'success', 'error', 'info', etc.
    public $message = '';

    public function render()
    {
        return view('livewire.components.notification-box');
    }
}
