<?php

namespace App\Livewire\Forms\Business\AccessControl;

use App\Livewire\Forms\CustomTranslatedForm;
use App\Livewire\SoaNotification\Notify;
use App\Livewire\SoaNotification\SoaNotification;
use App\Livewire\Traits\SoaNotification\Notifies;
use App\Models\Agent;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Spatie\Permission\Models\Role;

class CreateAccesscontrolRoleForm extends CustomTranslatedForm
{
    #[Validate('required|string|max:255')]
    public $name = '';

    public function save(bool $isEditEnabled = false, int $roleId = null)
    {
        $this->validate();

        DB::transaction(function () use ($isEditEnabled, $roleId) {
            if ($isEditEnabled) {
                // --- UPDATE ---
                $role = Role::findOrFail($roleId);

                $role->update([
                    'name' => $this->name,
                ]);

            } else {
                // --- CREATE ---
                Role::create([
                    'name' => $this->name,
                ]);
            }
        });

        $this->reset();
    }
}
