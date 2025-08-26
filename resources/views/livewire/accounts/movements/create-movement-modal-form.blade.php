<form class='space-y-3' wire:submit.prevent="save">
    {{-- PROFILE FIELDS --}}
    <flux:heading>{{ __('Datos del usuario') }}</flux:heading>
    <flux:text>Creando el movimiento como: <b>{{ $authUser }}</b></flux:text>
    <flux:text>Balance total: <b>{{ $authUserBalance }}</b></flux:text>
    <flux:separator />

    <flux:heading>{{ __('Datos del movimiento') }}</flux:heading>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <flux:select label="Tipo" wire:model="form.type" placeholder="Elije el tipo de movimiento...">
        @foreach ($this->types as $type => $label)
            <flux:select.option value="{{ $type }}">{{ $label }}</flux:select.option>
        @endforeach
        </flux:select>
        <flux:input type='number' step="0.01" label="Cantidad"  icon="currency-dollar" clearable wire:model="form.amount"/>
    </div>
    <div class="grid grid-cols-1 gap-3">
        <flux:textarea label="Notas generales" wire:model="form.note"/>
    </div>

    {{-- ASSIGNMENT FIELDS --}}
    {{-- <flux:heading>{{ __('Datos de asignacion') }}</flux:heading>
    <flux:callout icon="chat-bubble-bottom-center-text">
        <flux:callout.heading>Importante antes de asignar</flux:callout.heading>
        <flux:callout.text>
            Si desea que el sistema auto-asigne el asesor por defecto a este cliente, deje en blanco los campos de abajo.
            De lo contrario, puede asignar un asesor específico.
        </flux:callout.text>
    </flux:callout> --}}

    <x-dashboard.forms.footer-modal modalName="{{ $this->modalViewName }}" />
</form>
