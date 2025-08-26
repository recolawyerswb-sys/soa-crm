{{-- Fila de KPIs Principales --}}
<div class="grid auto-rows-min gap-4 md:grid-cols-12">

    {{-- KPI 1: Agentes Activos --}}
    <div class="relative rounded-xl border p-4 md:col-span-3">
        <h3 class="text-sm font-medium text-gray-500">Agentes Activos</h3>
        <p class="mt-1 text-3xl font-semibold">
            {{-- Data: count(agentes where status='activo') --}}
            42 / 50
        </p>
    </div>

    {{-- KPI 2: Llamadas en Curso --}}
    <div class="relative rounded-xl border p-4 md:col-span-3">
        <h3 class="text-sm font-medium text-gray-500">Llamadas en Curso</h3>
        <p class="mt-1 text-3xl font-semibold">
            {{-- Data: count(llamadas where status='en-curso') --}}
            15
        </p>
    </div>

    {{-- KPI 3: Ingresos Aprobados (Mes) --}}
    <div class="relative rounded-xl border p-4 md:col-span-3">
        <h3 class="text-sm font-medium text-gray-500">Ingresos del Mes</h3>
        <p class="mt-1 text-3xl font-semibold text-green-600">
            {{-- Data: sum(movimientos where status='aprobado' en este mes) --}}
            $12,450
        </p>
    </div>

    {{-- KPI 4: Movimientos Pendientes --}}
    <div class="relative rounded-xl border p-4 md:col-span-3">
            <h3 class="text-sm font-medium text-gray-500">Pendiente de Aprobación</h3>
        <p class="mt-1 text-3xl font-semibold text-orange-500">
            {{-- Data: sum(movimientos where status='pendiente') --}}
            $1,200
        </p>
    </div>
</div>

{{-- Fila de Gráficos y Resúmenes --}}
<div class="grid auto-rows-min gap-4 md:grid-cols-12">

    {{-- Gráfico Principal: Rendimiento de Llamadas --}}
    <div class="relative rounded-xl border p-4 md:col-span-6 md:row-span-2">
            <h3 class="font-semibold">Llamadas vs. Ingresos (Últimos 30 días)</h3>
            {{-- Aquí iría un componente de gráfico (ej. Chart.js, ApexCharts) --}}
            <div class="mt-4 h-64">
            <x-placeholder-pattern class="size-full" />
            </div>
    </div>

    {{-- Resumen 1: Equipos con Mejor Rendimiento --}}
    <div class="relative rounded-xl border p-4 md:col-span-6">
            <h3 class="font-semibold">Top Equipos (Ingresos)</h3>
            {{-- Lista de equipos: Data de modelo Equipo y Movimientos --}}
            <ul class="mt-2 space-y-2">
            <li class="flex justify-between"><span>Equipo Alfa</span> <span class="font-bold">$4,800</span></li>
            <li class="flex justify-between"><span>Equipo Beta</span> <span class="font-bold">$3,950</span></li>
            <li class="flex justify-between"><span>Equipo Gamma</span> <span class="font-bold">$3,100</span></li>
            </ul>
    </div>

    {{-- Resumen 2: Movimientos Recientes para Aprobar --}}
    <div class="relative rounded-xl border p-4 md:col-span-6">
            <h3 class="font-semibold">Movimientos Pendientes Recientes</h3>
            {{-- Lista de movimientos: Data del modelo Movimientos --}}
            <ul class="mt-2 space-y-2">
            <li class="flex justify-between"><span>Agente X - Cliente Y</span> <span class="text-orange-500">$250</span></li>
            <li class="flex justify-between"><span>Agente Z - Cliente W</span> <span class="text-orange-500">$150</span></li>
            </ul>
    </div>
</div>

{{-- Tabla de Agentes --}}
<div class="relative flex-1 overflow-hidden rounded-xl border">
    <h1 class="mb-4 p-3 text-xl font-semibold">{{ __('Actividad Reciente de Agentes') }}</h1>
    {{-- @livewire('user.users-table') --}}
    {{-- Tu tabla livewire encaja perfecto aquí --}}
</div>
