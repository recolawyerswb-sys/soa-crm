@php
    $modalViewName = 'create-access-control-role';
@endphp

<x-dashboard.forms.modal
    title="{{ __('Crear Rol') }}"
    description="{{ __('Proporciona los detalles del nuevo rol.') }}"
    modalName="{{ $modalViewName }}"
>
    <livewire:business.access-control.create-role-modal-form lazy />
</x-dashboard.forms.modal>
