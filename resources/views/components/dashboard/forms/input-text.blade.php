@props(['name', 'label', 'placeholder' => ''])

<flux:input
    label="{{ $label }}"
    placeholder="{{ $placeholder }}"
    wire:model="{{ $name }}"
    />
{{-- <div>
    @error($name) <span class="error">{{ $message }}</span> @enderror
</div> --}}
