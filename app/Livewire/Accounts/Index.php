<?php

namespace App\Livewire\Accounts;

use Livewire\Component;

class Index extends Component
{
    public string $pageTitle = 'Wallets disponibles';
    public string $pageDescription = 'Maneja las wallets de tus clientres de una forma facil y rapida';

    public function render()
    {
        return view('livewire.accounts.index');
    }
}
