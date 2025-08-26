<form class='space-y-3' wire:submit.prevent="save">
    {{-- PROFILE FIELDS --}}
    <flux:heading>{{ __('Datos de perfil') }}</flux:heading>
    <div class="grid grid-cols-1 gap-3">
        <x-dashboard.forms.select-customer model="form.customer_id" :options="$this->customers" />
        <x-dashboard.forms.select-agent model="form.agent_id" :options="$this->agents" />
        <flux:radio.group wire:model="form.status" label="Estado de la asignacion">
            <flux:radio value="1" label="Activo" checked />
            <flux:radio value="0" label="Inactivo" />
        </flux:radio.group>
        <flux:textarea label="Notas" wire:model="form.notes"/>
    </div>
    <x-dashboard.forms.footer-modal modalName="{{ $this->modalViewName }}" :isEditEnabled="$isEditEnabled" />
</form>
