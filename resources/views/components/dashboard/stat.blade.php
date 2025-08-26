@props(['title' => 'No olvides el titulo'])

<div class="relative rounded p-5 dark:bg-zinc-900">
    <h3 class="font-semibold text-gray-600 dark:text-neutral-400">
        {{ $title }}
    </h3>
    <p class="mt-1 text-4xl font-bold text-gray-900 dark:text-neutral-50">
        {{-- Data: count(agentes where status='activo') --}}
        {{ $slot }}
    </p>
</div>
