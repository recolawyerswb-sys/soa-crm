<?php

namespace App\Http\Livewire\SoaSelect;

use Livewire\Component;
use Illuminate\Support\Collection;

class SmartSelect extends Component
{
    // --- PROPIEDADES PÚBLICAS (Configuración desde la vista) ---

    /** @var string El nombre de la clase del Modelo a buscar (ej. App\Models\User::class) */
    public $modelClass;

    /** @var Collection|null Una colección de datos pre-cargada. */
    public $initialData = [];

    public ?bool $readyToLoad = false; // <-- Nueva propiedad de control

    /** @var string La columna del modelo por la cual se va a buscar. */
    public $searchColumn;

    /** @var string La columna que se mostrará en las opciones del select. */
    public ?string $displayColumn = 'name';

    /** @var string El nombre que tendrá el input hidden para enviar en un formulario. */
    public ?string $inputName = 'selected_id';

    /** @var string El ID del elemento seleccionado inicialmente. */
    public $selectedId = null;

    /** @var bool NUEVA PROPIEDAD: Define si el componente tendrá buscador o no. */
    public ?bool $isSearchable = true;


    // --- PROPIEDADES INTERNAS (Estado del componente) ---

    /** @var string El texto que el usuario escribe en el buscador. */
    public string $search = '';

    /** @var string El texto que se muestra del elemento seleccionado. */
    public string $selectedName = '';

    /** @var bool Controla si el menú desplegable de opciones está visible o no. */
    public bool $showDropdown = false;

    /**
     * Este método será llamado por wire:init desde la vista.
     */
    public function loadData()
    {
        // Aquí pones la lógica que antes estaba en mount() o la que carga los datos
        // Por ejemplo, si los datos no se pasaran como prop:
        // $this->initialData = Customer::select(...)->get();

        $this->readyToLoad = true;
    }

    public function mount()
    {
        dd($this); // <-- AÑADE ESTA LÍNEA TEMPORALMENTE

        // Asegurarnos que initialData sea una colección...
        $this->initialData = collect($this->initialData);

        if ($this->selectedId) {
            $this->selectItem($this->selectedId, true);
        }
    }

    /**
     * Este método se ejecuta cuando se selecciona una opción en el modo NO BUSCABLE.
     * El `wire:model` en el <select> actualiza $selectedId y este hook se dispara.
     */
    public function updatedSelectedId($id)
    {
        $this->selectItem($id);
    }

    public function updatedSearch()
    {
        if (empty($this->search)) {
            $this->showDropdown = false;
            $this->selectedId = null;
            $this->selectedName = '';
            return;
        }
        $this->showDropdown = true;
    }

    public function selectItem($id, $isInitial = false)
    {
        $item = null;
        if ($this->modelClass) {
            $item = $this->modelClass::find($id);
        } else {
            $item = $this->initialData->firstWhere('id', $id);
        }

        if ($item) {
            $this->selectedId = $item->id;
            $this->selectedName = $item->{$this->displayColumn};
            if ($this->isSearchable) {
                $this->search = $this->selectedName; // Solo actualizamos el input de búsqueda si existe
            }
            $this->showDropdown = false;

            if (!$isInitial) {
                $this->emit('smartSelect_itemSelected', $this->selectedId);
            }
        }
    }

    // Un método helper para organizar la obtención de opciones
    public function getOptions()
    {
        // ... toda la lógica que tenías en render() para obtener las opciones
         $options = collect();

        if ($this->isSearchable) {
            // Lógica de búsqueda (igual que antes)
            if ($this->showDropdown && strlen($this->search) > 0) {
                $searchTerms = explode(' ', $this->search);
                if ($this->modelClass) {
                    $query = $this->modelClass::query();
                    $query->where(function ($q) use ($searchTerms) {
                        foreach ($searchTerms as $term) {
                            if (!empty($term)) {
                                $q->orWhere($this->searchColumn, 'like', '%' . $term . '%');
                            }
                        }
                    });
                    $options = $query->take(10)->get();
                } elseif ($this->initialData) {
                    $options = $this->initialData->filter(function ($item) use ($searchTerms) {
                        $itemValue = strtolower($item[$this->searchColumn]);
                        foreach ($searchTerms as $term) {
                            if (str_contains($itemValue, strtolower($term))) return true;
                        }
                        return false;
                    })->take(10);
                }
            }
        } else {
            // Si no es buscable, cargamos TODAS las opciones de una vez.
            if ($this->modelClass) {
                $options = $this->modelClass::all();
            } else {
                $options = $this->initialData;
            }
        }
    }

    public function placeholder()
    {
        return '<div class="w-full px-4 py-2 border border-slate-300 rounded-md bg-slate-100 text-slate-400">
            Cargando...
        </div>';
    }

    public function render()
    {
        return view('livewire.soa-select.smart-select')->with([
            'options' => $this->readyToLoad ? $this->getOptions() : [],
        ]);
    }
}
