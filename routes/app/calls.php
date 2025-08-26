<?php

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
                Volt::route('reports', 'calls.reports.index')
                    ->name('reports')
                    ->middleware(['role:admin']);
            });
    });
