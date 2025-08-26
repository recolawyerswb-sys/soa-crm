<?php

namespace App\Livewire\SoaTable\Concerns;

use Illuminate\Support\Str;

trait HandlesSorting
{
    // Propiedades
    public ?string $sortField = null;
    public string $sortDirection = 'asc';

    // Método para Ordenar
    public function sortBy(string $field): void
    {
        if (!Str::contains($field, '.')) {
            if ($this->sortField === $field) {
                $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                $this->sortField = $field;
                $this->sortDirection = 'asc';
            }
        }
    }
}
