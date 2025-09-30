<form class='space-y-3' wire:submit.prevent="save">
    {{-- PROFILE FIELDS --}}
    <flux:heading>{{ __('Datos del usuario') }}</flux:heading>

    <div wire:loading wire:target="form.customer_id">
        <flux:text>Cargando datos del cliente...</flux:text>
    </div>

    <div wire:loading.remove wire:target="form.customer_id">
        <flux:text>Creando el movimiento como: <b class="uppercase">{{ $displayUserName }}</b></flux:text>
        <flux:text>Balance total: <b> {{ '$' . number_format($displayUserBalance, 2) }} </b></flux:text>
    </div>

    @if(Auth::user()->isAdmin() || Auth::user()->isBanki())
        <flux:callout icon="chat-bubble-bottom-center-text">
            <flux:callout.heading>Importante antes de crear movimiento</flux:callout.heading>
            <flux:callout.text>
                El sistema creara el movimiento asociado a su cuenta si no se selecciona el cliente a continuacion.
                Este mensaje solo sera visible para los administradores.
            </flux:callout.text>
        </flux:callout>
    @endif
    <flux:separator />

    <flux:heading>{{ __('Datos del movimiento') }}</flux:heading>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <flux:select label="Tipo" wire:model.live="form.type" placeholder="Elije el tipo de movimiento...">
        @foreach ($this->types as $type => $label)
            <flux:select.option value="{{ $type }}">{{ $label }}</flux:select.option>
        @endforeach
        </flux:select>
        <flux:input
            type='number'
            step="0.01"
            label="Cantidad"
            icon="currency-dollar"
            clearable
            wire:model.blur="form.amount"
            {{-- Atributos condicionales corregidos --}}
            :invalid="$invalidAmount"
            :badge="$invalidAmount ? 'Saldo insuficiente' : null"
            />
    </div>
    <div class="grid grid-cols-1 gap-3">
        @if(Auth::user()->isAdmin() || Auth::user()->isBanki())
            {{-- CUSTOMER ONLY FOR ADMIN --}}
            <flux:select wire:model.live="form.customer_id" label="Selecciona un cliente" placeholder="Elige un cliente...">
                @foreach ($this->customers as $id => $name)
                    <flux:select.option value="{{ $id }}">
                        {{ $name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:textarea label="Notas generales" wire:model="form.note"/>
        @endif
    </div>

    <div class="flex">
        <button type="button" x-on:click="{{'$flux.modal('.'"'. $this->modalViewName .'"'.').close()'}}">
            Cancelar
        </button>
        <flux:spacer />
        <flux:button
            type="submit"
            :variant="$invalidAmount ? 'subtle' : 'primary'"
            :disabled="$invalidAmount ? true : false"
        >
            {{ !$isEditEnabled ? 'Guardar' : 'Actualizar' }}
        </flux:button>
    </div>
</form>
