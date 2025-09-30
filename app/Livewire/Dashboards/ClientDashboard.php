<?php

namespace App\Livewire\Dashboards;

use App\Helpers\Views\MiscHelper;
use Livewire\Component;

class ClientDashboard extends Component
{
    public ?string $greetingTimeMessage = '';

    // USER STATS DATA
    public ?string $userName = '';
    public float $userTotalBalance = 0.0;
    public float $userTotalDeposit = 0.0;
    public float $userTotalWithdrawal = 0.0;
    public string $assignedAgentName = '';

    public function mount()
    {
        $this->greetingTimeMessage = MiscHelper::getGreeting();

        // USER DATA
        $this->userName = auth()->user()->name;
        $this->userTotalBalance = auth()->user()->getTotalBalance();
        $this->userTotalDeposit = auth()->user()->getTotalDeposit();
        $this->userTotalWithdrawal = auth()->user()->getTotalWithdrawn();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.dashboards.db-skeleton');
    }
    public function render()
    {
        return view('livewire.dashboards.client-dashboard');
        // return view('livewire.placeholders.dashboards.client.client-placeholder-skeleton');
    }
}
