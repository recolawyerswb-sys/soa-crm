<?php
namespace App\Http\Controllers\Communications\Calls;

use App\Http\Controllers\Controller;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        Log::info('Parámetros recibidos (intento 2):', $request->all());

        // Verificamos si recibimos el número desde el JS
        if ($request->has('To')) {
            $numberToDial = $request->input('To');
            $response->dial($numberToDial, ['callerId' => config('services.twilio.from')]);
        } else {
            $response->say('Error, no se recibió el número de destino. Revisa los logs.');
            Log::error('El parámetro "To" no fue encontrado en la request.');
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
