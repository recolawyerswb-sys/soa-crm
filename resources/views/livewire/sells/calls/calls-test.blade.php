<div class="bg-neutral-100 dark:bg-zinc-700 min-h-screen font-sans flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white dark:bg-zinc-800 p-8 rounded-xl shadow-lg space-y-6">

        <h1 class="text-2xl font-bold text-center text-zinc-800 dark:text-neutral-100">
            Contactar Cliente 📲
        </h1>

        @if (session()->has('status'))
            <div class="p-3 bg-green-100 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg text-sm transition-all duration-300">
                <span>✅ {{ session('status') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="sendSms" class="space-y-6">
            <div>
                <label for="number" class="block text-sm font-medium text-zinc-700 dark:text-neutral-300 mb-1">
                    Número de teléfono
                </label>
                <input id="number" type="tel" wire:model.lazy="number" placeholder="+1 (555) 123-4567"
                       class="block w-full px-3 py-2 bg-white dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-neutral-100 sm:text-sm transition-colors">
                @error('number')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-zinc-700 dark:text-neutral-300 mb-1">
                    Mensaje
                </label>
                <textarea id="message" wire:model.lazy="message" rows="4" placeholder="Escribe tu mensaje aquí..."
                          class="block w-full px-3 py-2 bg-white dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-neutral-100 sm:text-sm transition-colors"></textarea>
                @error('message')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4">
                <button type="submit"
                        class="w-full inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-zinc-800 transition-colors disabled:opacity-50">
                    <span wire:loading.remove wire:target="sendSms">Enviar SMS</span>
                    <span wire:loading wire:target="sendSms">Enviando...</span>
                </button>
                <button type="button" wire:click="makeCall"
                        class="w-full inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-zinc-800 transition-colors disabled:opacity-50">
                    <span wire:loading.remove wire:target="makeCall">Llamar</span>
                    <span wire:loading wire:target="makeCall">Llamando...</span>
                </button>
            </div>
        </form>
    </div>

    @if($showModal)
        <div class="fixed inset-0 z-10 bg-black/60 flex items-center justify-center p-4">

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl w-full max-w-sm p-6 space-y-4"
                 wire:click.away="$set('showModal', false)"> <h2 class="text-xl font-bold text-zinc-900 dark:text-neutral-100">Información de la llamada</h2>

                <div class="text-sm text-zinc-600 dark:text-neutral-300 space-y-2 border-t dark:border-zinc-700 pt-4">
                    <p><strong class="font-medium text-zinc-800 dark:text-neutral-200">Nombre:</strong> {{ $clientName }}</p>
                    <p><strong class="font-medium text-zinc-800 dark:text-neutral-200">País:</strong> {{ $clientCountry }}</p>
                    <p><strong class="font-medium text-zinc-800 dark:text-neutral-200">Duración:</strong> {{ $callDuration }}</p>
                </div>

                <div class="pt-2 text-right">
                    <button wire:click="$set('showModal', false)"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-zinc-800 transition-colors">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
