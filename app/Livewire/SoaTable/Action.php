<?php

namespace App\Livewire\SoaTable;

/**
 * Clase para definir las acciones por fila.
 */
class Action
{

    // La propiedad guardará nuestra función de condición. Es nullable.
    public ?\Closure $canSee = null;
    public ?string $label = null; // Hacemos el label opcional

    public function __construct(
        public string $method,
        public string $icon,
        public string $classes = 'p-2 rounded-full bg-slate-700/50 hover:bg-slate-700'
    ) {
    }

    /**
     * Crea una nueva instancia de Action.
     *
     * @param string $label El texto del botón o enlace.
     * @param string $method El nombre del método público en el componente Livewire a llamar.
     * @return self
     */
    public static function make(string $method, string $icon): self
    {
        return new static(method: $method, icon: $icon);
    }

    /**
     * Añade una etiqueta de tooltip opcional al botón.
     */
    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function classes(string $classes): self
    {
        $this->classes = $classes; // Asigna las nuevas clases
        return $this; // Retorna la instancia para permitir el encadenamiento
    }

    public function canSee(\Closure $callback): self
    {
        $this->canSee = $callback;
        return $this;
    }
}
