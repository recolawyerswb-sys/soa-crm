<?php

namespace App\Livewire\SoaTable;

use Closure;

class BulkAction
{
    public ?Closure $canSee = null;

    public function __construct(
        public string $label,
        public string $methodName // Cambiado de Closure a string
    ) {
    }

    public static function make(string $label, string $methodName): self
    {
        return new static($label, $methodName);
    }

    public function canSee(Closure $callback): self
    {
        $this->canSee = $callback;
        return $this;
    }
}
