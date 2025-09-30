<div role="status" class="w-full h-screen p-4 space-y-4 border border-gray-200 divide-y divide-gray-200 rounded-sm shadow-sm animate-pulse dark:divide-gray-700 md:p-6 dark:border-gray-700">

    <div class="flex items-center justify-between py-5">
        {{-- Título y subtítulo de la página --}}
        <div>
            <div class="h-3 bg-gray-300 rounded-full dark:bg-gray-600 w-28 mb-2.5"></div>
            <div class="w-36 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
        </div>
        {{-- Botones de ayuda y acciones --}}
        <div class="flex items-center space-x-2">
            <div class="h-8 w-8 bg-gray-300 rounded-full dark:bg-gray-700"></div>
            <div class="h-8 w-24 bg-gray-300 rounded-lg dark:bg-gray-700"></div>
        </div>
    </div>

    <div class="pt-8 space-y-8">

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <x-skeletons.stat-placeholder />
            <x-skeletons.stat-placeholder />
            <x-skeletons.stat-placeholder />
            <x-skeletons.stat-placeholder />
        </div>

        <div class="pt-4">
            {{-- Encabezado de la tabla --}}
            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-t-lg">
                <div class="h-3 bg-gray-300 rounded-full dark:bg-gray-600 w-32"></div>
                <div class="h-3 bg-gray-300 rounded-full dark:bg-gray-600 w-24"></div>
                <div class="h-3 bg-gray-300 rounded-full dark:bg-gray-600 w-24"></div>
                <div class="h-3 bg-gray-300 rounded-full dark:bg-gray-600 w-20"></div>
            </div>
            {{-- Filas de la tabla --}}
            <div class="space-y-2 py-4">
                {{-- Fila 1 --}}
                <div class="flex items-center justify-between p-4">
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-32"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-24"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-24"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-20"></div>
                </div>
                {{-- Fila 2 --}}
                <div class="flex items-center justify-between p-4">
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-48"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-20"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-28"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-16"></div>
                </div>
                {{-- Fila 3 --}}
                <div class="flex items-center justify-between p-4">
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-40"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-24"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-20"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-24"></div>
                </div>
                 {{-- Fila 4 --}}
                <div class="flex items-center justify-between p-4">
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-32"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-24"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-24"></div>
                    <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-20"></div>
                </div>
            </div>
        </div>
    </div>

    <span class="sr-only">Cargando...</span>
</div>
