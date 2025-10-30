@use('App\Helpers\RoleHelper')

@props([
    'label' => 'Seleccione un rol',
    'placeholder' => 'Admin, banki...',
    'options' => RoleHelper::getRolesAsArray(),
    'disabled',
])

<flux:select placeholder="{{ $placeholder }}" label="{{ $label }}">
    @foreach ($options as $option)
        <flux:select.option value="{{ $option }}">
            {{ $option }}
        </flux:select.option>
    @endforeach
</flux:select>
