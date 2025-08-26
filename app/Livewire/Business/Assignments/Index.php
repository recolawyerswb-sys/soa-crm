<?php

namespace App\Livewire\Business\Assignments;

use Livewire\Component;

class Index extends Component
{
    public string $pageTitle = 'Lista de asignaciones';
    public string $pageDescription = 'Maneja tus asignaciones  de una forma facil y rapida';
    public string $primaryBtnLabel = 'Crear Asignacion';
    public string $primaryModalName = 'create-assignment';

    public function render()
    {
        return view('livewire.business.assignments.index');
    }
}
