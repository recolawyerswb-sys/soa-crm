<?php

namespace App\Livewire\Forms\Accounts;

use App\Livewire\Forms\CustomTranslatedForm;
use App\Livewire\SoaNotification\Notify;
use App\Livewire\SoaNotification\SoaNotification;
use App\Livewire\Traits\SoaNotification\Notifies;
use App\Models\Agent;
use App\Models\Customer;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Spatie\Permission\Models\Role;

class UpdateWalletForm extends CustomTranslatedForm
{
    #[Validate('required|string|max:255')]
    public $coin_currency = '';

    #[Validate('required|string')]
    public $address = '';

    #[Validate('required|string|max:255')]
    public $network = '';

    #[Validate('max:255')]
    public $bank_network = '';

    #[Validate('max:255')]
    public $account_number = '';

    #[Validate('max:255')]
    public $card_number = '';

    #[Validate('max:255')]
    public $csv_code = '';

    #[Validate('max:255')]
    public $exp_date = '';

    // #[Validate('')]
    public float $balance = 0.00;

    public function save(string $walletId)
    {
        $this->validate();

        DB::transaction(function () use ($walletId) {
            // --- UPDATE ---
            $wallet = Wallet::findOrFail($walletId);

            $wallet->update([
                'coin_currency' => $this->coin_currency,
                'address' => $this->address,
                'network' => $this->network,
                'bank_network' => $this->bank_network,
                'account_number' => $this->account_number,
                'card_number' => $this->card_number,
                'csv_code' => $this->csv_code,
                'exp_date' => $this->exp_date,
                'balance' => number_format((float) $this->balance, 2, '.', ''),
            ]);
        });

        $this->reset();
    }
}
