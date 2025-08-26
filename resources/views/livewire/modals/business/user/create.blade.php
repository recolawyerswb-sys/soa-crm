<x-dashboard.forms.modal
    title="{{ __('Crear un nuevo usuario') }}"
    description="{{ __('Proporciona los detalles del nuevo usuario.') }}"
    modalName="create-user"
    formActionName="save"
>
    {{-- FORM FIELDS --}}
    <x-dashboard.forms.input-text
        label="{{ __('Name') }}"
        name="name"
        placeholder="{{ __('Jhon Doe') }}" />

    <x-dashboard.forms.input-text
        label="{{ __('Email') }}"
        name="email"
        placeholder="{{ __('jhondoe@email.com') }}" />

    <x-dashboard.forms.input-text
        label="{{ __('Password') }}"
        name="password"
        placeholder="{{ __('1234') }}" />
</x-dashboard.forms.modal>
