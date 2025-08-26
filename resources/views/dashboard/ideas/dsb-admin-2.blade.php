<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        {{-- KPIs Personales --}}
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="rounded-xl border p-4">
                <h3 class="text-sm font-medium text-gray-500">Mis Llamadas (Hoy)</h3>
                <p class="mt-1 text-3xl font-semibold">25</p>
            </div>
            <div class="rounded-xl border p-4">
                <h3 class="text-sm font-medium text-gray-500">Mis Ingresos (Mes)</h3>
                <p class="mt-1 text-3xl font-semibold text-green-600">$1,200</p>
            </div>
            <div class="rounded-xl border p-4">
                <h3 class="text-sm font-medium text-gray-500">Mi Ranking en Equipo</h3>
                <p class="mt-1 text-3xl font-semibold">#1</p>
            </div>
        </div>

        {{-- Área Principal de Trabajo --}}
        <div class="grid flex-1 auto-rows-min gap-4 md:grid-cols-4">
            {{-- Tabla Principal: Mis Clientes Asignados --}}
            <div class="relative flex-1 overflow-hidden rounded-xl border md:col-span-3">
                <h1 class="mb-4 p-3 text-xl font-semibold">{{ __('Mis Clientes Asignados') }}</h1>
                {{-- Tabla Livewire con los clientes del modelo Asignaciones para el agente actual --}}
                {{-- @livewire('assignments.my-assignments-table') --}}
                {{-- Esta tabla debería tener botones de "Llamar" o "Ver Detalles" --}}
            </div>

            {{-- Barra Lateral de Información --}}
            <div class="flex flex-col gap-4">
                <div class="rounded-xl border p-4">
                    <h3 class="font-semibold">Siguiente Llamada Sugerida</h3>
                    <p class="mt-2 text-lg">Cliente: ACME Inc.</p>
                    <button class="mt-2 w-full rounded-lg bg-blue-600 py-2 text-white">Llamar Ahora</button>
                </div>
                <div class="rounded-xl border p-4">
                     <h3 class="font-semibold">Mi Actividad Reciente</h3>
                     {{-- Lista de últimas llamadas --}}
                     <ul class="mt-2 text-sm">
                        <li>Llamada a "Tech Corp" - 10:45 AM</li>
                        <li>Ingreso registrado: $150 - 10:30 AM</li>
                     </ul>
                </div>
            </div>
        </div>
