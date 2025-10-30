<?php

namespace App\Livewire\SoaCrm;

use App\Imports\GenericImport;
use App\Traits\Notifies;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class SoaImporter extends Component
{
    use WithFileUploads;
    use Notifies;

    /**
     * El nombre del modelo que se está importando.
     * Se recibe como parámetro en la vista.
     */
    public string $model;

    /**
     * Controla la visibilidad del modal de FluxUI.
     */
    public bool $showModal = false;

    /**
     * Almacena el archivo temporal subido.
     * @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null
     */
    public $file;

    /**
     * Reglas de validación para el archivo.
     */
    protected $rules = [
        'file' => 'required|mimes:csv,xlsx,xls|max:10240', // 10MB Máximo
    ];

    /**
     * Mensajes de validación personalizados.
     */
    protected $messages = [
        'file.required' => 'Debes seleccionar un archivo.',
        'file.mimes' => 'El archivo debe ser de tipo: csv, xlsx, xls.',
        'file.max' => 'El archivo no debe pesar más de 10MB.',
    ];

    /**
     * Se ejecuta cuando el componente se inicializa.
     */
    public function mount(string $model)
    {
        $this->model = $model;
    }

    /**
     * Abre el modal.
     */
    public function openModal()
    {
        $this->showModal = true;
    }

    /**
     * Cierra el modal y limpia el estado.
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->cancelUpload(); // Limpiamos el archivo y errores al cerrar
    }

    /**
     * Limpia el archivo seleccionado y los errores.
     */
    public function cancelUpload()
    {
        $this->reset('file');
        $this->resetErrorBag('file');
    }

    /**
     * Se ejecuta cuando la propiedad 'file' se actualiza (alguien sube un archivo).
     */
    public function updatedFile()
    {
        // Valida el archivo en cuanto se sube
        $this->validateOnly('file');
    }

    /**
     * Procesa la importación del archivo.
     */
    public function import()
    {
        $this->validate();

        try {
            // --- ¡AQUÍ VA TU LÓGICA DE IMPORTACIÓN! ---
            // Esto es solo un ejemplo usando Laravel Excel.
            // Debes adaptarlo a tu propia lógica de importación.
            //
            Excel::import(new GenericImport($this->model), $this->file->getRealPath());
            // $importClass = new YourGenericImport($this->model);
            // Excel::import($importClass, $this->file->getRealPath());
            //
            // --- Fin de la lógica de importación ---


            // 2. Cerrar el modal
            $this->closeModal();

            // 1. Emitir notificación de éxito
            // (Asegúrate de tener un sistema de notificaciones escuchando este evento)
            $this->notify('Clientes subidos correctamente', 'La pagina se reiniciara automaticamente. Por favor, no cierre la ventana');

            // 4. Refrescar la página o un componente específico
            // Opción A: Refrescar la página completa
            return redirect(request()->header('Referer'));

            // Opción B: Emitir un evento para que otro componente (ej. una tabla) se refresque
            // $this->dispatch('refreshData'); // O un nombre más específico

        } catch (\Exception $e) {
            // Manejo de errores
            $this->notify('Ha ocurrido un error al importar', $e->getMessage(), '400');

            // Opcional: añadir el error a Livewire para mostrarlo en la vista
            $this->addError('file', 'Error durante el proceso: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.soa-crm.soa-importer');
    }
}
