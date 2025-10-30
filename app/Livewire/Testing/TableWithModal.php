<?php

namespace App\Livewire\Testing;

use Livewire\Attributes\On;
use Livewire\Component;

class TableWithModal extends Component
{
    public string $pageTitle = 'Pruebas de modales';
    public string $pageDescription = 'Manejar el estado de losd componentes y demas desde el padre';

    // ... tus otras propiedades de tabla

    public bool $showModal = false;
    public ?int $editingModelId = null;

    /**
     * Escucha el evento del hijo (el formulario) para cerrar el modal.
     */
    #[On('close-modal')]
    public function closeModal()
    {
        $this->showModal = false;
        $this->editingModelId = null;
    }

    /**
     * Método llamado por el botón "Crear" en tu vista.
     */
    public function create()
    {
        $this->editingModelId = null; // Nos aseguramos que no haya ID
        $this->showModal = true;      // Abrimos el modal
    }

    /**
     * Método llamado por la acción "Editar" de la tabla.
     * Ya no dependemos de un evento global 'dispatch-model-id'.
     * La acción de la tabla debería llamar a este método.
     */
    public function edit(int $customerId)
    {
        $this->editingModelId = $customerId; // Guardamos el ID
        $this->showModal = true;           // Abrimos el modal
    }

    public function render()
    {
        return view('livewire.testing.table-with-modal');
    }
}
