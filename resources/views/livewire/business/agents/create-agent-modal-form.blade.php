<form class='space-y-3' wire:submit.prevent="save">
    {{-- PROFILE FIELDS --}}
    <flux:heading>{{ __('Datos de perfil') }}</flux:heading>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <flux:input label="Nombre completo" wire:model="form.full_name"/>
        <flux:input label="Correo electrónico" wire:model="form.email"/>
        <flux:input label="Teléfono 1" wire:model="form.phone_1"/>
        <flux:input label="Teléfono 2" wire:model="form.phone_2"/>
        <flux:select label="Preferencia de contacto" wire:model="form.preferred_contact_method" placeholder="Elije la preferencia de contacto...">
        @foreach ($this->preferredContactMethods as $preferredContactMethod)
            <flux:select.option value="{{ $preferredContactMethod }}">{{ $preferredContactMethod }}</flux:select.option>
        @endforeach
        </flux:select>
        <flux:input label="País" wire:model="form.country"/>
        <flux:input label="Ciudad" wire:model="form.city"/>
        <flux:input label="Dirección" wire:model="form.address"/>
        <flux:select label="Tipo de documento" wire:model="form.dni_type" placeholder="Elije el tipo de documento...">
        @foreach ($this->dniTypes as $dniType)
            <flux:select.option value="{{ $dniType }}">{{ $dniType }}</flux:select.option>
        @endforeach
        </flux:select>
        <flux:input label="Número de DNI" wire:model="form.dni_number"/>
        <flux:input type="date" label="Fecha de nacimiento" wire:model="form.birthdate"/>
    </div>
    <flux:separator />

    {{-- AGENT FIELDS --}}
    <flux:heading>{{ __('Datos laborales') }}</flux:heading>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <flux:select label="Posicion del agente" wire:model="form.position" placeholder="Elije la posicion inicial...">
        @foreach ($this->positions as $position)
            <flux:select.option value="{{ $position }}">{{ $position }}</flux:select.option>
        @endforeach
        </flux:select>
        <x-dashboard.forms.select-agent-team model="form.team_id" :options="$this->teams" />
        <flux:select label="Día de la semana" wire:model="form.day_off" placeholder="Elije el día de la semana...">
            <flux:select.option value="1">{{ __('Lunes') }}</flux:select.option>
            <flux:select.option value="2">{{ __('Martes') }}</flux:select.option>
            <flux:select.option value="3">{{ __('Miércoles') }}</flux:select.option>
            <flux:select.option value="4">{{ __('Jueves') }}</flux:select.option>
            <flux:select.option value="5">{{ __('Viernes') }}</flux:select.option>
            <flux:select.option value="6">{{ __('Sábado') }}</flux:select.option>
            <flux:select.option value="7">{{ __('Domingo') }}</flux:select.option>
        </flux:select>
        <flux:input type='time' label="Hora de entrada" wire:model="form.checkin_hour"/>
        <flux:radio.group wire:model="form.status" label="Estado inicial">
            <flux:radio value="1" label="Activo" checked />
            <flux:radio value="0" label="Inactivo" />
            <flux:radio value="2" label="Suspendido" />
        </flux:radio.group>
        <flux:radio.group wire:model="form.is_leader" label="Este agente sera lider?">
            <flux:radio value="true" label="Si" />
            <flux:radio value="false" label="No" checked />
        </flux:radio.group>
    </div>
    {{-- <flux:separator /> --}}

    {{-- ASSIGNMENT FIELDS --}}
    {{-- <flux:heading>{{ __('Datos de asignacion') }}</flux:heading>
    <flux:callout icon="chat-bubble-bottom-center-text">
        <flux:callout.heading>Importante antes de asignar</flux:callout.heading>
        <flux:callout.text>
            Si desea que el sistema auto-asigne el asesor por defecto a este cliente, deje en blanco los campos de abajo.
            De lo contrario, puede asignar un asesor específico.
        </flux:callout.text>
    </flux:callout> --}}
    <div class="grid grid-cols-1 gap-3">
        {{-- <flux:input label="Fuente" wire:model="source"/> --}}
    </div>
    <x-dashboard.forms.footer-modal modalName="{{ $this->modalViewName }}" :isEditEnabled="$isEditEnabled" />
</form>
