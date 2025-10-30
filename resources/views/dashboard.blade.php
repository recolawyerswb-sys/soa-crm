<x-layouts.app :title="__('Panel de control')">
    <div class="flex h-full w-full flex-1 flex-col">
        @role('developer|admin')
            <livewire:dashboards.admin-dashboard lazy />
        @endrole
        @role('agent|lead_agent')
            <livewire:dashboards.agent-dashboard lazy />
        @endrole
        @role('customer')
            <livewire:dashboards.client-dashboard lazy />
        @endrole
    </div>
</x-layouts.app>
