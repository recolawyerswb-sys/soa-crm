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
        $url = route('services.twilio.voice'); // endpoint TwiML
        $statusCallback = route('services.twilio.status');
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
        // $response->say('Prueba realizada pandita lider tiene el cosito popochito y delicioso con leche condensada.', ['voice' => 'Polly.Andres-Generative', 'language' => 'es-MX']);
        // return response($response, 200)->header('Content-Type', 'text/xml');

        $response = new VoiceResponse();

        // Verificamos si recibimos el número desde el JS
        if ($request->has('destinationNumber')) {
            $numberToDial = $request->input('destinationNumber');
            // Preparamos el TwiML para marcar ese número
            $response->dial($numberToDial, ['callerId' => config('services.twilio.from')]);
        } else {
            // Si por alguna razón no llega el número, lo indicamos en la llamada
            $response->say('No se ha proporcionado un número de destino. Adiós.');
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
