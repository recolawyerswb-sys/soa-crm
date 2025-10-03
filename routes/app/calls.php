<?php

use App\Http\Controllers\Communications\Calls\CallController;
use App\Livewire\Sells\Calls\CallHistory;
use App\Livewire\Sells\Calls\CallsTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
                    ->lazy()
                    ->middleware(['role:admin,manager']);
                Route::get('/test', CallsTest::class)
                    ->name('test')
                    ->lazy()
                    ->middleware(['role:admin|agente|agent-leader']);
                Volt::route('reports', 'calls.reports.index')
                    ->name('reports')
                    ->lazy()
                    ->middleware(['role:admin']);
                Route::get('history', CallHistory::class)
                    ->name('history')
                    ->lazy();
            });
    });
