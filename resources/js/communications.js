import { Device } from "@twilio/voice-sdk";


// TWILIO SERVICES
let device;
let timerInterval;
let callStatusElement, callDurationElement;

// Función principal que se activa al hacer clic en "Iniciar llamada"
async function startCall(customerId) {
    if (!customerId) {
        alert('Error: No se ha proporcionado un ID de cliente.');
        return;
    }

    // --- 1. Actualización de la UI ---
    const startBtn = document.getElementById('start-call-btn');
    const endBtn = document.getElementById('end-call-btn');
    const closeBtn = document.getElementById('close-btn');
    const loadingTitle = document.getElementById('loading-title');
    const inProgressTitle = document.getElementById('call-in-progress-title');

    // Desactivamos botones y mostramos la UI de llamada en curso
    startBtn.classList.add('hidden');
    loadingTitle.classList.add('hidden');
    endBtn.classList.remove('hidden');
    inProgressTitle.classList.remove('hidden');
    closeBtn.disabled = true;

    // ✅ 2. Busca y asigna los elementos AHORA, que sabemos que son visibles.
    callStatusElement = document.getElementById('call-status');
    callDurationElement = document.getElementById('call-duration');

    // Si por alguna razón siguen sin encontrarse, detenemos y mostramos un error.
    if (!callStatusElement || !callDurationElement) {
        console.error("No se pudieron encontrar los elementos de estado o duración en el DOM.");
        return;
    }

    updateCallStatus("Conectando...");

    // --- 2. Lógica de la Llamada con Twilio ---
    try {
        // Obtenemos el token de nuestro backend
        const response = await fetch("/crm/services/twilio/token"); // Asegúrate que esta ruta es correcta
        const data = await response.json();

        // Inicializamos Twilio Device
        device = new Device(data.token, {
            codecPreferences: ["opus", "pcmu"],
        });

        // Registramos los eventos para actualizar la UI
        device.on('error', (error) => {
            console.error(error);
            updateCallStatus(`Error: ${error.message}`);
            stopTimer();
            resetUI(); // Función para restaurar la UI
        });

        device.on('connect', () => {
            updateCallStatus("En llamada");
            startTimer();
        });

        device.on('disconnect', () => {
            updateCallStatus("Llamada finalizada");
            stopTimer();
            // Opcional: Permitir cerrar el modal después de colgar
            closeBtn.disabled = false;
        });

        // ✅ Realizamos la llamada usando el customerId para máxima seguridad
        const callParams = {
            params: {
                customerId: customerId
            }
        };
        device.connect(callParams);

    } catch (error) {
        console.error('Error al iniciar la llamada:', error);
        updateCallStatus("Error de inicialización");
        resetUI();
    }
}

function hangup() {
    if (device) {
        device.disconnectAll();
    }

    resetUI();
}

// --- Funciones de Ayuda para la UI ---

function updateCallStatus(status) {
    if (callStatusElement) callStatusElement.textContent = status;
}

function startTimer() {
    let seconds = 0;
    if (!callDurationElement) return;

    // ✅ AÑADIR ESTA VERIFICACIÓN (GUARDIA)
    // Si el elemento no existe cuando se inicia el timer, mostramos un error en consola
    // y salimos de la función para evitar que se rompa.
    if (!callDurationElement) {
        console.error('Error: No se encontró el elemento "call-duration". El temporizador no puede iniciar.');
        return;
    }

    timerInterval = setInterval(() => {
        seconds++;
        const min = Math.floor(seconds / 60).toString().padStart(2, '0');
        const sec = (seconds % 60).toString().padStart(2, '0');
        callDurationElement.textContent = `${min}:${sec}`;
    }, 1000);
}

function stopTimer() {
    clearInterval(timerInterval);
}

// Función para restaurar la UI a su estado inicial
function resetUI() {
    document.getElementById('start-call-btn').classList.remove('hidden');
    document.getElementById('loading-title').classList.remove('hidden');
    document.getElementById('end-call-btn').classList.add('hidden');
    document.getElementById('call-in-progress-title').classList.add('hidden');
    document.getElementById('close-btn').disabled = false;
    document.getElementById('call-duration').textContent = '00:00';
}

// ✅ Función de inicialización que conecta el JS con el HTML
function initializeTwilioCallHandler() {
    const startBtn = document.getElementById('start-call-btn');
    const endBtn = document.getElementById('end-call-btn');

    // ✅ PATRÓN DE GUARDIA PARA EL BOTÓN DE INICIO
    // Solo añade el listener si el botón existe Y si no lo hemos procesado antes.
    if (startBtn && !startBtn.hasAttribute('data-listener-attached')) {
        // Marcamos el botón como "procesado"
        startBtn.setAttribute('data-listener-attached', 'true');

        startBtn.addEventListener('click', (event) => {
            const customerId = event.currentTarget.dataset.customerId;
            startCall(customerId);

            startBtn.disabled = true;
            // ✅ Añadimos las clases visuales de "desactivado"
            startBtn.classList.add('opacity-50', 'pointer-events-none');
        });
    }

    // ✅ PATRÓN DE GUARDIA PARA EL BOTÓN DE COLGAR
    // Hacemos lo mismo para el botón de colgar.
    if (endBtn && !endBtn.hasAttribute('data-listener-attached')) {
        // Marcamos el botón como "procesado"
        endBtn.setAttribute('data-listener-attached', 'true');

        endBtn.addEventListener('click', () => {
            hangup();
            startBtn.disabled = false;
            // ✅ Quitamos las clases visuales de "desactivado"
            startBtn.classList.remove('opacity-50', 'pointer-events-none');
        });
    }
}

// Ejecutamos la inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initializeTwilioCallHandler);

// Para Livewire, que actualiza el DOM dinámicamente, también es bueno re-inicializar
// después de cada actualización.
document.addEventListener('livewire:navigated', initializeTwilioCallHandler);
