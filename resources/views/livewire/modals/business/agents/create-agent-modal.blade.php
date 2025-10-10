@php
    $modalViewName = 'create-agent';
@endphp

<x-dashboard.forms.modal
    title="{{ __('Crear Agente') }}"
    description="{{ __('Proporciona los detalles del nuevo agente.') }}"
    modalName="{{ $modalViewName }}"
>
    <livewire:business.agents.create-agent-modal-form lazy />
</x-dashboard.forms.modal>
