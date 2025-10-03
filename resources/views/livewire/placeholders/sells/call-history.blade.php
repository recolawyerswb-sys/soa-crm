<div class="space-y-4 max-w-3xl mx-auto p-4 animate-pulse">

    {{-- Skeleton del Título --}}
    <div class="h-8 bg-gray-200 dark:bg-gray-700 rounded-md w-1/3"></div>

    {{-- Usamos un bucle para mostrar varias tarjetas de skeleton --}}
    @for ($i = 0; $i < 3; $i++)
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                {{-- Skeleton de la información de la llamada --}}
                <div class="flex items-center space-x-2 w-1/2">
                    <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-full w-1/3"></div>
                    <div class="h-4 w-4 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                    <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-full w-1/3"></div>
                </div>

                {{-- Skeleton de la insignia de estado --}}
                <div class="h-5 bg-gray-200 dark:bg-gray-700 rounded-full w-20"></div>
            </div>

            <div class="mt-4 flex items-end justify-between">
                {{-- Skeleton de la fecha y hora --}}
                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-full w-1/4"></div>

                {{-- Skeleton de la duración --}}
                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-full w-1/5"></div>
            </div>
        </div>
    @endfor

</div>
