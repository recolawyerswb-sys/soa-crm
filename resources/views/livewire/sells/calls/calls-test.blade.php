<div>
    @if (session()->has('status'))
        <div class="p-2 bg-green-100 text-green-700 rounded mb-3">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit.prevent="sendSms">
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

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Enviar SMS</button>
        <button type="button" wire:click="makeCall" class="bg-green-600 text-white px-4 py-2 rounded ml-2">
            Llamar
        </button>
    </form>

    {{-- Modal --}}
    @if($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow-lg w-96">
                <h2 class="text-xl font-bold mb-4">Información de la llamada</h2>
                <p><strong>Nombre:</strong> {{ $clientName }}</p>
                <p><strong>País:</strong> {{ $clientCountry }}</p>
                <p><strong>Duración:</strong> {{ $callDuration }}</p>

                <button wire:click="$set('showModal', false)" class="mt-4 bg-red-600 text-white px-4 py-2 rounded">
                    Cerrar
                </button>
            </div>
        </div>
    @endif
</div>
