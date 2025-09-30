{{-- @use('App\Helpers\AgentHelper') --}}
@props(['model', 'options'])
{{-- @php
    $options = AgentHelper::getAgentsAsArrayWithIdsAsKeys();
@endphp --}}

<flux:select wire:model="{{ $model }}" label="Selecciona un cliente" placeholder="Elige un cliente...">
    @foreach ($options as $id => $name)
        <flux:select.option value="{{ $id }}">
            {{ $name }}
        </flux:select.option>
    @endforeach
</flux:select>
