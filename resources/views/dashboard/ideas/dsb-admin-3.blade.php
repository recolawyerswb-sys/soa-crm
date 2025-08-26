{{-- KPIs del Equipo --}}
        <div class="grid auto-rows-min gap-4 md:grid-cols-6">
            <div class="rounded-xl border p-4 md:col-span-2">
                <h3 class="text-sm font-medium text-gray-500">Llamadas de mi Equipo (Hoy)</h3>
                <p class="mt-1 text-3xl font-semibold">128</p>
            </div>
            <div class="rounded-xl border p-4 md:col-span-2">
                <h3 class="text-sm font-medium text-gray-500">Ingresos de mi Equipo (Mes)</h3>
                <p class="mt-1 text-3xl font-semibold text-green-600">$4,800</p>
            </div>
            <div class="rounded-xl border p-4 md:col-span-2">
                <h3 class="text-sm font-medium text-gray-500">Agentes en Llamada</h3>
                <p class="mt-1 text-3xl font-semibold">5 / 10</p>
            </div>
        </div>

        {{-- Ranking y Gráfico --}}
        <div class="grid auto-rows-min gap-4 md:grid-cols-6">
            {{-- Ranking de Agentes (Tabla pequeña) --}}
            <div class="rounded-xl border p-4 md:col-span-2">
                <h3 class="font-semibold">Ranking de Agentes (Ingresos)</h3>
                {{-- Lista de agentes del equipo. Data de Agente y Movimientos --}}
                <ul class="mt-2 space-y-2">
                    <li>1. Ana Pérez - $1,200</li>
                    <li>2. Juan Gómez - $950</li>
                    <li>3. Maria Lopez - $800</li>
                </ul>
            </div>

            {{-- Gráfico de Actividad del Equipo --}}
            <div class="rounded-xl border p-4 md:col-span-4">
                <h3 class="font-semibold">Volumen de llamadas del equipo</h3>
                {{-- Gráfico de barras por agente o por día --}}
                <div class="mt-4 h-48">
                    <x-placeholder-pattern class="size-full" />
                </div>
            </div>
        </div>

        {{-- Tabla de Asignaciones del Equipo --}}
        <div class="relative flex-1 overflow-hidden rounded-xl border">
             <h1 class="mb-4 p-3 text-xl font-semibold">{{ __('Clientes Asignados a mi Equipo') }}</h1>
             {{-- Aquí iría una tabla Livewire filtrada por el equipo del líder --}}
             {{-- @livewire('assignments.assignments-table', ['team_id' => auth()->user()->team_id]) --}}
        </div>
