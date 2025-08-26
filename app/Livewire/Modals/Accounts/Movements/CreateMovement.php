<?php

namespace App\Livewire\Modals\Accounts\Movements;

use Livewire\Component;

class CreateMovement extends Component
{
    public string $pageTitle = 'Lista de ';
    public string $pageDescription = 'Maneja tus  de una forma facil y rapida';
    public string $primaryBtnLabel = 'Crear ';
    public string $primaryModalName = 'create-';

    public function render()
    {
        return view('livewire.modals.accounts.movements.create-movement');
    }
}
