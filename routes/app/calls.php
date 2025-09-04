<?php

use App\Livewire\Sells\Calls\CallsTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Twilio\Jwt\ClientToken;

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
                        Route::post('voice', function (Request $request) {
                            return response('<?xml version="1.0" encoding="UTF-8"?>
                                <Response>
                                    <Say voice="alice" language="es-ES">
                                        Hola, esta es una llamada de prueba desde Laravel con Twilio.
                                    </Say>
                                    <Pause length="60"/>
                                </Response>', 200, [
                                    'Content-Type' => 'text/xml'
                                ]);
                        })->name('voice');

                        # Estado de la llamada
                        Route::post('status', function (Request $request) {
                            $sid = $request->input('CallSid');
                            $status = $request->input('CallStatus');
                            $duration = $request->input('CallDuration'); // solo al finalizar

                            Log::info("Call $sid status: $status, duration: $duration");

                            // Si usas broadcasting: emite evento a Livewire/JS
                            broadcast(new \App\Events\CallUpdated($sid, $status, $duration));

                            return response('OK', 200);
                        })->name('status');

                        # Token para Twilio Client JS (Llamadas desde navegador)
                        Route::get('token', function () {
                            $token = new ClientToken(
                                config('services.twilio.sid'),
                                config('services.twilio.token')
                            );

                            $token->allowClientOutgoing(config('services.twilio.twiml_app_sid'));
                            $token->allowClientIncoming('user_computadora');

                            return response()->json(['token' => $token->toJWT()]);
                        })->name('token');
                    });
            });
    });
