@props(['title', 'subtitle', 'actions' => true])

<div class="relative mb-6 w-full px-3 py-3 flex justify-between items-start">
    {{-- TITULO --}}
    <div class="flex flex-col">
        <flux:heading size="xl" level="1">{{ $title }}</flux:heading>
        <flux:subheading size="lg">{{ $subtitle }}</flux:subheading>
    </div>
</div>
