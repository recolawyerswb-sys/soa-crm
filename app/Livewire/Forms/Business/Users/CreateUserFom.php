<?php

namespace App\Livewire\Forms\Business\Users;

use App\Livewire\Forms\CustomTranslatedForm;
use App\Livewire\SoaNotification\Notify;
use App\Livewire\SoaNotification\SoaNotification;
use App\Livewire\Traits\SoaNotification\Notifies;
use App\Models\Agent;
use App\Models\Assignment;
use App\Models\ClientTracking;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class CreateUserFom extends CustomTranslatedForm
{
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|string|max:255')]
    public $email = '';

    #[Validate('string|max:255')]
    public $password = '';

     #[Validate('required|string|max:255')]
    public $role = '';

    public function save(bool $isEditEnabled = false, int $userId = null)
    {
        $this->validate();

        DB::transaction(function () use ($isEditEnabled, $userId) {

            if ($isEditEnabled) {
                $currentUser = User::findOrFail($userId);
                $currentUser->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => $this->password,
                ]);
                $currentUser->syncRoles($this->role);
                $currentUser->update();

                // ESPACIO PARA CAMBIAR ESTADOS, ETC

            } else {
                // --- CREATE ---
                $newUser = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                ]);
                $newUser->syncRoles($this->role);

                // 3. Crear perfil relacionado
                $profile = $newUser->profile()->create([
                    'full_name' => $this->name,
                    'country' => 'CO',
                    'phone_1' => '+57333322209',
                ]);

                // 5. Crear wallet relacionada
                $wallet = $newUser->wallet()->create([
                    'coin_currency' => fake()->randomElement(['USDT', 'BTC', 'ETH', 'BNB']),
                    'address' => fake()->text(20),
                    'network' => fake()->randomElement(['TRC20', 'TRX']),
                ]);
            }
        });

        $this->reset();
    }
}
