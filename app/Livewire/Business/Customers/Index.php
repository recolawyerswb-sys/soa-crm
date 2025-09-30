<?php

namespace App\Livewire\Business\Customers;

use Livewire\Attributes\Locked;
use Livewire\Component;

class Index extends Component
{
    #[Locked]
    public string $pageTitle = 'Lista de clientes';

    #[Locked]
    public string $pageDescription = 'Maneja tus clientes de una forma facil y rapida';

    #[Locked]
    public string $primaryBtnLabel = 'Crear cliente';

    #[Locked]
    public string $primaryModalName = 'create-client';

    public function placeholder() {
        return view('livewire.placeholders.business.customer-fp-index');
    }

    public function render()
    {
        return view('livewire.business.customers.index');
    }
}
