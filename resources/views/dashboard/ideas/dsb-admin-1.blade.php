@use('App\Models\Agent')
@use('App\Models\Customer')
@php
    $agent = new Agent();
    $customer = new Customer();
@endphp
{{-- ============================================= --}}
        {{-- Fila 1: KPIs Globales de Salud del Negocio --}}
        {{-- ============================================= --}}
        <div class="grid auto-rows-min gap-6 md:grid-cols-2 lg:grid-cols-4">

            <x-dashboard.stat
                title="Valor Pendiente de Aprobación"
                description="Suma total de dinero esperando revisión."
            >
                {{-- Data: sum(movimientos where status='pendiente') --}}
                <span class="text-orange-500">$3,150.75</span>
            </x-dashboard.stat>

            <x-dashboard.stat
                title="Ingresos del Mes"
                description="Total aprobado en los últimos 30 días."
            >
                {{-- Data: sum(movimientos where status='aprobado' en 30d) --}}
                <span class="text-green-600 dark:text-green-500">$21,840.00</span>
            </x-dashboard.stat>

            <x-dashboard.stat
                title="Clientes Nuevos (30 días)"
                description="Nuevos clientes registrados este mes."
            >
                {{-- Data: count(clientes where created_at in 30d) --}}
                84
            </x-dashboard.stat>

            <x-dashboard.stat
                title="Agentes en Línea"
                description="Agentes actualmente activos en la plataforma."
            >
                {{-- Data: count(agentes where status='online') --}}
                38 / 50
            </x-dashboard.stat>
        </div>

        {{-- ============================================= --}}
        {{-- Fila 2: Centro de Acción Principal         --}}
        {{-- ============================================= --}}
        <div class="grid auto-rows-min gap-6 lg:grid-cols-12">

            {{-- Tarjeta de Aprobaciones Pendientes --}}
            <div class="rounded-xl border-2 border-indigo-500/50 bg-indigo-50/50 p-6 dark:border-indigo-500/60 dark:bg-indigo-500/10 lg:col-span-12">
                <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-neutral-50">Centro de Aprobaciones</h2>
                        <p class="mt-1 text-gray-600 dark:text-neutral-400">
                           Tienes <strong class="text-indigo-600 dark:text-indigo-400">{{-- count($pendingMovements) --}} 8 movimientos</strong> que requieren tu atención.
                        </p>
                    </div>
                    <a href="#" class="inline-block rounded-lg bg-blue-600 px-5 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Ver Todos
                    </a>
                </div>

                {{-- Lista de acciones rápidas --}}
                <ul class="mt-4 divide-y divide-neutral-200 dark:divide-neutral-700">
                    {{-- Item de ejemplo 1 --}}
                    <li class="flex flex-col items-start gap-3 py-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-neutral-200">Venta 'Plan Oro' a Tech Solutions Inc.</p>
                            <p class="text-sm text-gray-500 dark:text-neutral-400">Por: <span class="font-medium">Juan Gómez</span> | Hace 15 minutos</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-lg font-bold text-gray-800 dark:text-neutral-50">$800.00</span>
                            <button class="rounded-md bg-red-600 px-3 py-1 text-xs font-bold text-white hover:bg-red-700">Rechazar</button>
                            <button class="rounded-md bg-green-600 px-3 py-1 text-xs font-bold text-white hover:bg-green-700">Aprobar</button>
                        </div>
                    </li>
                    {{-- Item de ejemplo 2 --}}
                    <li class="flex flex-col items-start gap-3 py-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-neutral-200">Comisión por renovación de Data Corp.</p>
                            <p class="text-sm text-gray-500 dark:text-neutral-400">Por: <span class="font-medium">Ana Pérez</span> | Hace 2 horas</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-lg font-bold text-gray-800 dark:text-neutral-50">$120.50</span>
                            <button class="rounded-md bg-red-600 px-3 py-1 text-xs font-bold text-white hover:bg-red-700">Rechazar</button>
                            <button class="rounded-md bg-green-600 px-3 py-1 text-xs font-bold text-white hover:bg-green-700">Aprobar</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        {{-- ================================================== --}}
        {{-- Fila 3: Resúmenes de Rendimiento y Actividad      --}}
        {{-- ================================================== --}}
        <div class="grid auto-rows-min gap-6 lg:grid-cols-12">

            {{-- Rendimiento de Agentes --}}
            <div class="rounded-xl border-2 border-neutral-200 p-6 dark:border-neutral-800 lg:col-span-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-neutral-50">Rendimiento de Agentes</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">Top 3 agentes por ingresos este mes.</p>
                <ul class="mt-4 space-y-3">
                    <li class="flex items-center gap-4">
                        <span class="text-lg font-bold text-gray-400 dark:text-neutral-500">1</span>
                        <img class="size-10 rounded-full" src="https://via.placeholder.com/40" alt="Foto de perfil">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800 dark:text-neutral-200">Ana Pérez</p>
                            <p class="text-sm text-gray-500 dark:text-neutral-400">Equipo Alfa</p>
                        </div>
                        <span class="font-bold text-green-600">$4,120</span>
                    </li>
                    {{-- más agentes --}}
                </ul>
            </div>

            {{-- Actividad de Clientes --}}
            <div class="rounded-xl border-2 border-neutral-200 p-6 dark:border-neutral-800 lg:col-span-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-neutral-50">Actividad de Clientes</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">Clientes registrados más recientes.</p>
                <ul class="mt-4 space-y-3">
                     <li class="flex items-center gap-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/50">
                            <span class="font-bold text-blue-700 dark:text-blue-300">TS</span>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800 dark:text-neutral-200">Tech Solutions Inc.</p>
                            <p class="text-sm text-gray-500 dark:text-neutral-400">Registrado hoy</p>
                        </div>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-400">Ver Perfil</a>
                    </li>
                     {{-- más clientes --}}
                </ul>
            </div>
        </div>
