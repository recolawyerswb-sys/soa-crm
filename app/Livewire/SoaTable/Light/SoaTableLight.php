<?php

namespace App\Livewire\SoaTable\Light;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
// We no longer need WithPagination

abstract class SoaTableLight extends Component
{
    // Properties
    protected string $model;
    public ?string $sortField = null;
    public string $sortDirection = 'asc';
    public string $title = 'Widget'; // Add a title property

    // Abstract Methods
    abstract protected function columns(): array;
    abstract protected function query(): Builder;

    // Optional Actions
    protected function actions(): array
    {
        return [];
    }

    // Refresh Method
    #[On('refreshLightTableData')]
    public function refreshTable(): void
    {
        unset($this->rows);
    }

    // Sorting Logic
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

    // Get Rows (updated to use get() instead of paginate())
    public function getRowsProperty()
    {
        $query = $this->query();

        if ($this->sortField) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query->get(); // No more pagination
    }

    public function callLightAction(string $actionTitle, $modelId): void
    {
        // 1. Encontrar la definición de la acción por su título.
        $action = collect($this->actions())->first(
            fn(LightAction $act) => $act->title === $actionTitle
        );

        // 2. Si la acción y su callback existen, ejecutarlo.
        if ($action && is_callable($action->execCallback)) {
            // Buscamos el modelo completo para pasarlo al callback
            $model = $this->query()->find($modelId);
            if ($model) {
                // Ejecutamos el callback con el modelo
                call_user_func($action->execCallback, $model);
                $this->refreshTable(); // Refrescamos la tabla después de la acción
            }
        }
    }

    // Render Method
    public function render()
    {
        return view('livewire.soa-table.light.skeleton', [
            'columns' => $this->columns(),
            'actions' => $this->actions(),
            'rows' => $this->rows,
        ]);
    }
}
