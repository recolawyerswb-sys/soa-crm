<?php

use App\Http\Controllers\Communications\Calls\CallController;
use App\Livewire\Sells\Calls\CallHistory;
use App\Livewire\Sells\Calls\CallsTest;
use App\Livewire\Testing\TableWithModal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// LLAMADAS ROUTES
Route::prefix('testing')
    ->name('testing.')
    ->group(function () {
        Route::prefix('correct')
            ->name('correct.')
            ->group(function () {
                Route::get('/', TableWithModal::class)
                    ->name('modals')
                    ->lazy()
                    ->middleware(['role:developer|admin|agente|agent-leader']);
            });
    });
