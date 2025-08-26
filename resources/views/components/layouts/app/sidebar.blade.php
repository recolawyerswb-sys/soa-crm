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
            <livewire:modals.business.customer.update-mark-info-modal />
            <livewire:modals.business.agents.create-agent-modal />
            <livewire:modals.business.teams.create-team-modal />
            <livewire:modals.business.assignments.create-assignment-modal />
            <livewire:modals.business.access-control.create-role-modal />

            {{-- WALLET MODALS --}}
            <livewire:modals.accounts.update-wallet-modal />
            <livewire:modals.accounts.movements.create-movement />
            {{-- <livewire:modals.business.user.create /> --}}
        @endrole
        @role('agent-leader|admin')
            {{-- <livewire:modals.business.assignment.fast-assign /> --}}
        @endrole
        @role('cliente')
            {{-- <livewire:modals.movement.create-movement /> --}}
        @endrole

        {{-- SIDEBAR --}}
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                {{-- HOME SHARED ITEM --}}
                <flux:navlist.item
                    icon="home"
                    :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')"
                    wire:navigate>
                    {{ __('Inicio') }}
                </flux:navlist.item>
                @foreach ($navItems as $navItem)
                    @role($navItem['role'])
                        @if (!$navItem['isGroup'])
                            <flux:navlist.item
                                icon="{{ $navItem['icon'] }}"
                                :href="route($navItem['routeName'])"
                                :current="request()->routeIs($navItem['routeName'])"
                                wire:navigate>
                                {{ __($navItem['label']) }}
                            </flux:navlist.item>
                        @elseif ($navItem['isGroup'])
                            <flux:navlist.group :heading="__($navItem['heading'])" class="grid" expandable>
                                @foreach ($navItem['items'] as $item)
                                    <flux:navlist.item
                                        icon="{{ $item['icon'] }}"
                                        :href="route($item['routeName'])"
                                        :current="request()->routeIs($item['routeName'])"
                                        wire:navigate>
                                        {{ __($item['label']) }}
                                    </flux:navlist.item>
                                @endforeach
                            </flux:navlist.group>
                        @endif
                    @endrole
                @endforeach
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
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
                            {{ __('Cerrar Sesion') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Secondary Main Header Nav -->
        @if (request()->is('crm'))
            <flux:header class="hidden lg:flex! py-5 bg-white lg:bg-zinc-50 dark:bg-zinc-950">
                <div class="w-full">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-neutral-50">
                        {{-- Título del panel de control --}}
                        @php
                            echo $greetingMessage;
                        @endphp
                    </h1>
                </div>
                @if (!request()->is('settings/*'))
                    <flux:navbar class="gap-4">
                        {{-- ADMIN HELPER BUTTONS --}}
                        @role('admin')
                            <flux:modal.trigger name="create-client">
                                <flux:button variant="primary" class="cursor-pointer" @click="$dispatch('unable-edit-for-create-client-modal')">Crear un cliente</flux:button>
                            </flux:modal.trigger>
                            <flux:modal.trigger name="create-user">
                                <flux:button variant="primary" class="cursor-pointer">Crear un nuevo usuario</flux:button>
                            </flux:modal.trigger>
                        @endrole
                        @role('agent-leader|admin')
                            <flux:modal.trigger name="fast-assign">
                                <flux:button>Asignación rápida</flux:button>
                            </flux:modal.trigger>
                        @endrole
                        {{-- CUSTOMER HELPER BUTTONS --}}
                        @role('cliente')
                            <flux:modal.trigger name="create-movement">
                                <flux:button variant="primary" class="cursor-pointer">Crear movimiento</flux:button>
                            </flux:modal.trigger>
                        @endrole
                        {{-- AGENT HELPER BUTTONS --}}
                        {{-- @role('agent-leader')
                            <flux:modal.trigger name="assign-agent-to-customer">
                                <flux:button variant="primary" class="cursor-pointer">Asigna</flux:button>
                            </flux:modal.trigger>
                        @endrole --}}
                    </flux:navbar>
                @endif
            </flux:header>
        @endif

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
    </body>
</html>
