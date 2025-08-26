<form class='space-y-3' wire:submit.prevent="save">
    {{-- PROFILE FIELDS --}}
    <flux:heading>{{ __('Datos de perfil') }}</flux:heading>
    <div class="grid grid-cols-1 gap-3">
        <flux:input label="Nombre" wire:model="form.name"/>
        <flux:textarea label="Descripcion" wire:model="form.description"/>
        <flux:input label="Eslogan o frase motivadora" placeholder='...' wire:model="form.slogan"/>
        <flux:input label="Color del equipo" type="color" wire:model="form.color_code"/>
    </div>
    <x-dashboard.forms.footer-modal modalName="{{ $this->modalViewName }}" :isEditEnabled="$isEditEnabled" />
</form>

