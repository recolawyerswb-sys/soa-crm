<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <flux:heading>{{ __('Tus datos personales') }}</flux:heading>

    <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <flux:input wire:model="name" :label="__('Nombre')" type="text" required autofocus autocomplete="name" />
            <flux:input wire:model="email" :label="__('Correo electrónico')" type="email" autocomplete="email" />
            <flux:input wire:model="phone" :label="__('Teléfono')" type="text" autocomplete="tel" />
            <flux:input wire:model="country" :label="__('País')" type="text" autocomplete="country" />
            <flux:input wire:model="city" :label="__('Ciudad')" type="text" autocomplete="address-level2" />
            <flux:input wire:model="address" :label="__('Dirección')" type="text" autocomplete="street-address" />
            <flux:input wire:model="phase" :label="__('Fase')" type="text" />
            <flux:input wire:model="origin" :label="__('Origen')" type="text" />
            <flux:input wire:model="status" :label="__('Estado')" type="text" />
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full">{{ __('Guardar') }}</flux:button>
            </div>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Guardado!') }}
            </x-action-message>
        </div>
    </form>
</div>
