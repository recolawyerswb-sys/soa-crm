<div>
    <livewire:modals.generic.confirmation-modal />
    @role('admin')
        {{-- BUSINESS MODALS --}}
        {{-- <div wire:init="loadCreateClientModalForm">
            @if ($showCreateClientModalForm)
            @endif
        </div> --}}
        <livewire:modals.business.customer.create-client-modal />
        <livewire:modals.business.assignment.assign-customers-modal />
        <livewire:modals.business.agents.create-agent-modal />
        <livewire:modals.business.teams.create-team-modal />
        <livewire:modals.business.assignments.create-assignment-modal />
        <livewire:modals.business.access-control.create-role-modal />

        {{-- WALLET MODALS --}}

        {{-- CALL MODALS --}}
        @endrole
    @role('agent|leader_agent|admin')
        {{-- <livewire:modals.business.assignment.fast-assign /> --}}
        <livewire:modals.sells.calls.init-call-modal />
        <livewire:modals.business.customer.update-mark-info-modal />
        <livewire:modals.business.client-tracking.create-client-tracking-modal/>
        @endrole
    @role('admin|agent|lead_agent|customer')
        <livewire:modals.accounts.update-wallet-modal />
        <livewire:modals.accounts.movements.create-movement />
    @endrole
</div>
