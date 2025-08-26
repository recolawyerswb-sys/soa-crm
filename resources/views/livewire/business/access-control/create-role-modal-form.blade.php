<form class='space-y-3' wire:submit.prevent="save">
    {{-- PROFILE FIELDS --}}
    <flux:heading>{{ __('Datos de perfil') }}</flux:heading>
    <div class="grid grid-cols-1 gap-3">
        <flux:input label="Nombre del rol" wire:model="form.name"/>
    </div>
    <x-dashboard.forms.footer-modal modalName="{{ $this->modalViewName }}" :isEditEnabled="$isEditEnabled" />
</form>
