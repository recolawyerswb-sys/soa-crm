<?php

namespace App\Livewire\Forms\Accounts\Movements;

use App\Livewire\Forms\CustomTranslatedForm;
use App\Models\Movement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateMovementForm extends CustomTranslatedForm
{
    #[Validate('required|max:255')]
    public $amount = '';

    #[Validate('required|max:255')]
    public $type = '';

    #[Validate('string|max:255')]
    public $note = '';

    public function save(bool $isEditEnabled = false, string $movementId = null)
    {
        $this->validate();

        DB::transaction(function () use ($isEditEnabled, $movementId) {
            if ($isEditEnabled) {
                // --- UPDATE ---
                $movement = Movement::findOrFail($movementId)->update([
                    'amount' => $this->amount,
                    'type' => $this->type,
                    'note' => $this->note,
                ]);

            } else {
                // --- CREATE ---
                $movement = Movement::create([
                    'amount' => $this->amount,
                    'type' => $this->type,
                    'wallet_id' => Auth::user()->wallet->id,
                ]);
            }
        });

        $this->reset();
    }
}
