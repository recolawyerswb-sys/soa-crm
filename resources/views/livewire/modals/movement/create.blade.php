<x-dashboard.forms.modal
    title="{{ __('Crear un nuevo movimiento') }}"
    description="{{ __('Elije que operacion deseas realizar.') }}"
    modalName="create-movement"
    formActionName="save"
>
    {{-- FORM FIELDS --}}
    <x-dashboard.forms.input-text
        label="{{ __('Monto') }}"
        name="ammount"
        placeholder="{{ __('10000') }}" />

    <x-dashboard.forms.select
        name="type"
        :options="['deposit', 'withdrawal']"
        placeholder="{{ __('Deposit') }}" />

    <x-dashboard.forms.input-text
        label="{{ __('Wallet') }}"
        name="wallet"
        placeholder="{{ __('1726hsygs62sas') }}" />
</x-dashboard.forms.modal>

