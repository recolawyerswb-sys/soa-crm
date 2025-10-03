<?php

namespace App\Livewire\Sells\Calls;

use Livewire\Component;
use Twilio\Rest\Client;

class CallHistory extends Component
{
    public $calls = [];

    public function getCalls()
    {
        // Esta es la misma lógica que usamos para obtener el historial
        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));

        try {
            $callRecords = $twilio->calls->read([], 20); // Leemos las últimas 20 llamadas

            dd($callRecords);

            // Usamos una colección de Laravel para mapear y limpiar los datos
            $this->calls = collect($callRecords)->map(function($call) {
                return [
                    'from' => $call->fromFormatted,
                    'to' => $call->toFormatted,
                    'status' => $call->status,
                    'start_time' => $call->startTime, // Pasamos el objeto DateTime completo
                    'duration' => $call->duration,
                ];
            })->toArray();

        } catch (\Exception $e) {
            // Manejar el error, por ejemplo, mostrando un mensaje en la vista
            session()->flash('error', 'No se pudo cargar el historial de llamadas.');
            $this->calls = [];
        }
    }

    public function mount()
    {
        $this->getCalls();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.sells.call-history');
    }

    public function render()
    {
        return view('livewire.sells.calls.call-history');
    }
}
