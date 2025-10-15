@php
    $modalViewName = 'create-client-tracking';
@endphp

<x-dashboard.forms.modal
    title="{{ __('Crear seguimiento') }}"
    description="{{ __('Proporciona los detalles del nuevo seguimiento.') }}"
    modalName="{{ $modalViewName }}"
>
    <livewire:business.client-tracking.create-client-tracking-modal-form />
</x-dashboard.forms.modal>
