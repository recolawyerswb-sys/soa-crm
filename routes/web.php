<?php

use App\Http\Controllers\Communications\Calls\CallController;
use App\Http\Controllers\CustomerApiController;
use App\Http\Controllers\Dashboard\Pages\HelpPageController;
use App\Http\Controllers\Utilities\ImportExportController;
use App\Livewire\Dashboard\Welcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::fallback(function ()  {
    return request()->redirect('/crm');
});

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
            Volt::route('password', 'settings.password')->name('password')->middleware('role:developer|admin|cliente');
            // Volt::route('appearance', 'settings.appearance')->name('appearance');

            Volt::route('settings/two-factor', 'settings.two-factor')
                ->middleware(
                    when(
                        Features::canManageTwoFactorAuthentication()
                            && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                        ['password.confirm'],
                        [],
                    ),
                )
                ->name('two-factor.show');
        });

});

require __DIR__.'/auth.php';

Route::prefix('crm')
    ->middleware(['auth'])
    ->group(function () {
        require __DIR__.'/app/business.php';
        require __DIR__.'/app/wallet.php';
        require __DIR__.'/app/calls.php';
        require __DIR__.'/app/testing.php';
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


# UTILITY ROUTES
Route::prefix('utilities')
    ->name('utilities.')
    ->group(function () {
        Route::get('export', [ImportExportController::class, 'export'])->name('generic.export');
        Route::post('import', [ImportExportController::class, 'import'])->name('generic.import');
    })
    ->middleware(['auth', 'role:admin']);
