import { Device } from "@twilio/voice-sdk";


// TWILIO SERVICES
let device;
let timerInterval;
let callDurationElement;
let currentCallSid = null;
let activeCall = null;
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

    setButtonState('in-call');
    updateCallStatus("Conectando la llamada...");

    if (!customerId) {
        alert('Error: No se ha proporcionado un ID de cliente.');
        return;
    }

    // --- 1. Actualización de la UI ---
    const startBtn = document.getElementById('start-call-btn');
    const endBtn = document.getElementById('end-call-btn');
    const closeBtn = document.getElementById('close-btn');

    // Desactivamos botones y mostramos la UI de llamada en curso
    startBtn.classList.add('hidden!');
    endBtn.classList.remove('hidden!');
    closeBtn.disabled = true;

    callDurationElement = document.getElementById('call-duration');

    // Si por alguna razón siguen sin encontrarse, detenemos y mostramos un error.
    if (!callDurationElement) {
        console.error("No se pudieron encontrar los elementos de estado o duración en el DOM.");
        return;
    }

    // --- 2. Lógica de la Llamada con Twilio ---
    try {
        // Obtenemos el token de nuestro backend
        const response = await fetch("/crm/services/twilio/token"); // Asegúrate que esta ruta es correcta
        const data = await response.json();

        // Inicializamos Twilio Device
        if (!device) {
            device = new Device(data.token, {
                codecPreferences: ["opus", "pcmu"],
            });
        } else {
            // Si el device ya existe, actualizamos su token por si expiró
            device.updateToken(data.token);
        }

        const callParams = { params: { customerId: customerId } };

        // ✅ Obtenemos el objeto 'Call' y lo guardamos
        activeCall = await device.connect(callParams);

        // Registramos los eventos para actualizar la UI
        activeCall.on('error', (error) => {
            console.error("Error en la llamada:", error);
            updateCallStatus(`Error: ${error.message}`);
            stopTimer();
            setButtonState('initial'); // O un estado de error
        });

        activeCall.on('accept', (call) => {
            updateCallStatus("Llamada en curso");
            currentCallSid = call.parameters.CallSid;
            console.log('Llamada conectada con SID:', currentCallSid);
            startTimer();
        });

        // ✅ Asignamos los listeners a la LLAMADA, no al device
        activeCall.on('disconnect', () => {
            updateCallStatus("Finalizaste la llamada. Completa el reporte.");
            stopTimer();
            setButtonState('post-call');
            activeCall = null; // Limpiamos la llamada activa
        });

        activeCall.on('reject', () => {
            updateCallStatus("El cliente ha rechazado la llamada. Completa el reporte.");
            stopTimer();
            setButtonState('post-call');
            activeCall = null; // Limpiamos la llamada activa
        });

    } catch (error) {
        console.error('Error al iniciar la llamada:', error);
        updateCallStatus("Error de inicialización");
        resetUI();
    }
}

function hangup() {
    console.log("Intentando colgar la llamada...");
    // Usamos el objeto de la llamada activa para desconectar
    if (activeCall) {
        activeCall.disconnect();
    }
    console.log('Llamada finalizada con SID', currentCallSid);
}

// ✅ Nueva función para guardar y cerrar
function saveReportAndClose() {
    if (currentCallSid) {
        // Obtenemos los valores del formulario
        // const notes = document.querySelector('[wire\\:model="notes"]');
        const notes = document.getElementById('notes').value;
        const status = document.querySelector('[wire\\:model="status"]').value;
        const phase = document.querySelector('[wire\\:model="phase"]').value;

        // Despachamos el evento a Livewire
        Livewire.dispatch('saveCallReport', {
            callSid: currentCallSid,
            notes: notes,
            status: status,
            phase: phase
        });

        // Cerramos el modal
        uiElements.closeBtn.click(); // Simulamos un clic en el botón de cerrar
        notes.value = '';
        status.value = '';
        phase.value = '';
    } else {
        alert("No hay un ID de llamada para guardar. Cierra el modal manualmente.");
        uiElements.closeBtn.click();
    }
}

// --- Funciones de Ayuda para la UI ---

function updateCallStatus(status) {
    const loadingTitle = document.getElementById('loading-title');
    console.log(status);
    loadingTitle.textContent = status;
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
