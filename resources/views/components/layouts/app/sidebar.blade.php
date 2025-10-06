@use('App\Helpers\Views\MiscHelper')
@use('App\Helpers\Views\NavItems')

@php
    $navItems = NavItems::getNavigationItems();
    $greetingMessage = MiscHelper::getGreeting();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        {{-- MODALS --}}
        <livewire:modals.generic.confirmation-modal />
        @role('admin')
            {{-- BUSINESS MODALS --}}
            <livewire:modals.business.customer.create-client-modal />
            <livewire:modals.business.assignment.assign-customers-modal />
            <livewire:modals.business.agents.create-agent-modal />
            <livewire:modals.business.teams.create-team-modal />
            <livewire:modals.business.assignments.create-assignment-modal />
            <livewire:modals.business.access-control.create-role-modal />

            {{-- WALLET MODALS --}}

            {{-- CALL MODALS --}}
            @endrole
        @role('agent|leader_agent|admin')
            {{-- <livewire:modals.business.assignment.fast-assign /> --}}
            <livewire:modals.sells.calls.init-call-modal />
            <livewire:modals.business.customer.update-mark-info-modal />
            <livewire:modals.business.client-tracking.create-client-tracking-modal/>
            @endrole
        @role('admin|agent|lead_agent|customer')
            <livewire:modals.accounts.update-wallet-modal />
            <livewire:modals.accounts.movements.create-movement />
        @endrole

        {{-- SIDEBAR --}}
        <flux:sidebar sticky stashable class="bg-zinc-50 dark:bg-ct-dark-bg">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                @role('admin')
                    <x-app-logo />
                @endrole
                @role('customer')
                    Wallet
                @endrole
            </a>

            <flux:navlist variant="solid">
                {{-- HOME SHARED ITEM --}}
                <flux:navlist.item
                    icon="home"
                    :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')"
                    wire:navigate>
                    {{ __('Inicio') }}
                </flux:navlist.item>
                @foreach ($navItems as $navItem)
                    @if (!$navItem['isGroup'])
                        @role($navItem['canSee'])
                            <flux:navlist.item
                                icon="{{ $navItem['icon'] }}"
                                :href="route($navItem['routeName'])"
                                :current="request()->routeIs($navItem['routeName'])"
                                wire:navigate>
                                {{ __($navItem['label']) }}
                            </flux:navlist.item>
                        @endrole
                    @elseif ($navItem['isGroup'])
                        @role($navItem['role'])
                            <flux:navlist.group :heading="__($navItem['heading'])" class="grid" expandable>
                                @foreach ($navItem['items'] as $item)
                                    @role($item['canSee'])
                                        <flux:navlist.item
                                            icon="{{ $item['icon'] }}"
                                            :href="route($item['routeName'])"
                                            :current="request()->routeIs($item['routeName'])"
                                            wire:navigate>
                                            {{ __($item['label']) }}
                                        </flux:navlist.item>
                                    @endrole
                                @endforeach
                            </flux:navlist.group>
                        @endrole
                    @endif
                @endforeach
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            @if (!Route::is('dashboard'))
                <x-table.theme-picker />

                <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                    @php
                        $userName = auth()->user()->name;
                        $avatarUrl = App\Helpers\Views\MiscHelper::genAvatarUrl('fun-emoji', ['seed' => $userName]);
                    @endphp
                    <flux:profile
                        :avatar:src="$avatarUrl"
                        avatar:circular
                        icon:trailing="bars-arrow-up"
                        :name="$userName"
                    />

                    <flux:menu class="max-w-[12rem] dark:bg-dropdown-dark-bg!">
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ $userName }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                        <span class="truncate text-xs">Rol actual: {{ auth()->user()->getCurrentRole() }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Ajustes') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                {{ __('Cerrar Sesion') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            @endif
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Ajustes') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Cerrar Seccion') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        {{-- @livewireScripts --}}
        @livewireScriptConfig
        @fluxScripts
        <x-dashboard.soa-notification.notification></x-dashboard.soa-notification.notification>
        @assets
            <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.11.2/build/js/intlTelInput.min.js"></script>
        @endassets
    </body>
</html>
