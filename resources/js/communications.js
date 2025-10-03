import { Device } from "@twilio/voice-sdk";


// TWILIO SERVICES
let device;
let timerInterval;
let callStatusElement, callDurationElement;
let currentCallSid = null;
let uiElements = {};

// Función central para manejar la visibilidad de los botones
function setButtonState(state) {
    const { startBtn, endBtn, closeBtn, saveBtn } = uiElements;
    if (!startBtn) return;

    // Ocultamos todos los botones de acción para empezar de cero
    startBtn.classList.add('hidden!');
    endBtn.classList.add('hidden!');
    saveBtn.classList.add('hidden!');

    closeBtn.disabled = false; // El botón cerrar se activa por defecto

    if (state === 'initial') {
        startBtn.classList.remove('hidden!');
    } else if (state === 'in-call') {
        endBtn.classList.remove('hidden!');
        closeBtn.disabled = true; // No se puede cerrar el modal durante una llamada
        endBtn.disabled = true;
        setTimeout(() => {
            endBtn.disabled = false;
        }, 4000);
    } else if (state === 'post-call') {
        // endBtn.classList.remove('hidden!');
        saveBtn.classList.remove('hidden!');
    }
}

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

    // Desactivamos botones y mostramos la UI de llamada en curso
    startBtn.classList.add('hidden!');
    endBtn.classList.remove('hidden!');
    loadingTitle.textContent = 'Llamada en curso';
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

        setButtonState('in-call');

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
            currentCallSid = call.parameters.CallSid;
            console.log('Llamada conectada con SID:', currentCallSid);
            updateCallStatus("En llamada");
            startTimer();
        });

        device.on('disconnect', () => {
            updateCallStatus("Llamada finalizada");
            stopTimer();
            setButtonState('post-call');
            loadingTitle.textContent = 'Llamada finalizada';
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

    setButtonState('post-call');

    resetUI();
}

// ✅ Nueva función para guardar y cerrar
function saveReportAndClose() {
    if (currentCallSid) {
        // Obtenemos los valores del formulario
        const notes = document.querySelector('[wire\\:model="notes"]').value;
        const status = document.querySelector('[wire\\:model="status"]').value;
        const phase = document.querySelector('[wire\\:model="phase"]').value;

        console.log(notes, status, phase);

        // Despachamos el evento a Livewire
        Livewire.dispatch('saveCallReport', {
            callSid: currentCallSid,
            notes: notes,
            status: status,
            phase: phase
        });

        Livewire.dispatch('show-notification', {
            title: 'Reporte guardado exitosamente',
        });

        // Cerramos el modal
        uiElements.closeBtn.click(); // Simulamos un clic en el botón de cerrar
    } else {
        alert("No hay un ID de llamada para guardar. Cierra el modal manualmente.");
        uiElements.closeBtn.click();
    }
}

// --- Funciones de Ayuda para la UI ---

function updateCallStatus(status) {
    if (callStatusElement) callStatusElement.textContent = status;
    console.log(status);
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
    // Encontramos todos los botones una sola vez
    uiElements.startBtn = document.getElementById('start-call-btn');
    uiElements.endBtn = document.getElementById('end-call-btn');
    uiElements.closeBtn = document.getElementById('close-btn');
    uiElements.saveBtn = document.getElementById('save-report-btn');

     // Patrón de guardia para evitar duplicar listeners
    if (uiElements.startBtn && !uiElements.startBtn.hasAttribute('data-listener-attached')) {
        uiElements.startBtn.setAttribute('data-listener-attached', 'true');
        uiElements.startBtn.addEventListener('click', (event) => {
            const customerId = event.currentTarget.dataset.customerId;
            startCall(customerId);
        });
    }

    if (uiElements.endBtn && !uiElements.endBtn.hasAttribute('data-listener-attached')) {
        uiElements.endBtn.setAttribute('data-listener-attached', 'true');
        uiElements.endBtn.addEventListener('click', () => hangup());
    }

    if (uiElements.saveBtn && !uiElements.saveBtn.hasAttribute('data-listener-attached')) {
        uiElements.saveBtn.setAttribute('data-listener-attached', 'true');
        uiElements.saveBtn.addEventListener('click', () => saveReportAndClose());
    }
}

// Ejecutamos la inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initializeTwilioCallHandler);

// Para Livewire, que actualiza el DOM dinámicamente, también es bueno re-inicializar
// después de cada actualización.
document.addEventListener('livewire:navigated', initializeTwilioCallHandler);
