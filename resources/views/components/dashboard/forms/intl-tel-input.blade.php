@props(["id", "model", "label" => 'Selector de telefono'])

<div wire:ignore
    {{-- x-init="
        setTimeout(() => {
            input = document.getElementById('{{ $id }}');
            iti = window.intlTelInput(input, {
                loadUtils: () => import('https://cdn.jsdelivr.net/npm/intl-tel-input@25.11.2/build/js/utils.js'),
            });
            $number = iti.getNumber();
            iti.setNumber(value)
            input.addEventListener('input', () => {
                if (iti.isValidNumber()) {
                    $wire.set('{{ $model }}', $number);
                    $wire.{{ $model }} = ;
                }
                console.log($number);
            });
        }, 500);
    " --}}
>
    <flux:field>
        <flux:label>{{ $label }}</flux:label>
        <flux:input
            id="{{ $id }}"
            wire:model='{{ $model }}'
            type="tel"
            {{-- x-data=" { value: $wire.entangle('{{ $model }}') }" --}}
        />
    </flux:field>
</div>

<script>
    window.intlTelInput = intlTelInput;
    const input = document.querySelector("#{{ $id }}");
    const iti = window.intlTelInput(input, {
        loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.11.2/build/js/utils.js"),
    });
    const number = iti.getNumber();
    input.addEventListener('input', () => {
        if (iti.isValidNumber()) {
            $wire.set('{{ $model }}', $number);
        }
        console.log($number);
    });
</script>
