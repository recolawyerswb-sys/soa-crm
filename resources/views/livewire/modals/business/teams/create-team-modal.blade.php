@php
    $modalViewName = 'create-team';
@endphp

<x-dashboard.forms.modal
    title="{{ __('Crear Equipo') }}"
    description="{{ __('Proporciona los detalles del nuevo equipo.') }}"
    modalName="{{ $modalViewName }}"
>
    <livewire:business.teams.create-team-modal-form lazy />
</x-dashboard.forms.modal>
