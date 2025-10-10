@php
    $modalViewName = 'update-mark-info-modal';
@endphp

<x-dashboard.forms.modal
    title="{{ __('Cambio de fase masivo') }}"
    description="{{ __('Elije una fase.') }}"
    modalName="{{ $modalViewName }}"
>
    <livewire:business.customers.update-mark-info-modal-form lazy />
</x-dashboard.forms.modal>
