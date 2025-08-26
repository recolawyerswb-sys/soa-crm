<?php

namespace App\Livewire\Business\Teams;

use Livewire\Component;

class Index extends Component
{
    public string $pageTitle = 'Lista de equipos';
    public string $pageDescription = 'Maneja tus equipos de una forma facil y rapida';
    public string $primaryBtnLabel = 'Crear equipo';
    public string $primaryModalName = 'create-team';

    public function render()
    {
        return view('livewire.business.teams.index');
    }
}
