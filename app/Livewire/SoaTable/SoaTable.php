<?php

namespace App\Livewire\SoaTable;

use App\Livewire\SoaTable\Concerns\HandlesActions;
use App\Livewire\SoaTable\Concerns\HandlesFilters;
use App\Livewire\SoaTable\Concerns\HandlesSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

abstract class SoaTable extends Component
{
    use WithPagination;

    // Usamos los Traits para modularizar la funcionalidad
    use HandlesActions;
    use HandlesFilters;
    use HandlesSorting;

    // Propiedades Base
    protected string $model;
    public int $perPage = 10;
    public string $title = 'Tabla';
    public string $description = '';

    // Métodos Abstractos (Contratos para las clases hijas)
    abstract protected function columns(): array;
    abstract protected function query(): Builder;

    // Métodos del Ciclo de Vida de Livewire
    #[On('refreshTableData')]
    public function refreshTable()
    {
        unset($this->rows);
    }

    #[On('unselectTableRows')]
    public function unselectTableRows()
    {
        $this->selectedRows = [];
        $this->selectAll = false;
    }

    public function getRowsProperty()
    {
        $query = $this->query();
        $query = $this->applySearch($query);

        // Lógica de filtros y ordenamiento
        // (Esta lógica permanece aquí porque depende de los métodos de los Traits)
        if (!empty($this->activeFilters)) {
            $filterDefinitions = collect($this->filters());
            foreach ($this->activeFilters as $key => $value) {
                if ($value === '') continue;
                $filter = $filterDefinitions->firstWhere('key', $key);
                if ($filter) {
                    $operator = $filter->type === 'input' ? 'like' : '=';
                    $filterValue = $filter->type === 'input' ? '%' . $value . '%' : $value;
                    if (Str::contains($filter->column, '.')) {
                        $relations = explode('.', $filter->column);
                        $column = array_pop($relations);
                        $relationship = implode('.', $relations);
                        $query->whereHas($relationship, function (Builder $q) use ($column, $operator, $filterValue) {
                            $q->where($column, $operator, $filterValue);
                        });
                    } else {
                        $query->where($filter->column, $operator, $filterValue);
                    }
                }
            }
        }

        if ($this->timeFilter !== 'all') {
             $query->where('created_at', '>=', match ($this->timeFilter) {
                '1d' => now()->subDay(), '1w' => now()->subWeek(), '1m' => now()->subMonth(), '1y' => now()->subYear(),
            });
        }

        if ($this->sortField) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.soa-table.skeleton', [
            'columns' => $this->columns(),
            'actions' => $this->actions(),
            'rows' => $this->rows,
        ]);
    }
}
