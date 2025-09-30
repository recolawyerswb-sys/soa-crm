<?php

namespace App\Livewire\Dashboards;

use App\Helpers\Views\MiscHelper;
use Livewire\Component;

class AdminDashboard extends Component
{
    public ?string $greetingTimeMessage = '';

    // USER STATS DATA
    public ?string $userName = '';
    public float $userTotalBalance = 0.0;
    public float $userTotalDeposit = 0.0;
    public float $userTotalWithdrawal = 0.0;
    public string $assignedAgentName = '';

    // BUSINESS STATS DATA
    public float $totalAccBalance = 0.0;
    public int $totalCustomers = 0;
    public int $totalAgents = 0;

    public function mount()
    {
        $this->greetingTimeMessage = MiscHelper::getGreeting();

        // USER DATA
        $this->userName = auth()->user()->name;
        $this->userTotalBalance = auth()->user()->getTotalBalance();
        $this->userTotalDeposit = auth()->user()->getTotalDeposit();
        $this->userTotalWithdrawal = auth()->user()->getTotalWithdrawn();

        // STATS DATA
        $this->totalAccBalance = \App\Models\Wallet::getTotalAccBalance();
        $this->totalCustomers = \App\Models\Customer::getCustomersCount();
        $this->totalAgents = \App\Models\Agent::getAgentsCount();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.dashboards.db-skeleton');
    }

    public function render()
    {
        return view('livewire.dashboards.admin-dashboard');
    }
}
