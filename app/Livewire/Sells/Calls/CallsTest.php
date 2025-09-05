<?php

namespace App\Livewire\Sells\Calls;

use App\Http\Controllers\Communications\Calls\CallController;
use App\Http\Controllers\Communications\Sms\SmsController;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Twilio\Exceptions\TwimlException;
use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;

class CallsTest extends Component
{
    public $number;
    public $message;

    public $showModal = false;
    public $clientName;
    public $clientCountry;

    public function sendSms()
    {
        $this->validate([
            'number' => 'required|string',
            'message' => 'string|max:160',
        ]);

        // Llamamos al controlador
        app(SmsController::class)->send($this->number, $this->message);

        // Redirigir para refrescar sesión
        return back()->with('status', "Mensaje enviado a {$this->number}");
    }

    public function openCallModal()
    {
        // Aquí podrías buscar datos del cliente en tu DB
        $this->clientName = "Cliente Demo";
        $this->clientCountry = "Argentina"; // luego se actualiza con Twilio webhook
        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.sells.calls.calls-test');
    }
}
