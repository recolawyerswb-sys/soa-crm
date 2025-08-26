@props(['w'=>'lg', 'title' => 'Template form','description' => 'Provide a description.','modalName'])

@php
    $w = "md:w-$w";
@endphp

<flux:modal
    {{ $attributes->class([$w]) }}
    :dismissible="false"
    name="{{ $modalName }}"
    variant="flyout"
>
    <div class="space-y-6">
        {{-- Modal Header --}}
        <div>
            <flux:heading size="lg">
                {{ $title }}
            </flux:heading>
            <flux:text class="mt-2">
                {{ $description }}
            </flux:text>
        </div>
        {{-- Modal body - FORM --}}
        {{ $slot }}
    </div>
</flux:modal>
