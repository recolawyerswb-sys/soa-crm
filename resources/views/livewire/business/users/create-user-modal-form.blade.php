<div>
    <form class='space-y-3' wire:submit.prevent="save">
        {{-- USER FIELDS --}}
        <flux:heading>{{ __('Datos de la cuenta') }}</flux:heading>
        <div class="grid grid-cols-1 gap-3">
            <flux:input label="Nombre completo*" wire:model="form.name"/>
            <flux:input label="Correo electrónico*" wire:model="form.email"/>
            @if (!$this->isEditEnabled)
                <flux:input type="password" viewable label="Contraseña*" wire:model="form.password"/>
            @endif
            <flux:select wire:model='form.role' placeholder="Admin, banki, ..." label="Seleccione un rol">
                @foreach ($roles as $role)
                    <flux:select.option value="{{ $role }}">
                        {{ $role }}
                    </flux:select.option>
                @endforeach
            </flux:select>
        </div>
        <x-dashboard.forms.footer-modal modalName="{{ $this->modalViewName }}" :isEditEnabled="$isEditEnabled" />
    </form>
</div>
