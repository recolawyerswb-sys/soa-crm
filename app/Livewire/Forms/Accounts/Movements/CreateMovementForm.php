<?php

namespace App\Livewire\Forms\Accounts\Movements;

use App\Livewire\Forms\CustomTranslatedForm;
use App\Models\Customer;
use App\Models\Movement;
use App\Models\Wallet;
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

    #[Validate('string|max:255')]
    public $customer_id = '';

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
                // --- Lógica de Creación (Corregida y Simplificada) ---
                $walletId = null;

                // 1. DETERMINAMOS EL ID DE LA BILLETERA A UTILIZAR
                if ($this->customer_id) {
                    // Si se especificó un cliente, buscamos su billetera.
                    // Usamos 'with' para cargar las relaciones de forma eficiente (Eager Loading).
                    $customer = Customer::with('profile.user.wallet')->findOrFail($this->customer_id);

                    // Verificamos que el cliente realmente tenga una billetera asociada.
                    if ($customer->profile?->user?->wallet) {
                        $walletId = $customer->profile->user->wallet->id;
                    } else {
                        // Si el cliente no tiene billetera, lanzamos un error para detener la transacción.
                        throw new \Exception("El cliente seleccionado no tiene una billetera asociada.");
                    }
                } else {
                    // Si NO se especificó un cliente, usamos la billetera del usuario autenticado.
                    $walletId = Auth::user()->wallet->id;
                }

                // 2. CREAMOS EL MOVIMIENTO CON EL ID DE LA BILLETERA CORRECTO
                Movement::create([
                    'amount' => $this->amount,
                    'type' => $this->type,
                    'wallet_id' => $walletId,
                    // 'note' => $this->note, // Considera añadir la nota también en la creación
                ]);
            }
        });

        $this->reset();
    }
}
