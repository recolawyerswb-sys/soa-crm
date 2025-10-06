<?php

namespace App\Livewire\Accounts\Movements;

use App\Helpers\ClientHelper;
use App\Livewire\Forms\Accounts\Movements\CreateMovementForm;
use App\Models\Customer;
use App\Models\Movement;
use App\Traits\Notifies;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateMovementModalForm extends Component
{
    use Notifies;

    public Movement $movement;

    public CreateMovementForm $form;

    public $isEditEnabled = false;

    public ?string $movementId;

    public string $authUser, $authUserBalance = '';

    public array $types, $customers = [];

    public $modalViewName = '';

    // CONTROL BALANCE VALIDATION PROPERTIES
    public ?bool $invalidAmount = false;

    /**
     * @var string El nombre del usuario que se mostrará en el modal.
     */
    public string $displayUserName = '';

    /**
     * @var float El balance del usuario que se mostrará en el modal.
     */
    public float $displayUserBalance = 0.0;

    /**
     * Se ejecuta cuando el CAMPO DE MONTO pierde el foco.
     */
    public function updatedFormAmount($value)
    {
        // Solo llamamos a nuestro validador central.
        $this->validateAmount();
    }

    /**
     * ¡LA CLAVE DE LA SOLUCIÓN!
     * Se ejecuta INMEDIATAMENTE cuando el TIPO de movimiento cambia (por wire:model.live).
     */
    public function updatedFormType($value)
    {
        // También llamamos a nuestro validador central.
        $this->validateAmount();
    }

    /**
     * ¡LA CLAVE! Este hook se ejecuta cuando 'form.customer_id' cambia.
     */
    public function updatedFormCustomerId($customerId)
    {
        // Si se seleccionó un cliente (el ID no está vacío)
        if ($customerId) {
            // Buscamos al cliente con sus relaciones ya cargadas para eficiencia
            $customer = Customer::with('profile.user.wallet')->find($customerId);

            if ($customer && $customer->profile?->user) {
                // Actualizamos las propiedades de visualización con los datos del cliente
                $this->displayUserName = $customer->profile->user->name;
                $this->displayUserBalance = $customer->profile->user->wallet?->balance ?? 0.0;
            }
        } else {
            // Si se deselecciona el cliente, volvemos a los datos del usuario autenticado.
            $this->loadAuthUserData();
        }

        // Importante: Revalidamos el monto, ya que el balance de referencia ha cambiado.
        $this->validateAmount();
    }

    /**
     * MÉTODO CENTRAL DE VALIDACIÓN
     * Contiene la lógica en un solo lugar.
     */
    private function validateAmount(): void
    {
        // Obtenemos los valores actuales del formulario
        $amount = (float) $this->form->amount;
        $type = $this->form->type;

        // La condición que ya tenías:
        // El monto es inválido SI el tipo es 'Retiro' Y el monto es mayor al balance.
        if ($type === '2' && $amount > $this->authUserBalance) {
            $this->invalidAmount = true;
        } else {
            // Para cualquier otro caso (es un depósito, el monto es válido, o está vacío),
            // el monto NO es inválido.
            $this->invalidAmount = false;
        }
    }

    /**
     * Un método ayudante para no repetir código.
     * Carga los datos del usuario logueado en las propiedades de visualización.
     */
    private function loadAuthUserData(): void
    {
        $user = Auth::user();
        $this->displayUserName = $user->name;
        $this->displayUserBalance = $user->wallet?->balance ?? 0.0;

        $this->modalViewName = 'create-movement-modal';
        $this->authUser = auth()->user()->name ?? 'No registrado';
        $this->authUserBalance = auth()->user()->wallet->balance ?? 'No registrado';
        $this->types = \App\Helpers\MovementHelper::getTypes();
        $this->customers = ClientHelper::getCustomersAsArrayWithIdsAsKeys();
    }

    public function mount()
    {
        $this->loadAuthUserData();
    }

    public function save()
    {
        if (!$this->invalidAmount) {
            if ($this->isEditEnabled) {
                $this->form->save($this->isEditEnabled, $this->movementId);
                $this->notify('Movimiento actualizado exitosamente');
            } else {
                $this->notify('Movimiento creado exitosamente');
                $this->form->save();
            }
            $this->dispatch('refreshTableData');
        }
        // NOTIFICATION EVENT
        Flux::modals()->close();
    }

    #[On('enable-edit-for-create-movement-modal')]
    public function enableEdit($movementId) {
        $this->form->reset();
        $this->isEditEnabled = true;
        $this->movement = Movement::findOrFail($movementId);
        $this->movementId = $this->movement->id;

        // FILL THE FORM
        $this->form->amount = $this->movement->amount;
        $this->form->type = $this->movement->type;
        $this->form->note = $this->movement->note;
    }

    #[On('unable-edit-for-create-movement-modal')]
    public function unableEdit() {
        $this->isEditEnabled = false;
        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.accounts.movements.create-movement-modal-form');
    }
}
