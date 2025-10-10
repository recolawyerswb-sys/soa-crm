@php
    $modalViewName = 'create-client';
@endphp

<div wire:ignore.self>
    <x-dashboard.forms.modal
        title="{{ __('Crear cliente') }}"
        description="{{ __('Proporciona los detalles del nuevo cliente.') }}"
        modalName="{{ $modalViewName }}"
    >
        <livewire:business.customers.create-client-modal-form lazy />
    </x-dashboard.forms.modal>
</div>
