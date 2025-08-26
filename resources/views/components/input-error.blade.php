@props(['messages'])

@if ($messages)
    {{-- El componente recibe una lista de mensajes y los muestra uno por uno --}}
    <div {{ $attributes->merge(['class' => 'text-sm text-red-600 dark:text-red-400 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <p>{{ $message }}</p>
        @endforeach
    </div>
@endif
