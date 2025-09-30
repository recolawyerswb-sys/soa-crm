{{--
  Este es el skeleton loader para la página de bienvenida.
  Usa la clase `animate-pulse` para crear el efecto de carga.
--}}
<div role="status" class="bg-zinc-50 dark:bg-zinc-950 min-h-screen animate-pulse">

    <header class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-zinc-800">
        {{-- Skeleton del Logo --}}
        <div class="h-6 w-24 bg-gray-300 dark:bg-zinc-700 rounded-md"></div>

        {{-- Skeleton de los Botones --}}
        <div class="flex items-center gap-2">
            <div class="h-8 w-20 bg-gray-300 dark:bg-zinc-700 rounded-md"></div>
            <div class="h-8 w-28 bg-gray-300 dark:bg-zinc-700 rounded-md"></div>
            <div class="h-8 w-32 bg-gray-300 dark:bg-zinc-700 rounded-md"></div>
        </div>
    </header>

    <main>
        <div class="mx-auto max-w-5xl py-20 sm:py-32 lg:py-36">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                {{-- Skeleton de la Columna de Texto --}}
                <div class="flex flex-col">
                    {{-- Título --}}
                    <div class="h-10 bg-gray-300 dark:bg-zinc-700 rounded-full w-3/4 mb-4"></div>
                    <div class="h-10 bg-gray-300 dark:bg-zinc-700 rounded-full w-1/2 mb-8"></div>

                    {{-- Párrafo --}}
                    <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded-full w-full mb-2.5"></div>
                    <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded-full w-full mb-2.5"></div>
                    <div class="h-4 bg-gray-200 dark:bg-zinc-800 rounded-full w-5/6 mb-10"></div>

                    {{-- Botones CTA --}}
                    <div class="flex items-center gap-x-6">
                        <div class="h-12 w-48 bg-gray-300 dark:bg-zinc-700 rounded-lg"></div>
                        <div class="h-12 w-56 bg-gray-200 dark:bg-zinc-800 rounded-lg"></div>
                    </div>
                </div>

                {{-- Skeleton de la Columna de Imagen --}}
                <div class="hidden lg:block w-full h-80 bg-gray-300 dark:bg-zinc-700 rounded-xl"></div>
            </div>
        </div>
    </main>
</div>
