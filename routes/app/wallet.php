<?php

use App\Livewire\Accounts\Index as AccountsIndex;
use App\Livewire\Accounts\Movements\Index as MovementsIndex;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// MOVIMIENTOS Y CUENTAS ROUTES
Route::prefix('wallet')
    ->name('wallet.')
    ->group(function () {

        /**
         * E.Q ACCOUNTS/
         *
         * ADMITTED ROLES: ADMIN, MANAGER
         *
         */
        Route::get('/', AccountsIndex::class)
            ->name('index')
            ->middleware(['role:admin']);

        /**
         * E.Q ACCOUNTS/EDIT/{ID}
         *
         * ADMITTED ROLES: ADMIN, MANAGER
         *
         * */
        Volt::route('edit/{id}', 'accounts.edit')
            ->name('edit')
            ->middleware(['role:admin']);

        /**
         * E.Q ACCOUNTS/MOVEMENTS/
         *
         * ADMITTED ROLES: ADMIN, MANAGER
         *
         */
        Route::prefix('movements')
            ->name('movements.')
            ->group(function () {
                Volt::route('/', 'accounts.movements.index')
                    ->name('index')
                    ->middleware(['role:admin']);
                Volt::route('create', 'accounts.movements.create')
                    ->name('create')
                    ->middleware(['role:admin']);
            });
    });
