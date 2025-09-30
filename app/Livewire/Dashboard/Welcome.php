<?php

namespace App\Livewire\Dashboard;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Welcome extends Component
{
    public function placeholder()
    {
        return view('livewire.placeholders.dashboards.welcome-placeholder');
    }

    #[Layout('components.layouts.guest')]
    public function render()
    {
        return view('livewire.dashboard.welcome');
    }
}
