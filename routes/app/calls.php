<?php

use App\Livewire\Sells\Calls\CallsTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Twilio\Jwt\ClientToken;
use Twilio\TwiML\VoiceResponse;

// LLAMADAS ROUTES
Route::prefix('sells')
    ->name('sells.')
    ->group(function () {
        Route::prefix('calls')
            ->name('calls.')
            ->group(function () {
                Volt::route('/', 'calls.index')
                    ->name('index')
                    ->middleware(['role:admin,manager']);
                Route::get('/test', CallsTest::class)
                    ->name('test')
                    ->middleware(['role:admin|agente|agent-leader']);
                Volt::route('reports', 'calls.reports.index')
                    ->name('reports')
                    ->middleware(['role:admin']);

                Route::prefix('twilio')
                    ->name('twilio.')
                    ->group(function () {
                        # Registar a call
                        Route::get('voice', function (Request $request) {
                            $response = new VoiceResponse();
                            $response->say('Prueba realizada correctamente.', ['voice' => 'alice', 'language' => 'es-ES']);
                            return $response;
                        })->name('voice');

                        # Estado de la llamada
                        Route::post('status', function (Request $request) {
                            Log::info('Call Status', $request->all());
                            return response('OK', 200);
                        })->name('status');

                        # Token para Twilio Client JS (Llamadas desde navegador)
                        Route::get('token', function () {
                            $token = new ClientToken(
                                config('services.twilio.sid'),
                                config('services.twilio.token')
                            );

                            $token->allowClientOutgoing(config('services.twilio.twiml_app_sid'));
                            $token->allowClientIncoming('iserlatam');

                            return response()->json(['token' => $token->generateToken()]);
                        })->name('token');
                    });
            });
    });
