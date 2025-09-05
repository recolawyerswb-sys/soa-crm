<?php

namespace App\Http\Controllers\Communications\Calls;

use App\Http\Controllers\Controller;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Twilio\Jwt\ClientToken;
use Twilio\TwiML\VoiceResponse;

class CallController extends Controller
{
    public function makeCall(string $number): string
    {
        $url = route('sells.calls.twilio.voice'); // endpoint TwiML
        $statusCallback = route('sells.calls.twilio.status');
        return app(TwilioService::class)->makeCall($number, $url, $statusCallback);
    }

    public function generateToken()
    {
        // Implementar generación de token para Twilio Client JS
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $appSid = config('services.twilio.app_sid'); // ¡IMPORTANTE! Necesitas crear una TwiML App en tu consola de Twilio

        $capability = new ClientToken($sid, $token);
        $capability->allowClientOutgoing($appSid); // Permite hacer llamadas salientes
        $jwt = $capability->generateToken();

        return response()->json(['token' => $jwt]);
    }

    public function voiceResponse(Request $request)
    {
        // $response = new VoiceResponse();
        // $response->say('Prueba realizada correctamente.', ['voice' => 'alice', 'language' => 'es-ES']);
        // return response($response, 200)->header('Content-Type', 'text/xml');

        $response = new VoiceResponse();
        $dial = $response->dial('', ['callerId' => config('services.twilio.from')]); // Tu número de Twilio

        // El número al que llamamos viene en la petición de Twilio
        if ($request->has('To')) {
            $dial->number($request->input('To'));
        } else {
            $response->say('Gracias por llamar');
        }

        return response($response)->header('Content-Type', 'text/xml');
    }

    public function statusCallback(Request $request)
    {
        // Manejar el estado de la llamada (iniciada, en curso, completada, etc.)
        // Puedes registrar estos estados en tu base de datos si es necesario

        // $callSid = $request->input('CallSid');
        // $duration = $request->input('CallDuration');
        // $status = $request->input('CallStatus');
        // ...etc.

        // Log::info("Call status received: ", $request->all());

        return response('OK', 200);
    }
}
