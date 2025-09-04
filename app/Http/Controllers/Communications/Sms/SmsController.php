<?php

namespace App\Http\Controllers\Communications\Sms;

use App\Http\Controllers\Controller;
use App\Services\TwilioService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{
    protected TwilioService $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function send(string $number, string $message): RedirectResponse
    {
        $this->twilio->sendSms($number, $message);

        // Aquí más adelante irá la lógica Twilio
        // Por ahora, solo guardamos un mensaje en sesión
        return back()->with('status', "Mensaje enviado a {$number}");
    }
}
