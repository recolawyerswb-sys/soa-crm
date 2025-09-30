{{-- Contenedor principal del Dashboard con estilos base y espacio para el footer --}}
<div class="relative min-h-screen pb-24 bg-shape-dots">

    {{-- 1. HEADER --}}
    <x-dashboard.header />

    {{-- 2. CONTENIDO PRINCIPAL --}}
    {{-- `space-y-8` crea un espaciado vertical limpio entre cada sección --}}
    <div class="h-full p-4 md:p-6 space-y-8">
        <x-dashboard.stats.refresh-btn />
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                {{-- <h2 class="text-lg font-bold text-gray-800 dark:text-zinc-200 mb-4">
                    Balances, agentes y llamadas
                </h2> --}}
                {{-- Grid responsive de 4 columnas para todas las tarjetas de estadísticas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    {{-- Fila 1 de Stats --}}
                    <x-dashboard.stats.stat
                        title="Clientes asignados"
                        content="{{ $this->totalAssigned }}"
                    />
                    <x-dashboard.stats.stat
                        title="Llamadas realizadas"
                        content="{{ $this->totalCalls }}"
                    />
                    <x-dashboard.stats.stat
                        title="LLamadas exitosas"
                        content="{{ $this->totalSuccesfullCalls }}"
                    />
                    <x-dashboard.stats.stat
                        title="Llamadas rechazadas"
                        content="{{ $this->totalDeclinedCalls }}"
                    />
                </div>
            </div>

            <div>
                {{-- <h2 class="text-2xl font-bold text-gray-800 dark:text-zinc-200 mb-4">
                    Mis saldos y billetera
                </h2> --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    {{-- Fila 2 de Stats --}}
                    <x-dashboard.stats.stat
                        title="Mi dia libre"
                        content="{{ $this->dayOff }}"
                    />
                    <x-dashboard.stats.stat
                        title="Mi horario de entrada"
                        content="{{ $this->checkInHour }}"
                    />
                    <x-dashboard.stats.stat
                        class="col-span-2"
                        title="Estado de asistencia hoy"
                        content="{{ $this->attendanceStatus }}"
                    />
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <div class="bg-white dark:bg-zinc-800 dark:border dark:border-white/5 rounded-xl">
                    {{-- <p class="text-center text-gray-400 dark:text-zinc-500 py-8">
                        Tu componente de tabla de usuarios irá aquí.
                    </p> --}}
                    {{-- <livewire:business.customers.widgets.latest-customers-widget /> --}}
                </div>
            </div>
            <div>
                <div class="bg-white dark:bg-zinc-800 dark:border dark:border-white/5 rounded-xl">
                    {{-- <p class="text-center text-gray-400 dark:text-zinc-500 py-8">
                        Tu componente de tabla de movimientos irá aquí.
                    </p> --}}
                    {{-- <livewire:accounts.movements.widgets.latest-movements-widget /> --}}
                </div>
            </div>
        </div>

    </div>

    {{-- 3. FOOTER FIJO CON ACCIONES --}}
    {{-- <footer class="sticky bottom-0 left-0 right-0 w-full bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm border-t border-gray-200 dark:border-zinc-700">
        <div class="flex items-center gap-3 p-4 max-w-7xl mx-auto">
            <flux:modal.trigger name="create-client">
                <flux:button icon="plus" variant="primary">
                    Crear un cliente
                </flux:button>
            </flux:modal.trigger>
            <flux:button variant="ghost" href="{{ route('wallet.movements.index') }}">
                Ir a movimientos
            </flux:button>
            <flux:button variant="filled" icon="information-circle" class="ms-auto">
                Ayuda
            </flux:button>
        </div>
    </footer> --}}

</div>
