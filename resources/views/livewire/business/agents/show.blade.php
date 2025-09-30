<div>
    {{-- Contenedor principal con fondo gris claro/oscuro --}}
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Cabecera del Perfil --}}
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $agent->profile->user->name }}
                    </h1>
                    <p class="text-md text-gray-500 dark:text-gray-400">
                        Perfil del Agente
                    </p>
                </div>
                <div>
                    {{-- Aquí va el botón que luego agregarás --}}
                    <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        Editar Perfil
                    </button>
                </div>
            </div>

            {{-- Layout de dos columnas --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Columna Principal (2/3 de ancho) --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Tarjeta de Información Personal --}}
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Información Personal</h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->profile->full_name ?? 'No especificado' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->profile->user->email ?? 'No especificado' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Nacimiento</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->profile->birthdate ? \Carbon\Carbon::parse($agent->profile->birthdate)->format('d/m/Y') : 'No especificado' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Documento de Identidad</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->profile->dni_type ?? '' }} {{ $agent->profile->dni_number ?? 'No especificado' }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Tarjeta de Datos de Contacto --}}
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Datos de Contacto</h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono Principal</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->profile->phone_1 ?? 'No especificado' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono Secundario</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->profile->phone_2 ?? 'No especificado' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ubicación</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->profile->city ?? '' }}, {{ $agent->profile->country ?? 'No especificado' }}</dd>
                            </div>
                             <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dirección</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->profile->address ?? 'No especificado' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Columna Lateral (1/3 de ancho) --}}
                <div class="lg:col-span-1 space-y-8">

                    {{-- Tarjeta de Detalles del Agente --}}
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Detalles del Agente</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Posición</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->position ?? 'No especificado' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Equipo</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->team->name ?? 'Sin equipo' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Rol</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->is_leader ? 'Líder de equipo' : 'Agente' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                                <dd class="mt-1 text-sm font-semibold">
                                    @switch($agent->status)
                                        @case(1) <span class="text-green-600 dark:text-green-400">Activo</span> @break
                                        @case(0) <span class="text-red-600 dark:text-red-400">Inactivo</span> @break
                                        @case(2) <span class="text-yellow-600 dark:text-yellow-400">Suspendido</span> @break
                                        @default <span class="text-gray-500">Desconocido</span>
                                    @endswitch
                                </dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Tarjeta de Wallet --}}
                    @if($agent->profile->user->wallet)
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Información Financiera (Wallet)</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Balance</dt>
                                <dd class="mt-1 text-lg font-bold text-green-600 dark:text-green-400">${{ number_format($agent->profile->user->wallet->balance, 2) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Red Bancaria</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->profile->user->wallet->bank_network ?? 'No especificado' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Número de Cuenta</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $agent->profile->user->wallet->account_number ?? 'No especificado' }}</dd>
                            </div>
                        </dl>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
