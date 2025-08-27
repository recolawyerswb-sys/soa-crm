<div class="relative ">
    <flux:header class="hidden lg:flex! py-5 bg-white lg:bg-zinc-50 dark:bg-zinc-950">
        <div class="w-full flex flex-col gap-1">
            <h1 class="text-xl text-gray-900 dark:text-neutral-50">
                {{ $greetingTimeMessage }}!
                <b>{{ $userName }}.</b>
            </h1>
            <p class="text-sm text-neutral-200">En este espacio podras administrar tus usuarios y tus datos personales. <i>Buena suerte</i></p>
        </div>
        <flux:navbar class="gap-4">
            {{-- ADMIN HELPER BUTTONS --}}
            {{-- @role('admin')
                <flux:modal.trigger name="create-client">
                    <flux:button variant="primary" class="cursor-pointer" @click="$dispatch('unable-edit-for-create-client-modal')">Crear un cliente</flux:button>
                </flux:modal.trigger>
                <flux:modal.trigger name="create-user">
                    <flux:button variant="primary" class="cursor-pointer">Crear un nuevo usuario</flux:button>
                </flux:modal.trigger>
            @endrole --}}
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:button icon:trailing="light-bulb" variant="subtle">Tema</flux:button>
                <flux:menu class="w-auto">
                    <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                        <flux:radio value="light" icon="sun">{{ __('Claro') }}</flux:radio>
                        <flux:radio value="dark" icon="moon">{{ __('Oscuro') }}</flux:radio>
                    </flux:radio.group>
                </flux:menu>
            </flux:dropdown>

            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    avatar:color="indigo"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="max-w-[12rem]">
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

    <div class="px-7">
        <div class="grid grid-cols-4 auto-rows-auto gap-4">
            {{-- COL 1, FILA 1, TITULO --}}
            <div class="col-span-3">
                <h2 class="text-lg font-semibold">Estadisticas generales del negocio</h2>
            </div>
            {{-- COL 1, FILA 2, STATS --}}
            <div class="col-start-1 row-start-2">
                <x-dashboard.stat title="Balance total de los usuarios">
                    {{ '$' . number_format(\App\Models\Wallet::getTotalAccBalance(), 2) }}
                </x-dashboard.stat>
            </div>
            <div class="col-start-2 row-start-2">
                <x-dashboard.stat title="Agentes totales">
                    {{-- Data: sum(movimientos where status='pendiente') --}}
                    {{ $this->totalAgents }}
                </x-dashboard.stat>
            </div>
            <div class="col-start-3 row-start-2">
                <x-dashboard.stat title="Clientes totales">
                    {{-- Data: sum(movimientos where status='pendiente') --}}
                    {{ $this->totalCustomers }}
                </x-dashboard.stat>
            </div>
            <div class="col-start-1 row-start-3">
                <x-dashboard.stat title="Llamadas totales">
                    {{-- Data: sum(movimientos where status='pendiente') --}}
                    0
                </x-dashboard.stat>
            </div>
            <div class="col-start-2 row-start-3">
                <x-dashboard.stat title="Clientes en linea">
                    {{-- Data: sum(movimientos where status='pendiente') --}}
                    0
                </x-dashboard.stat>
            </div>
            <div class="col-start-3 row-start-3">
                <x-dashboard.stat title="Agentes en linea">
                    {{-- Data: sum(movimientos where status='pendiente') --}}
                    0
                </x-dashboard.stat>
            </div>
            {{-- COL 1, FILA 4, TITULO --}}
            <div class="row-span-5 col-start-4 row-start-1">
                9
            </div>
            <div class="col-span-3 row-start-4">
                <h2 class="text-lg font-semibold">Estadisticas generales de mi perfil</h2>
            </div>
            <div class="row-start-5">
                <x-dashboard.stat title="Mi balance">
                    {{-- Data: sum(movimientos where status='pendiente') --}}
                    {{ '$' . number_format($this->userTotalBalance, 2) }}
                </x-dashboard.stat>
            </div>
            <div class="row-start-5">
                <x-dashboard.stat title="Mi total depositado">
                    {{-- Data: sum(movimientos where status='pendiente') --}}
                    {{ '$' . number_format($this->userTotalDeposit, 2) }}
                </x-dashboard.stat>
            </div>
            <div class="row-start-5">
                <x-dashboard.stat title="Mi total retirado">
                    {{-- Data: sum(movimientos where status='pendiente') --}}
                    {{ '$' . number_format($this->userTotalWithdrawal, 2) }}
                </x-dashboard.stat>
            </div>
        </div>
    </div>

    <div class="fixed bottom-0 flex w-full gap-3">
        <!-- Trigger for creating a new client. MODAL. Only change the name -->
        <flux:modal.trigger name="create-client">
            <flux:button icon="plus" variant="primary">
                Crear un cliente
            </flux:button>
        </flux:modal.trigger>
        <flux:button variant="ghost" href="{{ route('wallet.movements.index') }}">Ir a movimientos</flux:button>
        {{-- <flux:button variant="ghost" href="{{ route('sells.calls.index') }}">Ir a reporte de llamadas</flux:button> --}}
        <flux:button variant="filled" icon="information-circle" class="ms-auto">
            Ayuda
        </flux:button>
    </div>

</div>

