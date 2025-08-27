@props(['title' => 'No olvides el titulo'])

<div class="relative rounded p-5 dark:bg-zinc-900">
    <h3 class="text-gray-600 dark:text-neutral-200">
        {{ $title }}
    </h3>
    <p class="mt-1 text-3xl font-bol">
        <span class="font-bold dark:text-white text-indigo-500">
            {{ $slot }}
        </span>
    </p>
</div>
