<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="bg-zinc-100 dark:bg-[#0D0D0D] p-0! overflow-hidden">
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
