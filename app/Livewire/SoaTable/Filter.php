<?php

namespace App\Livewire\SoaTable;

class Filter
{
    /**
     * La clave está en esta línea: se añaden valores por defecto a $type y $options,
     * y se reordenan para que los opcionales queden al final.
     */
    public function __construct(
        public string $key,
        public string $label,
        public string $column,
        public string $type = 'select', // Opcional, por defecto 'select'
        public array $options = []     // Opcional, por defecto un array vacío
    ) {
    }

    /**
     * Crea un filtro de botones (tipo select).
     * Sigue funcionando igual.
     */
    public static function make(string $key, string $label, array $options, string $column): self
    {
        return new static(key: $key, label: $label, column: $column, type: 'select', options: $options);
    }

    /**
     * Crea un filtro de campo de texto (tipo input).
     * Ahora funcionará correctamente.
     */
    public static function makeInput(string $key, string $label, string $column): self
    {
        return new static(key: $key, label: $label, column: $column, type: 'input');
    }
}
