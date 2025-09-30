<?php
namespace App\Http\Controllers\Communications\Calls;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
        Log::info('Parámetros recibidos en webhook:', $request->all());

        $response = new VoiceResponse();
        $numberToDial = null;

        $response->say('Conectando su llamada, por favor espere.', ['voice' => 'Polly.Andres-Generative', 'language' => 'es-MX']);

        // ✅ Paso 1: Buscamos el 'customerId' que envió el JavaScript.
        if ($request->has('customerId')) {

            try {
                // ✅ Paso 2: Buscamos al cliente en la base de datos.
                // findOrFail detendrá la ejecución si el cliente no existe, pasando al bloque catch.
                $customer = Customer::with('profile')->findOrFail($request->input('customerId'));

                // ✅ Paso 3: Obtenemos el número de teléfono del modelo del cliente.
                // Asegúrate de que 'phone' sea el nombre correcto de la columna en tu base de datos.
                $numberToDial = $customer->profile->phone_1;

            } catch (\Exception $e) {
                // Si el cliente no se encuentra, lo registramos en el log y le avisamos al usuario.
                Log::error('IVR Error: No se encontró el cliente con ID: ' . $request->input('customerId'));
                $response->say('Error, no pudimos encontrar los datos del cliente.');
                return response($response)->header('Content-Type', 'text/xml');
            }

        }

        // ✅ Paso 4: Realizamos la llamada si encontramos un número.
        if ($numberToDial) {
            $response->dial($numberToDial, [
                'callerId' => config('services.twilio.from'),
                // 'action' => route('calls.handleDialStatus'), // Esta acción es para saber el estado final
                'method' => 'POST'
            ]);
        } else {
            // Si no se recibió 'customerId' o hubo otro problema.
            $response->say('Error, no se recibió un destino para la llamada.');
            Log::error('El parámetro "customerId" no fue encontrado en la request.');
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
