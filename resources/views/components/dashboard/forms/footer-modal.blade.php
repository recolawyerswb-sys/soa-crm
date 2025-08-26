@props(['modalName', 'isEditEnabled' => false])

<div class="flex">
    <button type="button" x-on:click="{{'$flux.modal('.'"'. $modalName .'"'.').close()'}}">
        Cancelar
    </button>
    <flux:spacer />
    <flux:button type="submit" variant="primary">
        {{ !$isEditEnabled ? 'Guardar' : 'Actualizar' }}
    </flux:button>
</div>
