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

    {{-- CUSTOMER FIELDS --}}
    <flux:heading>{{ __('Datos de marketing y seguimientos') }}</flux:heading>
    <div class="grid grid-cols-1 gap-3">
        {{-- <flux:input label="Fuente" wire:model="source"/> --}}
        <flux:select label="Fase" wire:model="form.phase" placeholder="Elije la fase...">
        @foreach ($this->phases as $phase)
            <flux:select.option value="{{ $phase }}">{{ $phase }}</flux:select.option>
        @endforeach
        </flux:select>
        <flux:select label="Origen" wire:model="form.origin" placeholder="Elije el origen...">
        @foreach ($this->origins as $origin)
            <flux:select.option value="{{ $origin }}">{{ $origin }}</flux:select.option>
        @endforeach
        </flux:select>
        <flux:select label="Estado" wire:model="form.status" placeholder="Elije el estado...">
        @foreach ($this->statuses as $status)
            <flux:select.option value="{{ $status }}">{{ $status }}</flux:select.option>
        @endforeach
        </flux:select>
        <flux:select label="Tipo de cliente" wire:model="form.type" placeholder="Lead, prospecto...">
        @foreach ($this->types as $type)
            <flux:select.option value="{{ $type }}">{{ $type }}</flux:select.option>
        @endforeach
        </flux:select>
    </div>
    <flux:separator />

    {{-- ASSIGNMENT FIELDS --}}
    <flux:heading>{{ __('Datos de asignacion') }}</flux:heading>
    <flux:callout icon="chat-bubble-bottom-center-text">
        <flux:callout.heading>Importante antes de asignar</flux:callout.heading>
        <flux:callout.text>
            Si desea que el sistema auto-asigne el asesor por defecto a este cliente, deje en blanco los campos de abajo.
            De lo contrario, puede asignar un asesor específico.
        </flux:callout.text>
    </flux:callout>
    <div class="grid grid-cols-1 gap-3">
        {{-- <flux:input label="Fuente" wire:model="source"/> --}}
        <x-dashboard.forms.select-agent model="form.agent_id" :options="$this->agents" />
    </div>
    <x-dashboard.forms.footer-modal modalName="{{ $this->modalViewName }}" :isEditEnabled="$isEditEnabled" />
</form>
