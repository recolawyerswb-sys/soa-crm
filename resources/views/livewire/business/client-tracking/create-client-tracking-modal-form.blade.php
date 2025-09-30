<form class='space-y-3' wire:submit.prevent="save">
    {{-- USER FIELDS --}}
    {{-- <flux:heading>{{ __('Datos de inicio de sesion') }}</flux:heading>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <flux:input label="Usuario" wire:model="name"/>
        <flux:input label="Correo electrónico" wire:model="email"/>
        <flux:input label="Contraseña" wire:model="password"/>
    </div>
    <flux:separator /> --}}

    {{-- PROFILE FIELDS --}}
    <flux:heading>{{ __('Datos Generales') }}</flux:heading>
    <div class="grid grid-cols-1 gap-3">
        {{-- <livewire:soa-select.smart-select
            :initial-data="$customers"
            search-column="display_name"
            display-column="display_name"
            input-name="customer_id"
            :is-searchable="true"
            lazy
        /> --}}
        <x-dashboard.forms.select-customer model="form.customer_id" :options="$this->customers" />
        @role('admin')
        <x-dashboard.forms.select-agent model="form.agent_id" :options="$this->agents" />
        @endrole
    </div>
    <flux:separator />

    {{-- ASSIGNMENT FIELDS --}}
    <flux:heading>{{ __('Observaciones') }}</flux:heading>
    <div class="grid grid-cols-1 gap-3">
        <flux:textarea label="Notas del seguimiento*" wire:model="form.notes"/>
        {{-- <flux:input label="Fuente" wire:model="source"/> --}}
    </div>
    <x-dashboard.forms.footer-modal modalName="{{ $this->modalViewName }}" :isEditEnabled="$isEditEnabled" />
</form>
