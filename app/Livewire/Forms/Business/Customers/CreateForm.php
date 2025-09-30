<?php

namespace App\Livewire\Forms\Business\Customers;

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

class CreateForm extends CustomTranslatedForm
{
    #[Validate('required|string|max:255')]
    public $full_name = '';

    #[Validate('required|max:255')]
    public $email = '';

    #[Validate('required|string|max:20')]
    public $phone_1 = '';

    #[Validate('nullable|string|max:20')]
    public $phone_2 = '';

    #[Validate('nullable|string|max:50')]
    public $preferred_contact_method = '';

    #[Validate('nullable|string|max:100')]
    public $country = '';

    #[Validate('nullable|string|max:100')]
    public $city = '';

    #[Validate('nullable|string|max:255')]
    public $address = '';

    #[Validate('nullable|string|max:50')]
    public $dni_type = '';

    #[Validate('nullable|string|max:50')]
    public $dni_number = '';

    #[Validate('nullable|date')]
    public $birthdate = '';

    #[Validate('nullable|string|max:50')]
    public $type = '';

    #[Validate('nullable|string|max:50')]
    public $phase = '';

    #[Validate('nullable|string|max:50')]
    public $origin = '';

    #[Validate('nullable|string|max:50')]
    public $status = '';

    #[Validate('nullable|max:255')]
    public $agent_id = '';

    public function save(bool $isEditEnabled = false, int $customerId = null)
    {
        $this->validate();

        DB::transaction(function () use ($isEditEnabled, $customerId) {
            if ($isEditEnabled) {
                // --- UPDATE ---
                $customer = Customer::findOrFail($customerId);

                $customer->profile->update([
                    'full_name' => $this->full_name,
                    'country' => $this->country,
                    'phone_1' => $this->phone_1,
                    'phone_2' => $this->phone_2,
                    'preferred_contact_method' => $this->preferred_contact_method,
                    'address' => $this->address,
                    'city' => $this->city,
                    'dni_type' => $this->dni_type,
                    'dni_number' => $this->dni_number,
                    'birthdate' => $this->birthdate ?: null,
                ]);

                $customer->profile->user->update([
                    'email' => $this->email,
                ]);

                $customer->update([
                    'phase' => $this->phase,
                    'type' => $this->type,
                    'origin' => $this->origin,
                    'status' => $this->status,
                ]);

                $customer->assignment->update([
                    'agent_id' => $this->agent_id,
                ]);

            } else {
                // --- CREATE ---
                $user = User::create([
                    'name' => User::generateUsername($this->full_name, $this->email),
                    'email' => $this->email,
                    'password' => Hash::make('password'),
                ]);

                $user->assignRole('customer');

                $profile = $user->profile()->create([
                    'full_name' => $this->full_name,
                    'country' => $this->country,
                    'phone_1' => $this->phone_1,
                    'phone_2' => $this->phone_2,
                    'preferred_contact_method' => $this->preferred_contact_method,
                    'address' => $this->address,
                    'city' => $this->city,
                    'dni_type' => $this->dni_type,
                    'dni_number' => $this->dni_number,
                    'birthdate' => $this->birthdate ?: null,
                ]);

                $customer = $profile->customer()->create([
                    'type' => $this->type,
                    'phase' => $this->phase,
                    'origin' => $this->origin,
                    'status' => $this->status,
                ]);

                $customer->assignment()->create([
                    'agent_id' => $this->agent_id ?: Agent::getDefaultAgentId(),
                    'notes' => 'Asignación automática desde módulo de clientes',
                ]);

                $user->wallet()->create([
                    'coin_currency' => 'USDT',
                    'address' => 'pending',
                    'network' => 'TRC20',
                ]);
            }
        });

        $this->reset();
    }
}
