@php
    $modalViewName = 'create-movement-modal';
@endphp

<x-dashboard.forms.modal
    title="{{ __('Crear movimiento') }}"
    description="{{ __('Proporciona los detalles del nuevo movimiento.') }}"
    modalName="{{ $modalViewName }}"
>
    <livewire:accounts.movements.create-movement-modal-form lazy />
</x-dashboard.forms.modal>
