<?php

use App\Http\Controllers\Communications\Calls\CallController;
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
            });
    });
