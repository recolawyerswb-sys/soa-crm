<?php

namespace App\Livewire\Business\Agents;

use App\Models\Agent;
use Livewire\Component;

class Show extends Component
{
    // Propiedad pública para almacenar la instancia del agente
    public Agent $agent;

    /**
     * El método mount() recibe la instancia del Agent desde la ruta.
     */
    public function mount(Agent $agent)
    {
        $this->agent = $agent;

        // Cargamos las relaciones necesarias
        $this->agent->load(['profile.user.wallet', 'team']);
    }

    public function placeholder()
    {
        return view('livewire.placeholders.profile-skeleton');
    }

    public function render()
    {
        return view('livewire.business.agents.show');
    }
}
