{{--
  Contenedor principal del Dashboard.
--}}
<div class="relative min-h-screen pb-24 bg-shape-dots"> {{-- DARK MODE --}}

    {{-- 1. HEADER --}}
    {{-- Recuerda que este componente también debe ser adaptado para el modo oscuro --}}
    <x-dashboard.header />

    {{-- 2. CONTENIDO PRINCIPAL --}}
    <div class="h-full p-4 md:p-6 space-y-8">

        {{-- Título de la sección --}}
        <h2 class="text-xl font-bold text-gray-800 dark:text-zinc-200">
            Estadisticas de mi cuenta
        </h2>

        <x-dashboard.stats.refresh-btn />

        {{-- SECCIÓN DE ESTADÍSTICAS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- BALANCES Y ASIGNACION --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <x-dashboard.stats.stat
                    title="Mi balance"
                    content="{{ '$' . number_format($this->userTotalBalance, 2) }}"
                />
                <x-dashboard.stats.stat
                    title="Mi total depositado"
                    content="{{ '$' . number_format($this->userTotalDeposit, 2) }}"
                />
                <x-dashboard.stats.stat
                    title="Mi total retirado"
                    content="{{ '$' . number_format($this->userTotalWithdrawal, 2) }}"
                />
                <x-dashboard.stats.stat
                    title="Agente asignado"
                    content="{{ strtoupper($this->assignedAgentName) }}"
                />
            </div>

            <div>
                <x-dashboard.stats.wallet-details
                    :details="$details"
                />
            </div>

            {{-- WALLET INFO --}}

        </div>

        {{-- CONTENEDOR PARA LA TABLA --}}
        <div class="grid grid-cols-1 gap-4">
            <div>
                <div class="bg-white dark:bg-zinc-800 dark:border dark:border-white/5 rounded-xl">
                    <livewire:accounts.movements.widgets.latest-customers-movements-widget />
                </div>
            </div>
        </div>

    </div>

    {{-- 3. FOOTER FIJO CON ACCIONES --}}
    {{-- DARK MODE: Se cambió el fondo y el color del borde --}}
    <footer class="sticky bottom-0 left-0 right-0 w-full bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm border-t border-gray-200 dark:border-zinc-700">
        <div class="flex items-center gap-3 p-4 max-w-7xl mx-auto">
            {{-- Tus componentes de botón también necesitarán soporte para modo oscuro --}}
            <flux:modal.trigger name="create-movement-modal">
                <flux:button icon="plus" variant="primary">
                    Crear un movimiento
                </flux:button>
            </flux:modal.trigger>
            <flux:modal.trigger name="update-wallet-modal">
                <flux:button
                    icon="pencil"
                    variant="primary"
                    color="zinc"
                    class="cursor-pointer"
                    @click="$dispatch('enable-edit-for-update-wallet-modal', { walletId: '{{ $this->userWallet }}' })">
                    Editar wallet
                </flux:button>
            </flux:modal.trigger>
            <flux:button variant="ghost" href="{{ route('wallet.movements.index') }}">
                Ver todos los movimientos
            </flux:button>
            <flux:button variant="filled" icon="information-circle" class="ms-auto">
                Ayuda
            </flux:button>
        </div>
    </footer>
</div>
