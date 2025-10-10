@php
    $modalViewName = 'massive-assignment';
@endphp

<x-dashboard.forms.modal
    title="{{ __('Asignacion masiva') }}"
    description="{{ __('Elije un asesor.') }}"
    modalName="{{ $modalViewName }}"
>
    <livewire:business.assignments.masive-assign-form-view lazy />
</x-dashboard.forms.modal>
