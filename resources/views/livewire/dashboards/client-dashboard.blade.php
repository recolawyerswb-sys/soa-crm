{{--
  Contenedor principal del Dashboard.
--}}
<div class="relative min-h-screen bg-gray-50 dark:bg-zinc-900 pb-24"> {{-- DARK MODE --}}

    {{-- 1. HEADER --}}
    {{-- Recuerda que este componente también debe ser adaptado para el modo oscuro --}}
    <x-dashboard.header />

    {{-- 2. CONTENIDO PRINCIPAL --}}
    <div class="h-full p-4 md:p-6 space-y-8">

        {{-- Título de la sección --}}
        <h2 class="text-2xl font-bold text-gray-800 dark:text-zinc-200"> {{-- DARK MODE --}}
            Estadísticas generales de mi perfil
        </h2>

        {{-- SECCIÓN DE ESTADÍSTICAS --}}
        {{-- Los componentes <x-dashboard.stat> deben ser actualizados internamente --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-dashboard.stat title="Mi balance">
                {{ '$' . number_format($this->userTotalBalance, 2) }}
            </x-dashboard.stat>

            <x-dashboard.stat title="Mi total depositado">
                {{ '$' . number_format($this->userTotalDeposit, 2) }}
            </x-dashboard.stat>

            <x-dashboard.stat title="Mi total retirado">
                {{ '$' . number_format($this->userTotalWithdrawal, 2) }}
            </x-dashboard.stat>

            <x-dashboard.stat title="Clientes activos">
                3
            </x-dashboard.stat>
        </div>

        {{-- CONTENEDOR PARA LA TABLA --}}
        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-zinc-200 mb-4"> {{-- DARK MODE --}}
                Últimos Movimientos
            </h3>
            {{-- DARK MODE: Se cambió el fondo, se quitó la sombra y se añadió un borde --}}
            <div class="bg-white dark:bg-zinc-800 dark:border dark:border-zinc-700 p-4 rounded-lg shadow-sm">
                <p class="text-center text-gray-400 dark:text-zinc-500 py-8"> {{-- DARK MODE --}}
                    Tu componente de tabla irá aquí.
                </p>
            </div>
        </div>

    </div>

    {{-- 3. FOOTER FIJO CON ACCIONES --}}
    {{-- DARK MODE: Se cambió el fondo y el color del borde --}}
    <footer class="sticky bottom-0 left-0 right-0 w-full bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm border-t border-gray-200 dark:border-zinc-700">
        <div class="flex items-center gap-3 p-4 max-w-7xl mx-auto">
            {{-- Tus componentes de botón también necesitarán soporte para modo oscuro --}}
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
    </footer>
</div>
