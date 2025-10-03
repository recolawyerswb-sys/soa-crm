<?php

namespace App\Livewire\Calls\Reports;

use Livewire\Component;

class Index extends Component
{
    public string $pageTitle = 'Reportes locales de llamadas';
    public string $pageDescription = 'Visualiza las llamadas hechas y cambios en clientes importantes';

    public function placeholder() {
        return view('livewire.placeholders.business.customer-fp-index');
    }

    public function render()
    {
        return view('livewire.calls.reports.index');
    }
}
