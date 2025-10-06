<?php

namespace App\Livewire\Dashboards;

use App\Helpers\Views\MiscHelper;
use App\Models\Wallet;
use Livewire\Component;

class ClientDashboard extends Component
{
    public ?string $greetingTimeMessage = '';

    // USER STATS DATA
    public ?string $userName = '';
    public ?string $userWallet = '';
    public float $userTotalBalance = 0.0;
    public float $userTotalDeposit = 0.0;
    public float $userTotalWithdrawal = 0.0;
    public string $assignedAgentName = '';
    public ?array $details = [];

    public function mount()
    {
        $this->greetingTimeMessage = MiscHelper::getGreeting();

        // USER DATA
        $this->userName = auth()->user()->name;
        $this->userWallet = auth()->user()->wallet->id;
        $this->userTotalBalance = auth()->user()->getTotalBalance();
        $this->userTotalDeposit = auth()->user()->getTotalDeposit();
        $this->userTotalWithdrawal = auth()->user()->getTotalWithdrawn();
        $this->assignedAgentName = auth()->user()->profile->customer->assignment->agent->profile->full_name;
        $this->details = $this->getWalletDetails(auth()->user()->wallet->id);
    }

    public function getWalletDetails($walletId){
        $wallet = Wallet::findOrFail($walletId);
        $wallletDetails = [
            'wallet_id' => $wallet->id ?? 'No registrado',
            'address' => $wallet->address ?? 'No registrado',
            'coin_currency' => $wallet->coin_currency ?? 'No registrado',
            'network' => $wallet->network ?? 'No registrado',
            'last_movement_details' => $wallet->getLastMovement(),

            'bank_network' => $wallet->bank_network ?? 'No registrado',
            'account_number' => $wallet->account_number ?? 'No registrado',

            'card_number' => $wallet->card_number ? substr($wallet->card_number, -4) : 'No registrado',
            'cvc_code' => $wallet->cvc_code ?? 'No registrado',
            'exp_date' => $wallet->exp_date ? $wallet->exp_date : 'No registrado',
        ];
        return $wallletDetails;
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
