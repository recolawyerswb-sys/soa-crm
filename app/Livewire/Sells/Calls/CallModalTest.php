<?php

namespace App\Livewire\Sells\Calls;

use App\Http\Controllers\Communications\Sms\SmsController;
use Livewire\Component;
use Twilio\Exceptions\TwimlException;
use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;

class CallModalTest extends Component
{
    public $number;
    public $message;

    public function send()
    {
        $this->validate([
            'number' => 'required|string',
            'message' => 'required|string|max:160',
        ]);

        // Llamamos al controlador
        app(SmsController::class)->send($this->number, $this->message);

        // Redirigir para refrescar sesión
        return redirect()->route('sms.form');
    }

    public function render()
    {

        return view('livewire.sells.calls.call-modal-test');
    }
}
