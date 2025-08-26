{{-- Fila de KPIs Principales con Descripción --}}
<div class="grid auto-rows-min gap-6 md:grid-cols-2 lg:grid-cols-4">

    {{-- KPI 1: Saldo Total --}}
    <x-dashboard.stat
        title="Saldo Total"
        description="El valor total de su cuenta, incluyendo inversiones."
    >
        {{-- Data: $cliente->balance->total --}}
        <span class="text-green-600 dark:text-green-500">$15,720.50</span>
    </x-dashboard.stat>

    {{-- KPI 2: Saldo Disponible --}}
    <x-dashboard.stat
        title="Saldo Disponible"
        description="El capital disponible para operar o retirar."
    >
        {{-- Data: $cliente->balance->available --}}
        $2,115.00
    </x-dashboard.stat>

    {{-- KPI 3: Ganancia / Pérdida (Mes) --}}
    <x-dashboard.stat
        title="Resultado del Mes"
        description="El rendimiento de su cuenta en los últimos 30 días."
    >
        {{-- Data: $cliente->performance->monthly_pnl --}}
        <span class="text-red-600 dark:text-red-500">-$280.00</span>
    </x-dashboard.stat>

    {{-- KPI 4: Estado de la Cuenta --}}
        <x-dashboard.stat
        title="Estado de la Cuenta"
        description="Su cuenta está operativa y sin restricciones."
    >
        {{-- Data: $cliente->status --}}
        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800 dark:bg-green-900 dark:text-green-200">
            Activa
        </span>
    </x-dashboard.stat>
</div>

{{-- Sección Principal: Gráfica de Trading e Información de Soporte --}}
<div class="grid auto-rows-min gap-6 lg:grid-cols-12">

    {{-- Espacio para Gráfica de Trading --}}
    <div class="relative min-h-[400px] rounded-xl border-2 border-dashed border-neutral-300 dark:border-neutral-700 lg:col-span-9">
        <div class="flex h-full w-full items-center justify-center">
            {{-- <div class="text-center">
                <h3 class="text-lg font-medium text-gray-700 dark:text-neutral-300">Gráfico de Trading</h3>
                <p class="text-sm text-gray-500 dark:text-neutral-400">Aquí se mostrará el rendimiento de sus activos.</p>
            </div> --}}
            <x-dashboard.trading-view.crypto-heatmap />
        </div>
    </div>

    {{-- Barra Lateral con Información Clave --}}
    <div class="flex flex-col gap-6 lg:col-span-3">
        <x-dashboard.stat
            title="Su Agente Asignado"
            description="Su punto de contacto para cualquier consulta."
        >
            {{-- Data: $cliente->assignedAgent->name --}}
            <div class="flex items-center gap-3">
                <img class="size-10 rounded-full" src="https://via.placeholder.com/40" alt="Foto de perfil del agente">
                <div>
                    <p class="font-semibold">Ana Pérez</p>
                    <a href="mailto:ana.perez@example.com" class="text-sm text-blue-600 hover:underline dark:text-blue-400">Contactar</a>
                </div>
            </div>
        </x-dashboard.stat>

        <div class="rounded-xl border-2 border-neutral-200 p-4 dark:border-neutral-800">
            <h3 class="font-bold text-gray-900 dark:text-neutral-50">¿Necesita Ayuda?</h3>
            <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">Agende una llamada o visite nuestro centro de ayuda.</p>
            <button class="mt-4 w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                Agendar Llamada
            </button>
        </div>
    </div>
</div>

{{-- Sección de Últimos Movimientos --}}
<div class="relative overflow-hidden rounded-xl border-2 border-neutral-200 dark:border-neutral-800">
    <h2 class="p-5 text-2xl font-bold text-gray-900 dark:text-neutral-50">
        Últimos Movimientos
    </h2>
    <div class="overflow-x-auto px-5 pb-5">
        {{-- Aquí iría una tabla (Livewire o estática) con los movimientos del cliente --}}
        {{-- @livewire('movements.client-movements-table', ['client_id' => $cliente->id]) --}}
        {{-- <x-placeholder-table /> --}}
        {{-- Componente de tabla de ejemplo --}}
    </div>
</div>
