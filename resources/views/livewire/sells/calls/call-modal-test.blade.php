<div class="p-4 border rounded bg-zinc-700">
    @if (session()->has('status'))
        <div class="p-2 bg-green-100 text-green-700 rounded mb-3">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit.prevent="send">
        <div class="mb-3">
            <label for="number">Número de teléfono</label>
            <input id="number" type="text" wire:model="number" class="border p-2 w-full">
            @error('number') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="message">Mensaje</label>
            <textarea id="message" wire:model="message" class="border p-2 w-full"></textarea>
            @error('message') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Enviar
        </button>
    </form>
</div>
