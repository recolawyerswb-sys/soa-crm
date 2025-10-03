<div class="space-y-4 max-w-3xl mx-auto p-4 animate-pulse">
    <div class="h-8 bg-gray-200 dark:bg-gray-700 rounded-md w-1/3"></div>

    @for ($i = 0; $i < 4; $i++)
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="w-1/2 space-y-2">
                    <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-full w-full"></div>
                    {{-- ✅ Skeleton para el nombre del llamante --}}
                    <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded-full w-1/3"></div>
                </div>
                <div class="h-5 bg-gray-200 dark:bg-gray-700 rounded-full w-20"></div>
            </div>
            <div class="mt-4 flex items-end justify-between">
                <div class="w-1/2 space-y-2">
                    <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-full w-2/3"></div>
                    {{-- ✅ Skeleton para quién contestó --}}
                    <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded-full w-1/2"></div>
                </div>
                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-full w-1/5"></div>
            </div>
        </div>
    @endfor
</div>
