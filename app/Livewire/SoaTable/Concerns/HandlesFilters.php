<?php

namespace App\Livewire\SoaTable\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HandlesFilters
{
    // Propiedades
    public string $search = '';
    public string $timeFilter = 'all';
    public array $activeFilters = [];

    // Métodos para Definir Filtros
    protected function filters(): array
    {
        return [];
    }

    // Métodos para Ejecutar Filtros
    public function setFilter(string $key, $value): void
    {
        if (isset($this->activeFilters[$key]) && $this->activeFilters[$key] === $value) {
            unset($this->activeFilters[$key]);
        } else {
            $this->activeFilters[$key] = $value;
        }
        $this->resetPage();
    }

    public function setTimeFilter(string $filter): void
    {
        $this->timeFilter = $filter;
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    // Método para Aplicar Búsqueda a la Consulta
    protected function applySearch(Builder $query): Builder
    {
        if ($this->search === '') {
            return $query;
        }

        $searchableColumns = collect($this->columns())
            ->filter(fn ($column) => $column->searchable)
            ->pluck('field')
            ->all();

        if (empty($searchableColumns)) {
            return $query;
        }

        $query->where(function (Builder $query) use ($searchableColumns) {
            foreach ($searchableColumns as $field) {
                if (Str::contains($field, '.')) {
                    $relations = explode('.', $field);
                    $column = array_pop($relations);
                    $relationship = implode('.', $relations);
                    $query->orWhereHas($relationship, function (Builder $q) use ($column) {
                        $q->where($column, 'like', '%' . $this->search . '%');
                    });
                } else {
                    $query->orWhere($field, 'like', '%' . $this->search . '%');
                }
            }
        });

        return $query;
    }
}
