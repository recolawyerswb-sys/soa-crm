<div>
    {{-- Contenedor principal con fondo gris claro/oscuro --}}
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Cabecera del Perfil --}}
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $customer->profile->user->name }}
                    </h1>
                    <p class="text-md text-gray-500 dark:text-gray-400">
                        Perfil del Cliente
                    </p>
                </div>
                <div class="flex gap-2">
                    {{-- Aquí va el botón que luego agregarás --}}
                    <flux:modal.trigger name="create-client">
                        <flux:button
                            variant="primary"
                            icon:trailing="pencil-square"
                            class="cursor-pointer"
                            wire:confirm="Estas seguro?"
                            @click="$dispatch('enable-edit-for-create-client-modal', { customerId: '{{ $customer->id }}' })">
                            Editar usuario
                        </flux:button>
                    </flux:modal.trigger>
                    <flux:button
                        variant="primary"
                        color="zinc"
                        icon:trailing="arrow-path"
                        class="cursor-pointer"
                        wire:click="$refresh">
                        Recargar Informacion
                        <svg class="h-5 w-5 animate-spin" wire:loading fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </flux:button>
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
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->profile->full_name ?? 'No especificado' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->profile->user->email ?? 'No especificado' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Nacimiento</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->profile->birthdate ? \Carbon\Carbon::parse($customer->profile->birthdate)->format('d/m/Y') : 'No especificado' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Documento de Identidad</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->profile->dni_type ?? '' }} {{ $customer->profile->dni_number ?? 'No especificado' }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Tarjeta de Datos de Contacto --}}
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Datos de Contacto</h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Preferencia de Contacto</dt>
                                <dd class="mt-1 text-sm font-bold text-gray-900 dark:text-gray-100 uppercase">{{ $customer->profile->preferred_contact_method ?? 'No especificado' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono Principal</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->profile->phone_1 ?? 'No especificado' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono Secundario</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->profile->phone_2 ?? 'No especificado' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ubicación</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 capitalize">{{ $customer->profile->city ?? '' }}, {{ $customer->profile->country ?? 'No especificado' }}</dd>
                            </div>
                             <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dirección</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->profile->address ?? 'No especificado' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Columna Lateral (1/3 de ancho) --}}
                <div class="lg:col-span-1 space-y-8">

                    {{-- Tarjeta de Detalles del Cliente --}}
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Detalles del Cliente</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Agente Asignado</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->assignment->agent->profile->user->name ?? 'No asignado' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($customer->type) ?? 'No especificado' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Origen</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->origin ?? 'No especificado' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Último Contacto</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->last_contact_at ? \Carbon\Carbon::parse($customer->last_contact_at)->diffForHumans() : 'Nunca' }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Tarjeta de Wallet --}}
                    @if($customer->profile->user->wallet)
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Información Financiera (Wallet)</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Balance</dt>
                                <dd class="mt-1 text-lg font-bold text-green-600 dark:text-green-400">${{ number_format($customer->profile->user->wallet->balance, 2) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Red Bancaria</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->profile->user->wallet->bank_network ?? 'No especificado' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Número de Cuenta</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $customer->profile->user->wallet->account_number ?? 'No especificado' }}</dd>
                            </div>
                        </dl>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
