@php
    $modalViewName = 'create-assignment';
@endphp

<x-dashboard.forms.modal
    title="{{ __('Crear Asignacion') }}"
    description="{{ __('Proporciona los detalles de la nueva asignacion.') }}"
    modalName="{{ $modalViewName }}"
>
    <livewire:business.assignments.create-assignment-modal-form />
</x-dashboard.forms.modal>
