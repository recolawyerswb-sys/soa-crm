<?php

namespace App\Livewire\Forms\Business\Agents;

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

class CreateAgentForm extends CustomTranslatedForm
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
    public $position = '';

    #[Validate('nullable|string|max:50')]
    public $status = '1';

    #[Validate('nullable|string|max:50')]
    public $day_off = '';

    #[Validate('nullable|string|max:50')]
    public $checkin_hour = '';

    #[Validate('nullable|max:50')]
    public ?bool $is_leader = false;

    #[Validate('nullable|max:50')]
    public $team_id = '';

    protected $casts = [
        'is_leader' => 'boolean',
        'checkin_hour' => 'datetime',
    ];

    public function save(bool $isEditEnabled = false, int $agentId = null)
    {
        $this->validate();

        DB::transaction(function () use ($isEditEnabled, $agentId) {
            if ($isEditEnabled) {
                // --- UPDATE ---
                $agent = Agent::findOrFail($agentId);

                $agent->profile->update([
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

                $agent->profile->user->update([
                    'email' => $this->email,
                ]);

                $agent->update([
                    'position' => $this->position,
                    'status' => $this->status,
                    'day_off' => $this->day_off,
                    'checkin_hour' => $this->checkin_hour,
                    'is_leader' => (bool) $this->is_leader,
                    'team_id' => $this->team_id,
                ]);

            } else {
                // --- CREATE ---
                $user = User::create([
                    'name' => User::generateUsername($this->full_name, $this->email),
                    'email' => $this->email,
                    'password' => Hash::make('password'),
                ]);

                $user->assignRole('agent');

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

                $agent = $profile->agent()->create([
                    'position' => $this->position,
                    'status' => $this->status,
                    'day_off' => $this->day_off,
                    'checkin_hour' => $this->checkin_hour,
                    'is_leader' => (bool) $this->is_leader,
                    'team_id' => $this->team_id,
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
