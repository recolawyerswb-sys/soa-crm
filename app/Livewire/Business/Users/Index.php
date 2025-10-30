<?php

namespace App\Livewire\Business\Users;

use Livewire\Component;

class Index extends Component
{
    public string $pageTitle = 'Lista de usuarios';
    public string $pageDescription = 'Maneja tus usuarios de una forma facil y rapida';
    public string $primaryBtnLabel = 'Crear nuevo usuario';
    public string $primaryModalName = 'create-user-modal';

    public function render()
    {
        return view('livewire.business.users.index');
    }
}
