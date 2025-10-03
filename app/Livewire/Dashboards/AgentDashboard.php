<?php

namespace App\Livewire\Dashboards;

use App\Helpers\Agent\FormatHelper;
use App\Helpers\Views\MiscHelper;
use Livewire\Component;

class AgentDashboard extends Component
{
    public ?string $greetingTimeMessage = '';

    // USER STATS DATA
    public ?string $userName = '';
    public string $dayOff = '';
    public string $checkInHour = '';
    public string $attendanceStatus = '';

    // BUSINESS STATS DATA
    public float $totalAssigned = 0;
    public int $totalCalls = 0;
    public int $totalSuccesfullCalls = 0;
    public int $totalDeclinedCalls = 0;

    public function mount()
    {
        $agent = auth()->user()->profile->agent;

        $this->greetingTimeMessage = MiscHelper::getGreeting();

        // USER DATA
        $this->userName = auth()->user()->name;
        $this->dayOff = FormatHelper::formatDayOff($agent->day_off);
        $this->checkInHour = FormatHelper::formatCheckinHour($agent->checkin_hour);
        $this->attendanceStatus = $agent->getLastAttendanceStatus();

        // STATS DATA
        $this->totalAssigned = $agent->getTotalAssignedCustomers();
        // $this->totalCalls = \App\Models\Customer::getCustomersCount();
        $this->totalCalls = 0;
        // $this->totalSuccesfullCalls = \App\Models\Agent::getAgentsCount();
        $this->totalSuccesfullCalls = 0;
        $this->totalDeclinedCalls = 0;
    }

    public function placeholder()
    {
        return view('livewire.placeholders.dashboards.db-skeleton');
    }

    public function render()
    {
        return view('livewire.dashboards.agent-dashboard');
    }
}
