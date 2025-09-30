<?php

use App\Http\Controllers\Communications\Calls\CallController;
use App\Http\Controllers\CustomerApiController;
use App\Http\Controllers\Dashboard\Pages\HelpPageController;
use App\Livewire\Dashboard\Welcome;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', Welcome::class)
    ->name('welcome')
    ->lazy();

Route::get('/customers', [CustomerApiController::class, 'index'])
    ->middleware(['auth', 'role:admin']);

Route::view('crm', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::prefix('settings')
        ->middleware(['auth'])
        ->name('settings.')
        ->group(function () {
            Volt::route('profile', 'settings.profile')->name('profile');
            Volt::route('user', 'settings.user')->name('user');
            Volt::route('password', 'settings.password')->name('password');
            Volt::route('appearance', 'settings.appearance')->name('appearance');
        });

});

require __DIR__.'/auth.php';

Route::prefix('crm')
    ->middleware(['auth'])
    ->group(function () {
        require __DIR__.'/app/business.php';
        require __DIR__.'/app/wallet.php';
        require __DIR__.'/app/calls.php';
    });

# TWILIO SERVICES ROUTES
Route::prefix('crm/services/twilio')
    ->name('services.twilio.')
    ->group(function () {
        # Registar a call
        Route::get('token', [CallController::class, 'generateToken'])
            ->name('token');

        Route::post('voice', [CallController::class, 'voiceResponse'])
            ->name('voice');

        Route::post('status', [CallController::class, 'statusCallback'])
            ->name('status');
    });

# HELP ROUTES (INERTIA, ONLY FRONTEND)
Route::prefix('pages')
    ->name('pages.')
    ->group(function () {
        Route::get('help', [HelpPageController::class, 'show'])->name('help');
    });
