@php
    $modalViewName = 'fast-assign';
@endphp

<x-dashboard.forms.modal
    title="{{ __('Asignacion rapida') }}"
    description="{{ __('Asigna de forma rapida a un usuario') }}"
    modalName="{{ $modalViewName }}"
>
    <form class='space-y-3' wire:submit.prevent="updateAssignment">
        {{-- ONLY CUSTOM FORM FIELDS GO HERE --}}
        <x-dashboard.forms.input-text
            label="{{ __('Agente') }}"
            name="agent"
            placeholder="{{ __('Patrick Agent') }}" />

        <x-dashboard.forms.input-text
            label="{{ __('Cliente') }}"
            name="customer"
            placeholder="{{ __('Jhon Doe') }}" />

        <x-dashboard.forms.footer-modal modalName="{{ $modalViewName }}" />
    </form>
</x-dashboard.forms.modal>
