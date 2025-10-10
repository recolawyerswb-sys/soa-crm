<?php

namespace App\Livewire\Accounts;

use App\Livewire\Forms\Accounts\UpdateWalletForm;
use App\Models\Wallet;
use App\Traits\Notifies;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdateWalletModalForm extends Component
{
    use Notifies;

    public Wallet $wallet;

    public UpdateWalletForm $form;

    public ?string $walletId;

    public $modalViewName = '';

    public function mount()
    {
        $this->modalViewName = 'update-wallet-modal';
    }

    public function save()
    {
        $this->form->save($this->walletId);
        $this->notify('Rol actualizado correctamente');

        // NOTIFICATION EVENT
        $this->dispatch('refreshTableData');
        Flux::modals()->close();
    }

    #[On('enable-edit-for-update-wallet-modal')]
    public function enableEdit($walletId) {
        $this->form->reset();
        $this->wallet = Wallet::findOrFail($walletId);
        $this->walletId = $this->wallet->id;

        // AGENT FIELDS
        $this->form->coin_currency = $this->wallet->coin_currency;
        $this->form->address = $this->wallet->address;
        $this->form->network = $this->wallet->network;
        $this->form->bank_network = $this->wallet->bank_network;
        $this->form->account_number = $this->wallet->account_number;
        $this->form->card_number = $this->wallet->card_number;
        $this->form->csv_code = $this->wallet->csv_code;
        $this->form->exp_date = $this->wallet->exp_date;
        $this->form->balance = $this->wallet->balance;
    }

    public function placeholder()
    {
        return view('livewire.placeholders.dashboards.forms.form-skeleton');
    }

    public function render()
    {
        return view('livewire.accounts.update-wallet-modal-form');
    }
}
