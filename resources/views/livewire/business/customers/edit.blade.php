<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

{{-- Esta sería una vista de "show" o perfil, no una de "edit" --}}
<div class="rounded-xl border-2 p-8">
    <h2 class="text-2xl font-bold">Perfil de Ana Pérez</h2>

    <div class="mt-6 space-y-4">
        {{-- Campo Nombre (Ejemplo con Livewire/Alpine) --}}
        <div x-data="{ editing: false }">
            <label class="block text-sm font-medium">Nombre</label>
            <div x-show="!editing" class="flex items-center gap-4">
                <p class="text-lg">Ana Pérez</p>
                <button @click="editing = true" class="text-sm text-indigo-600">Editar</button>
            </div>
            <div x-show="editing" style="display:none;">
                <input type="text" value="Ana Pérez" class="rounded-lg">
                <button @click="editing = false; $wire.saveName($event.target.previousElementSibling.value)" class="rounded-lg bg-indigo-600 px-3 py-2 text-sm text-white">Guardar</button>
                <button @click="editing = false" class="text-sm">Cancelar</button>
            </div>
        </div>

         {{-- Campo Email (similar al de arriba) --}}
         {{-- ... --}}
    </div>
</div>
