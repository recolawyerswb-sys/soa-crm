<?php

namespace App\Livewire\Business\AccessControl;

use Livewire\Component;

class Index extends Component
{
    public string $pageTitle = 'Lista de roles';
    public string $pageDescription = 'Maneja tus roles de una forma facil y rapida';
    public string $primaryBtnLabel = 'Crear rol';
    public string $primaryModalName = 'create-access-control-role';

    public function render()
    {
        return view('livewire.business.access-control.index');
    }
}
