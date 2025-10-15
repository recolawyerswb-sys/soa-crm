@php
    $modalViewName = 'update-wallet-modal';
@endphp

<x-dashboard.forms.modal
    title="{{ __('Actualizar Billetera') }}"
    description="{{ __('Modifica con precaucion los detalles de esta billetera.') }}"
    modalName="{{ $modalViewName }}"
>
    <livewire:accounts.update-wallet-modal-form />
</x-dashboard.forms.modal>
