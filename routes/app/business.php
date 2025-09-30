<?php

use App\Livewire\Business\AccessControl\Index as AccesscontrolIndex;
use App\Livewire\Business\Agents\Index as AgentsIndex;
use App\Livewire\Business\Agents\Show as AgentsShow;
use App\Livewire\Business\Customers\Index as CustomersIndex;
use App\Livewire\Business\Teams\Index as TeamsIndex;
use App\Livewire\Business\Assignments\Index as AssignmentsIndex;
use App\Livewire\Business\ClientTracking\Index as ClientTrackingIndex;
use App\Livewire\Business\Customers\Show as CustomersShow;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Livewire\Volt\Volt;

// BUSINESS ROUTES
Route::prefix('business')
    ->name('business.')
    ->group(function () {
        /**
         * E.Q BUSINESS/CUSTOMERS/
         *
         * ADMITTED ROLES: ADMIN, MANAGER
         *
         */
        Route::prefix('customers')
            ->name('customers.')
            ->group(function () {
                Route::get('/', CustomersIndex::class)
                    ->name('index')
                    ->middleware(['role:admin|agent'])
                    ->lazy();
                Route::get('show/{customer}', CustomersShow::class)
                    ->name('show')
                    ->middleware(['role:admin|agent'])
                    ->lazy();
            });

        /**
         * E.Q BUSINESS/AGENTS/
         *
         * ADMITTED ROLES:
         *
         */
        Route::prefix('agents')
            ->name('agents.')
            ->group(function () {
                Route::get('/', AgentsIndex::class)
                    ->name('index')
                    ->middleware(['role:admin'])
                    ->lazy();
                Route::get('show/{agent}', AgentsShow::class)
                    ->name('show')
                    ->middleware(['role:admin|agent'])
                    ->lazy();

                /**
                 * E.Q BUSINESS/AGENTS/LEADERS/
                 *
                 * ADMITTED ROLES: ADMIN
                 *
                 */
                Route::prefix('leaders')
                    ->name('leaders.')
                    ->group(function () {
                        Volt::route('/', 'business.agents.leaders.index')
                            ->name('index')
                            ->middleware(['role:admin|agent']);
                        Volt::route('edit/{id}', 'business.agents.leaders.edit')
                            ->name('edit')
                            ->middleware(['role:admin|agent']);
                    });
            });

        /**
         * E.Q BUSINESS/CLIENT-TRACKING/
         *
         * ADMITTED ROLES:
         *
         */
        Route::prefix('client-tracking')
            ->name('client-tracking.')
            ->group(function () {
                Route::get('/', ClientTrackingIndex::class)
                    ->name('index')
                    ->middleware(['role:admin|agent'])
                    ->lazy();
            });

        /**
         * E.Q BUSINESS/TEAMS/
         *
         * ADMITTED ROLES:
         *
         */
        Route::prefix('teams')
            ->name('teams.')
            ->group(function () {
                Route::get('/', TeamsIndex::class)
                    ->name('index')
                    ->middleware(['role:admin|agent'])
                    ->lazy();
            });

        /**
         * E.Q BUSINESS/ASSIGNMENTS/
         *
         * ADMITTED ROLES:
         *
         */
        Route::prefix('assignments')
            ->name('assignments.')
            ->group(function () {
                Route::get('/', AssignmentsIndex::class)
                    ->name('index')
                    ->middleware(['role:admin|agent'])
                    ->lazy();
            });

        /**
         * E.Q BUSINESS/ACCESS-CONTROL/
         *
         * ADMITTED ROLES:
         *
         */
        Route::prefix('access-control')
            ->name('access-control.')
            ->group(function () {
                Route::get('/', AccesscontrolIndex::class)
                    ->name('index')
                    ->middleware(['role:admin'])
                    ->lazy();
                Volt::route('edit/{id}', 'business.access-control.edit')
                    ->name('edit')
                    ->middleware(['role:admin']);
            });

        Route::prefix('users')
            ->name('users.')
            ->group(function () {
                Volt::route('/', 'business.users.index')
                    ->name('index')
                    ->middleware(['role:admin'])
                    ->lazy();
                Volt::route('edit/{id}', 'business.users.edit')
                    ->name('edit')
                    ->middleware(['role:admin']);
            });
    });
