@php
    $greetingMessage = App\Helpers\Views\MiscHelper::getGreeting();
    $userName = auth()->user()->name;
    $authUserLastLogin = auth()->user()->lastLogin();
    $authUserOnlineStatus = auth()->user()->is_online ? 'Conectado' : 'No conectado';
    $avatarUrl = App\Helpers\Views\MiscHelper::genAvatarUrl('fun-emoji', ['seed' => $userName]);
@endphp

<flux:header class="hidden lg:flex! py-3 sticky top-0 z-50 w-full header-bg backdrop-blur-md">
    <div class="w-full flex flex-col gap-1">
        <h1 class="text-xl text-gray-900 dark:text-neutral-50">
            {{ $greetingMessage }}!
            <b>{{ auth()->user()->name }}.</b>
        </h1>
        <p class="text-sm text-gray-600 dark:text-neutral-200">Ultimo inicio de sesion:
            <span class="font-bold italic">{{ $authUserLastLogin }}</span>
        </p>
        <p class="text-sm text-gray-600 dark:text-neutral-200">Estado:
            <span class="font-bold italic">{{ $authUserOnlineStatus }}</span>
        </p>
    </div>
    {{-- AUX NAVBAR FOR FAST LINKS --}}
    <div class="flex gap-2">
        {{-- ROLE FAST LINKS --}}
        @role('admin')
        {{-- CREATE CLIENT --}}
            <flux:modal.trigger name="create-client">
                <flux:button variant="ghost" icon:trailing="user-plus" size="sm" class="cursor-pointer" @click="$dispatch('unable-edit-for-create-client-modal')">Crear Cliente</flux:button>
            </flux:modal.trigger>
            <flux:modal.trigger name="create-agent">
                <flux:button variant="ghost" icon:trailing="user-plus" size="sm" class="cursor-pointer" @click="$dispatch('unable-edit-for-create-agent-modal')">Crear Agente</flux:button>
            </flux:modal.trigger>
            <flux:modal.trigger name="create-movement-modal">
                <flux:button variant="ghost" icon:trailing="currency-dollar" size="sm" class="cursor-pointer" @click="$dispatch('unable-edit-for-create-movement-modal')">Crear Movimiento</flux:button>
            </flux:modal.trigger>
        @endrole
        @role('agent|lead_agent')
            <flux:button wire:navigate variant="primary" href="{{ route('business.customers.index') }}" icon:trailing="users" size="sm" class="cursor-pointer">Ver clientes</flux:button>
        @endrole
        @role('customer')
            <flux:modal.trigger name="create-movement-modal">
                <flux:button variant="primary" icon:trailing="currency-dollar" size="sm" class="cursor-pointer" @click="$dispatch('unable-edit-for-create-movement-modal')">Crear Movimiento</flux:button>
            </flux:modal.trigger>
        @endrole
    </div>
    {{-- USER OPTIONS NAVBAR --}}
    <flux:navbar class="gap-2 ms-2">
        {{-- ADMIN HELPER BUTTONS --}}
        <x-table.theme-picker />

        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile
                :avatar:src="$avatarUrl"
                avatar:circular
                icon:trailing="bars-arrow-down"
            />

            <flux:menu class="max-w-[12rem] dark:bg-dropdown-dark-bg!">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
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
    </flux:navbar>
</flux:header>
