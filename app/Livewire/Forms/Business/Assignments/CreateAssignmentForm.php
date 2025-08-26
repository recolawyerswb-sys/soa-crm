<?php

namespace App\Livewire\Forms\Business\Assignments;

use App\Livewire\Forms\CustomTranslatedForm;
use App\Livewire\SoaNotification\Notify;
use App\Livewire\SoaNotification\SoaNotification;
use App\Livewire\Traits\SoaNotification\Notifies;
use App\Models\Agent;
use App\Models\Assignment;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class CreateAssignmentForm extends CustomTranslatedForm
{
    #[Validate('required|max:255')]
    public $customer_id = '';

    #[Validate('required|max:255')]
    public $agent_id = '';

     #[Validate('max:255')]
    public $notes = '';

    #[Validate('nullable|max:50')]
    public $status = 'active';

    public function save(bool $isEditEnabled = false, int $assigmnentId = null)
    {
        $this->validate();

        DB::transaction(function () use ($isEditEnabled, $assigmnentId) {
            if ($isEditEnabled) {
                // --- UPDATE ---
                $assigmnent = Assignment::findOrFail($assigmnentId);

                $assigmnent->update([
                    'customer_id' => $this->customer_id,
                    'agent_id' => $this->agent_id,
                    'notes' => $this->notes,
                    'status' => $this->status,
                ]);

            } else {
                // --- CREATE ---
                $assigmnent = Assignment::create([
                    'customer_id' => $this->customer_id,
                    'agent_id' => $this->agent_id,
                    'notes' => $this->notes,
                    'status' => $this->status,
                ]);
            }
        });

        $this->reset();
    }
}
