<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="bg-zinc-100 dark:bg-zinc-950 p-0! overflow-hidden">
        <div wire:loading.flex
        class="absolute inset-0 z-50 flex items-center justify-center bg-white/80 dark:bg-zinc-800/80">
            {{-- Aquí va la animación del loader --}}
            <div class="loader"></div>
        </div>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
