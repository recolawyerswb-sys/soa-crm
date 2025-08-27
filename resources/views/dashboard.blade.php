<x-layouts.app :title="__('Panel de control')">
    <div class="flex h-full w-full flex-1 flex-col">
        @if (Auth::user()->isAdmin())
            <livewire:dashboards.admin-dashboard />
        @elseif (Auth::user()->isAgente())
            <livewire:dashboards.agent-dashboard />
        @elseif (Auth::user()->isCliente())
            <livewire:dashboards.client-dashboard />
        @endif
    </div>
</x-layouts.app>
