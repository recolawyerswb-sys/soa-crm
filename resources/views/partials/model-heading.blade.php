@props(['title', 'subtitle', 'actions' => true])

<div class="relative mb-6 w-full pt-5 flex justify-between items-start">
    {{-- TITULO --}}
    <div class="flex flex-col">
        <flux:heading size="xl" level="1">{{ $title }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ $subtitle }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- ACCIONES - BOTONES --}}
    @if ($actions)
        <div class="flex gap-5">
            <flux:button variant="primary">Abrir billetera</flux:button>
            <flux:button variant="primary">Asesor asignado</flux:button>
            <flux:button variant="primary">Ultimos movimientos</flux:button>
        </div>
    @endif
</div>
