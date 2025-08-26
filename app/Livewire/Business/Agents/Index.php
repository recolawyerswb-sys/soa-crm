<?php

namespace App\Livewire\Business\Agents;

use Livewire\Component;

class Index extends Component
{
    public string $pageTitle = 'Lista de agentes';
    public string $pageDescription = 'Maneja tus agentes de una forma facil y rapida';
    public string $primaryBtnLabel = 'Crear agente';
    public string $primaryModalName = 'create-agent';

    public function render()
    {
        return view('livewire.business.agents.index');
    }
}
