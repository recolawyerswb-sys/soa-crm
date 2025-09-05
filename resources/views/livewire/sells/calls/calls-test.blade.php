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
                <input id="number" type="tel" wire:model.defer="number" placeholder="+1 (555) 123-4567"
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

                <button onclick="startCall('{{ $number }}')" class="bg-blue-500 text-white p-2 rounded">
                    Llamar
                    <span wire:loading>Llamando...</span>
                </button>

                {{-- <button type="button" wire:click="makeCall"
                onclick="initTwilioDevice(); makeBrowserCall('{{ $number }}')"
                        class="w-full inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-zinc-800 transition-colors disabled:opacity-50">
                    <span wire:loading.remove wire:target="makeCall">Llamar desde el navegador</span>
                    <span wire:loading wire:target="makeCall">Llamando...</span>
                </button> --}}
            </div>
        </form>
    </div>

    @if($showModal)
        <div class="fixed inset-0 z-10 bg-black/60 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-xl w-full max-w-sm p-6 space-y-4">

                <h2 class="text-xl font-bold text-zinc-900 dark:text-neutral-100">
                    Llamada en curso...
                </h2>

                <div class="text-sm text-zinc-600 dark:text-neutral-300 space-y-2 border-t dark:border-zinc-700 pt-4">
                    <p><strong>Nombre:</strong> {{ $clientName }}</p>
                    <p><strong>País:</strong> {{ $clientCountry }}</p>
                    <p>
                        <strong>Estado:</strong>
                        <span id="call-status" class="font-mono">Inicializando...</span>
                    </p>
                    <p>
                        <strong>Duración:</strong>
                        <span id="call-duration" class="font-mono">00:00</span>
                    </p>
                </div>

                <div class="pt-2 text-right space-x-2">
                    <button onclick="hangup()"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                        Colgar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    let device;
    let timerInterval;

    /**
     * Función principal que inicia la llamada.
     * Se llama desde el botón "Llamar".
     */
    async function startCall(toNumber) {
        if (!toNumber) {
            alert('Por favor, ingresa un número de teléfono.');
            return;
        }

        console.log(`Iniciando llamada a ${toNumber}...`);

        // 1. Abrimos el modal de Livewire
        @this.call('openCallModal');

        try {

            // 2. Obtenemos el token de nuestro backend
            const response = await fetch("{{ route('sells.calls.twilio.token') }}");
            const data = await response.json();

            // El resto del código es muy similar
            updateCallStatus("Obteniendo token...");

            // 3. Inicializamos Twilio Device (¡esto pide permiso para el micro!)
            device = new Twilio.Device(data.token, {
                codecPreferences: ["opus", "pcmu"],
            });

            // 4. Registramos los eventos para actualizar la UI
            device.on('ready', () => updateCallStatus("Listo para llamar"));
            device.on('connect', connection => {
                updateCallStatus("Conectado");
                startTimer(); // Inicia el cronómetro cuando la llamada se conecta
            });
            device.on('disconnect', () => {
                updateCallStatus("Llamada finalizada");
                stopTimer(); // Detiene el cronómetro
                // Opcional: Cierra el modal después de unos segundos
                setTimeout(() => @this.set('showModal', false), 2000);
            });
            device.on('error', err => {
                console.error(err);
                updateCallStatus(`Error: ${err.message}`);
                stopTimer();
            });

            // 5. Realizamos la llamada
            updateCallStatus("Llamando...");
            device.connect({ params: { To: toNumber } });

        } catch (error) {
            console.error('Error al iniciar la llamada:', error);
            updateCallStatus("Error de inicialización");
        }
    }

    /**
     * Cuelga la llamada activa.
     */
    function hangup() {
        if (device) {
            device.disconnectAll();
        }
    }

    // --- Funciones de Ayuda para la UI ---

    function updateCallStatus(status) {
        // Busca el elemento en el DOM
        const statusElement = document.getElementById('call-status');

        // Solo si el elemento existe, actualiza su contenido
        if (statusElement) {
            statusElement.textContent = status;
        } else {
            // Si no existe, muestra un log para saber qué está pasando
            console.log(`Estado de llamada: ${status} (UI no lista todavía)`);
        }
    }

    function startTimer() {
        let seconds = 0;
        const durationElement = document.getElementById('call-duration');
        timerInterval = setInterval(() => {
            seconds++;
            const min = Math.floor(seconds / 60).toString().padStart(2, '0');
            const sec = (seconds % 60).toString().padStart(2, '0');
            durationElement.textContent = `${min}:${sec}`;
        }, 1000);
    }

    function stopTimer() {
        if (timerInterval) {
            clearInterval(timerInterval);
        }
    }
</script>
