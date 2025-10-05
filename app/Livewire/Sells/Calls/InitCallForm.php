<?php

namespace App\Livewire\Sells\Calls;

use App\Helpers\ClientHelper;
use App\Models\Assignment;
use App\Models\CallReport;
use App\Models\Customer;
use App\Traits\Notifies;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class InitCallForm extends Component
{
    use Notifies;

    #[Locked]
    public $customerId;

    public ?string $full_name = ' ';

    public ?float $balance = 0.0;

    public ?string $country = ' ';

    #[Locked]
    public array $phases, $statuses = [];

    public $status, $phase, $notes = '';

    #[Computed]
    public function customer()
    {
        return Customer::find($this->customerId);
    }

    public function placeholder()
    {
        return view('livewire.placeholders.sells.call-modal-skeleton');
    }

    #[On('send-client-basic-information-for-call')]
    public function loadCustomerId($customer)
    {
        $this->customerId = $customer['id'];
        $this->full_name = $customer['full_name'];
        $this->status = $customer['status'];
        $this->country = $customer['country'];
        $this->balance = $customer['balance'];
    }

    #[On('saveCallReport')]
    public function saveReport($callSid, $notes, $status, $phase)
    {
        // Validación (opcional pero recomendada)
        if (!$this->customer) return;

        $currentAssignment = Assignment::query()->where('customer_id', $this->customerId)->first();

        // Creamos el reporte preliminar
        CallReport::create([
            'call_sid' => $callSid,
            'call_status' => $status,
            'call_notes' => $notes,
            'customer_phase' => $phase,
            'customer_status' => $status,
            'assignment_id' => $currentAssignment ? $currentAssignment->id : null,
            'user_id' => auth()->user()->id,
            // duration y final_status se quedan en null por ahora
        ]);

        // Opcional: notificar al usuario que se guardó
        $this->notify('Reporte guardado exitosamente');
    }

    public function mount()
    {
        $this->phases = ClientHelper::getPhases();
        $this->statuses = ClientHelper::getStatus();
    }

    public function render()
    {
        return view('livewire.sells.calls.init-call-form');
    }
}
