{{-- Contenedor principal con soporte para modo oscuro --}}
<div class="bg-zinc-50 dark:bg-zinc-950 min-h-screen text-gray-800 dark:text-gray-200">
    <flux:header class="py-4 bg-zinc-50/80 dark:bg-zinc-950/80 backdrop-blur-sm sticky top-0 z-10">
        {{-- Nombre o Logo del CRM --}}
        <a href="{{ route('welcome') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        {{-- Barra de navegación con acciones --}}
        <flux:navbar class="gap-2 ms-auto">
            {{-- Selector de Tema (Claro/Oscuro) --}}
            <x-table.theme-picker />

            {{-- Botones de Acción: Iniciar Sesión y Registrarse --}}
            <div class="hidden sm:flex items-center gap-2 ms-auto">
                <flux:button variant="ghost" wire:navigate href="{{ route('login') }}">
                    Iniciar Sesión
                </flux:button>
                <flux:button variant="primary" href="{{ route('register') }}">
                    Registrarse
                </flux:button>
            </div>
        </flux:navbar>
    </flux:header>

    <main>
        <div class="relative px-6 lg:px-8">
            <div class="mx-auto max-w-5xl py-20 sm:py-32 lg:py-36">
                <div class="grid lg:grid-cols-2 gap-12 items-center">

                    {{-- Columna de Texto --}}
                    <div class="text-center lg:text-left">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                            Gestiona tus clientes de forma eficiente
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-zinc-300">
                            Nuestra plataforma te ofrece todas las herramientas que necesitas para llevar el control de tus interacciones, ventas y seguimientos en un solo lugar.
                        </p>
                        <div class="mt-10 flex items-center justify-center lg:justify-start gap-x-6">
                            <flux:button variant="primary" href="{{ route('register') }}">
                                Comenzar Ahora
                            </flux:button>
                            <flux:button variant="subtle" href="{{ route('login') }}">
                                Ya tengo una cuenta <span aria-hidden="true">→</span>
                            </flux:button>
                        </div>
                    </div>

                    {{-- Columna de Imagen --}}
                    <div class="hidden lg:block">

                    </div>

                </div>
            </div>
        </div>
    </main>
</div>
