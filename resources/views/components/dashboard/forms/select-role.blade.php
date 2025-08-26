@use('App\Helpers\RoleHelper')

@props([
    'label' => 'Select an option',
    'name' => null,
    'placeholder' => 'Choose an option...',
    'options' => RoleHelper::getRolesAsArray(),
    'disabled',
])

<ui-field class="flex flex-col gap-2">
    <ui-label class="inline-flex items-center text-sm font-medium text-zinc-800 dark:text-white">
        {{ $label }}
    </ui-label>
    <flux:select wire:model="{{ $name }}" placeholder="{{ $placeholder }}">
        @foreach ($options as $option)
            <flux:select.option value="{{ $option }}">
                {{ $option }}
            </flux:select.option>
        @endforeach
    </flux:select>
</ui-field>
