<?php

namespace App\Livewire\Business\ClientTracking;

use Livewire\Component;

class Index extends Component
{
    public string $pageTitle = 'Lista de seguimientos';
    public string $pageDescription = 'Maneja tus seguimientos de una forma facil y rapida';
    public string $primaryBtnLabel = 'Crear seguimiento';
    public string $primaryModalName = 'create-client-tracking';

    public function placeholder() {
        return view('livewire.placeholders.business.customer-fp-index');
    }

    public function render()
    {
        return view('livewire.business.client-tracking.index');
    }
}
