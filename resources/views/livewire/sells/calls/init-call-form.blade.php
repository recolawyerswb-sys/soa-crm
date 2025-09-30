<div>
    {{-- ✅ Envolvemos la sección dinámica en un div con wire:ignore --}}
    <div wire:ignore>
        <div class="w-full py-2 flex justify-between items-center">
            <div class="w-auto">
                {{-- Título inicial que se ocultará --}}
                <h2 class="text-2xl" id="loading-title">
                    Llamar a <span class="font-bold">{{ $this->full_name }}</span>
                </h2>

                {{-- Título y duración que se mostrarán durante la llamada --}}
                <div id="call-in-progress-title" class="hidden">
                    <h2 class="text-2xl">
                        Llamando a <span class="font-bold">{{ $this->full_name }}</span>
                    </h2>
                    {{-- ✅ Duración y estado de la llamada --}}
                    <div class="text-sm text-gray-500 font-mono flex items-center gap-2">
                        <span id="call-status">Inicializando...</span>
                        <span>-</span>
                        <span id="call-duration">00:00</span>
                    </div>
                </div>
            </div>

            {{-- INFO BASICA CLIENTE --}}
            <div class="flex-1 flex gap-2 justify-end">
                <flux:badge variant="solid" color="indigo">{{ $this->country }}</flux:badge>
                <flux:badge variant="solid" color="yellow">{{ $this->status }}</flux:badge>
                <flux:badge variant="solid" color="green">${{ $this->balance }} </flux:badge>
            </div>
        </div>
    </div>

    <div class="py-4 flex flex-col gap-3">
        {{-- NOTAS --}}
        <div class="grid grid-cols-1 md:grid-cols-1">
            <flux:textarea label="Notas" wire:model="form.notes"/>
        </div>
        {{-- ESTADO, FASE --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:select label="Estado" description:trailing="Seleccione el nuevo estado del cliente" wire:model="form.status" placeholder="Elije el estado...">
            @foreach ($this->statuses as $status)
                <flux:select.option value="{{ $status }}">{{ $status }}</flux:select.option>
            @endforeach
            </flux:select>
            <flux:select label="Fase" description:trailing="Seleccione la nueva fase a la que avanza el cliente" wire:model="form.phase" placeholder="Elije la fase...">
            @foreach ($this->phases as $phase)
                <flux:select.option value="{{ $phase }}">{{ $phase }}</flux:select.option>
            @endforeach
            </flux:select>
        </div>
    </div>

    <div class="flex">
        <flux:button color='zinc' id="close-btn" x-on:click="$flux.modal('init-call').close()">
            Cerrar
        </flux:button>
        <flux:spacer />
        {{-- ✅ Botón para iniciar llamada, llama a JS con el ID del cliente --}}
        <flux:button id="start-call-btn" variant="primary" data-customer-id="{{ $this->customerId }}">
            Iniciar llamada
        </flux:button>
        {{-- ✅ Botón para colgar, llama a la función hangup() --}}
        <flux:button id="end-call-btn" variant="danger" class="hidden">
            Colgar
        </flux:button>
    </div>
</div>

<script>
    // let device;
    // let timerInterval;

    // // Función principal que se activa al hacer clic en "Iniciar llamada"
    // async function startCall(customerId) {
    //     if (!customerId) {
    //         alert('Error: No se ha proporcionado un ID de cliente.');
    //         return;
    //     }

    //     // --- 1. Actualización de la UI ---
    //     const startBtn = document.getElementById('start-call-btn');
    //     const endBtn = document.getElementById('end-call-btn');
    //     const closeBtn = document.getElementById('close-btn');
    //     const loadingTitle = document.getElementById('loading-title');
    //     const inProgressTitle = document.getElementById('call-in-progress-title');

    //     // Desactivamos botones y mostramos la UI de llamada en curso
    //     startBtn.classList.add('hidden');
    //     loadingTitle.classList.add('hidden');
    //     endBtn.classList.remove('hidden');
    //     inProgressTitle.classList.remove('hidden');
    //     closeBtn.disabled = true;

    //     updateCallStatus("Conectando...");

    //     // --- 2. Lógica de la Llamada con Twilio ---
    //     try {
    //         // Obtenemos el token de nuestro backend
    //         const response = await fetch("{{ route('services.twilio.token') }}"); // Asegúrate que esta ruta es correcta
    //         const data = await response.json();

    //         // Inicializamos Twilio Device
    //         device = new Twilio.Device(data.token, {
    //             codecPreferences: ["opus", "pcmu"],
    //         });

    //         // Registramos los eventos para actualizar la UI
    //         device.on('error', (error) => {
    //             console.error(error);
    //             updateCallStatus(`Error: ${error.message}`);
    //             stopTimer();
    //             resetUI(); // Función para restaurar la UI
    //         });

    //         device.on('connect', () => {
    //             updateCallStatus("En llamada");
    //             startTimer();
    //         });

    //         device.on('disconnect', () => {
    //             updateCallStatus("Llamada finalizada");
    //             stopTimer();
    //             // Opcional: Permitir cerrar el modal después de colgar
    //             closeBtn.disabled = false;
    //         });

    //         // ✅ Realizamos la llamada usando el customerId para máxima seguridad
    //         const callParams = {
    //             params: {
    //                 customerId: customerId
    //             }
    //         };
    //         device.connect(callParams);

    //     } catch (error) {
    //         console.error('Error al iniciar la llamada:', error);
    //         updateCallStatus("Error de inicialización");
    //         resetUI();
    //     }
    // }

    // function hangup() {
    //     if (device) {
    //         device.disconnectAll();
    //     }
    // }

    // // --- Funciones de Ayuda para la UI ---

    // function updateCallStatus(status) {
    //     const statusElement = document.getElementById('call-status');
    //     if (statusElement) statusElement.textContent = status;
    // }

    // function startTimer() {
    //     let seconds = 0;
    //     const durationElement = document.getElementById('call-duration');
    //     if (!durationElement) return;

    //     timerInterval = setInterval(() => {
    //         seconds++;
    //         const min = Math.floor(seconds / 60).toString().padStart(2, '0');
    //         const sec = (seconds % 60).toString().padStart(2, '0');
    //         durationElement.textContent = `${min}:${sec}`;
    //     }, 1000);
    // }

    // function stopTimer() {
    //     clearInterval(timerInterval);
    // }

    // // Función para restaurar la UI a su estado inicial
    // function resetUI() {
    //     document.getElementById('start-call-btn').classList.remove('hidden');
    //     document.getElementById('loading-title').classList.remove('hidden');
    //     document.getElementById('end-call-btn').classList.add('hidden');
    //     document.getElementById('call-in-progress-title').classList.add('hidden');
    //     document.getElementById('close-btn').disabled = false;
    //     document.getElementById('call-duration').textContent = '00:00';
    // }
</script>
