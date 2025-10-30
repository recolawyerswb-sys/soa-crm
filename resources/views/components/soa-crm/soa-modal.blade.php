{{--
  Este modal se controla con una variable de Alpine llamada 'show'.
  Usaremos @entangle para sincronizar 'show' con una propiedad de Livewire.
--}}
@props(['livewireModel'])

<div
    x-data="{ show: @entangle($livewireModel) }"
    x-show="show"
    x-on:keydown.escape.window="show = false" {{-- Cierra con la tecla Esc --}}
    style="display: none;" {{-- Oculto por defecto --}}
    class="fixed inset-0 z-50 overflow-y-auto"
>
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 h-screen bg-gray-500 dark:bg-slate-800/75 transition-opacity"
        x-on:click="show = false" {{-- Cierra al hacer clic fuera --}}
    ></div>

    <div
        x-show="show"```````````````````````````````````````````````````````````````````````````````````````````````````````````````
        x-transition:enter="transform transition ease-in-out duration-500"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-500"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 flex max-w-full pl-10"
    >
        <div class="w-screen max-w-md">
            <div class="flex h-full flex-col overflow-y-scroll bg-white dark:bg-slate-700 p-6 shadow-xl">
                {{-- Aquí va el contenido que pasemos (título, formulario, etc.) --}}
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
