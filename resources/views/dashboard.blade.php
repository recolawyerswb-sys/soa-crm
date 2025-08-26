<x-layouts.app :title="__('Panel de control')">
    <div class="flex h-full w-full flex-1 flex-col gap-5">
        @includeWhen(Auth::user()->isAdmin(), 'dashboard.ideas.dsb-admin-1')
        @includeWhen(Auth::user()->isCliente(), 'dashboard.dsb-customer')
        {{-- @includeWhen(Auth::user()->isAgente(), 'dashboard.dsb-agent') --}}
    </div>
</x-layouts.app>
