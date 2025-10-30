<?php

use App\Livewire\Business\AccessControl\Index as AccesscontrolIndex;
use App\Livewire\Business\Agents\Index as AgentsIndex;
use App\Livewire\Business\Agents\Show as AgentsShow;
use App\Livewire\Business\Customers\Index as CustomersIndex;
use App\Livewire\Business\Teams\Index as TeamsIndex;
use App\Livewire\Business\Assignments\Index as AssignmentsIndex;
use App\Livewire\Business\ClientTracking\Index as ClientTrackingIndex;
use App\Livewire\Business\Customers\Show as CustomersShow;
use App\Livewire\Business\Users\Index as UsersIndex;
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
                    ->middleware(['auth', 'role:developer|admin|agent'])
                    ->lazy();
                Route::get('show/{customer}', CustomersShow::class)
                    ->name('show')
                    ->middleware(['role:developer,admin,agent'])
                    ->lazy();
            })->middleware('auth');

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
                    ->middleware(['role:developer|admin|agent'])
                    ->lazy();
                Route::get('show/{agent}', AgentsShow::class)
                    ->name('show')
                    ->middleware(['role:developer|admin|agent'])
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
                            ->middleware(['role:developer|admin|agent']);
                        Volt::route('edit/{id}', 'business.agents.leaders.edit')
                            ->name('edit')
                            ->middleware(['role:developer|admin|agent']);
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
                    ->middleware(['role:developer|admin|agent'])
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
                    ->middleware(['role:developer|admin|agent'])
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
                    ->middleware(['role:developer|admin|agent'])
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
                Route::get('roles-permissions', AccesscontrolIndex::class)
                    ->name('roles-permissions')
                    ->middleware(['role:developer|admin'])
                    ->lazy();
                Route::get('users', UsersIndex::class)
                    ->name('users')
                    ->middleware(['role:developer|admin'])
                    ->lazy();
            });
    });
