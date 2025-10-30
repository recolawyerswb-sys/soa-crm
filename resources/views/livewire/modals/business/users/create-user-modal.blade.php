@php
    $modalViewName = 'create-user-modal';
@endphp

<div wire:ignore.self>
    <x-dashboard.forms.modal
        title="{{ __('Crear usuario') }}"
        description="{{ __('Proporciona los detalles del nuevo usuario.') }}"
        modalName="{{ $modalViewName }}"
    >
        <livewire:business.users.create-user-modal-form />
    </x-dashboard.forms.modal>
</div>
