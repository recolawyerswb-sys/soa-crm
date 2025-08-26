<?php

use App\Http\Controllers\CustomerApiController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified']);

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
        require __DIR__.'/app/calls.php';
        require __DIR__.'/app/wallet.php';
    });
