<?php

namespace App\Livewire\Business\Customers;

use Livewire\Component;

class Index extends Component
{
    public string $pageTitle = 'Lista de clientes';
    public string $pageDescription = 'Maneja tus clientes de una forma facil y rapida';
    public string $primaryBtnLabel = 'Crear cliente';
    public string $primaryModalName = 'create-client';

    public function render()
    {
        return view('livewire.business.customers.index');
    }
}
