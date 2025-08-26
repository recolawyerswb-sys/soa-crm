<?php

namespace App\Livewire\SoaTable;

use Closure;

/**
 * Clase para definir las columnas de la tabla.
 */
class Column
{

    public bool $sortable = false; // Indica si la columna es ordenable
    public bool $isCurrency = false;
    public string $currencySymbol = '$';
    public int $currencyDecimals = 2;
    public bool $isDate = false;
    public string $dateFormat = 'd/m/Y';
    public ?Closure $formatCallback = null; // Callback para formatear el valor de la celda
    public ?Closure $canSee = null;


    // --- FIN: NUEVAS PROPIEDADES ---

    public function __construct(
        public string $label,
        public string $field,
        public bool $isView = false,
        public bool $searchable = false,
        public string $classes = '',
        public string $maxWidth = ''
    ) {
    }

    /**
     * Crea una instancia de columna estándar (mapeada a un campo de BD).
     *
     * @param string $label El texto que se mostrará en la cabecera.
     * @param string $field El nombre del campo en el modelo de Eloquent.
     * @return self
     */
    public static function make(string $label, string $field): self
    {
        return new static(label: $label, field: $field);
    }

    /**
     * Crea una instancia de columna que renderiza una vista de Blade.
     *
     * @param string $label El texto que se mostrará en la cabecera.
     * @param string $viewPath La ruta a la vista de Blade (ej: 'livewire.tables.columns.color').
     * @return self
     */
    public static function makeView(string $label, string $viewPath): self
    {
        return new static(label: $label, field: $viewPath, isView: true);
    }

    /**
     * Hace que la columna sea buscable.
     */
    public function searchable(): self
    {
        $this->searchable = true;
        return $this;
    }

    public function sortable(): self
    {
        $this->sortable = true;
        return $this;
    }

    /**
     * Formatea la columna como una fecha usando Carbon.
     */
    public function date(string $format = 'd/m/Y'): self
    {
        $this->isDate = true;
        $this->dateFormat = $format;
        return $this;
    }

    /**
     * Aplica formato de moneda a la columna.
     *
     * @param string $symbol El símbolo de la moneda (ej: '$', '€', 'COP ').
     * @param int $decimals El número de decimales a mostrar.
     * @return self
     */
    public function currency(string $symbol = '$', int $decimals = 2): self
    {
        $this->isCurrency = true;
        $this->currencySymbol = $symbol;
        $this->currencyDecimals = $decimals;
        return $this;
    }
    // --- FIN: NUEVO MÉTODO ---

    /**
     * Añade clases CSS a la celda (<td>).
     */
    public function addClasses(string $classes): self
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * Define un ancho máximo para la columna.
     */
    public function maxWidth(string $width): self
    {
        $this->maxWidth = $width;
        return $this;
    }

    public function customFormat(Closure $callback):self
    {
        $this->formatCallback = $callback;
        return $this;
    }

    public function canSee(Closure $callback): self
    {
        $this->canSee = $callback;
        return $this;
    }
}
