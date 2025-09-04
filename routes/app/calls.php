<?php

use App\Livewire\Sells\Calls\CallsTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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
                        Route::post('voice', function (Request $request) {
                            return response('<?xml version="1.0" encoding="UTF-8"?>
                                <Response>
                                    <Say voice="alice" language="es-ES">
                                        Hola, esta es una llamada de prueba desde Laravel con Twilio.
                                    </Say>
                                </Response>', 200, [
                                    'Content-Type' => 'text/xml'
                                ]);
                        });
                    });
            });
    });
