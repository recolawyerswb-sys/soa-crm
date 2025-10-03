<?php

namespace App\Livewire\Forms\Business\ClientTracking;

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

class CreateClientTrackingForm extends CustomTranslatedForm
{
    #[Validate('max:255')]
    public $customer_id = '';

    #[Validate('max:255')]
    public $agent_id = '';

    #[Validate('max:255')]
    public $assignment_id = '';

    #[Validate('required|string|max:255')]
    public $notes = '';

    public function save(bool $isEditEnabled = false, int $clientTrackingId = null)
    {
        $this->validate();

        DB::transaction(function () use ($isEditEnabled, $clientTrackingId) {

            $currentAssignment = '';

            // SI ESTA HACIENDO EL SEGUIMIENTO UN ROL DIFERENTE A AGENTE, ENTONCES USAMOS EL AGENTE
            // QUE NOS ESTA DANDO EL FORMULARIO
            if (auth()->user()->isAdmin()) {
                $currentAssignment = Assignment::where([
                    'customer_id' => $this->customer_id,
                    'agent_id' => $this->agent_id
                ])->first();
            } else if (auth()->user()->isAgente()) {
                // EN CASO DE QUE EL AGENTE SEA EL QUE TENGA LA SESION ACTIVA, VA A COLOCARSE SU ID
                $currentAssignment = Assignment::where([
                    'customer_id' => $this->customer_id,
                    'agent_id' => auth()->user()->profile->agent->id,
                ])->first();
            }

            if ($isEditEnabled) {
                // --- UPDATE ---
                $currentClientTracking = ClientTracking::findOrFail($clientTrackingId);

                $currentClientTracking->update([
                    'notes' => $this->notes,
                ]);

                // ESPACIO PARA CAMBIAR ESTADOS, ETC

            } else {
                // --- CREATE ---
                $newClientTracking = ClientTracking::create([
                    'assignment_id' => $currentAssignment->id,
                    'notes' => $this->notes,
                ]);

                // ESPACIO PARA CAMBIAR ESTADOS, ETC
            }
        });

        $this->reset();
    }
}
