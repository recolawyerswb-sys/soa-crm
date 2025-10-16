<?php

namespace App\Livewire\SoaTable\Concerns;

use App\Livewire\SoaTable\Action;
use App\Livewire\SoaTable\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use ReflectionMethod;

trait HandlesActions
{
    // Propiedades
    public array $selectedRows = [];
    public bool $selectAll = false;
    public ?string $activeBulkAction = null;
    public bool $bulkActionsAreEnabled = true;
    public bool $actionsAreEnabled = true;
    public ?string $viewRouteName = null;

    // Métodos Públicos para Acciones por Defecto
    public function viewRecord($id)
    {
        $viewRoute = $this->getViewRouteName();
        if ($viewRoute) {
            redirect()->route($viewRoute, ['id' => $id]);
        }
    }

    public function deleteRecord($id)
    {
        $this->query()->find($id)?->delete();
        $this->refreshTable();
    }

    public function deleteSelected()
    {

        $models = $this->getSelectedRowsQuery()->get();
        $models->each(function ($model) {
            $model->delete();
        });

        $this->refreshTable();
        $this->selectedRows = [];
        $this->selectAll = false;
    }

    // Métodos Protegidos para Definir Acciones
    protected function defaultActions(): array
    {
        $actions = [];
        // $viewIcon = 'eye';

        // if ($this->getViewRouteName()) {
        //     $actions[] = Action::make('viewRecord', $viewIcon)->label('Ver');
        // }
        return $actions;
    }

     /**
     * Define la condición para habilitar las acciones de fila.
     * Puede ser sobrescrito por las clases hijas.
     */
    protected function enableActions(): bool
    {
        return true; // Habilitado por defecto
    }

    /**
     * Define la condición para habilitar las acciones masivas.
     * Puede ser sobrescrito por las clases hijas.
     */
    protected function enableBulkActions(): bool
    {
        return auth()->user()->isAdmin(); // Habilitado por defecto
    }

    protected function defaultBulkActions(): array
    {
        return [
            BulkAction::make('Eliminar Seleccionados', 'deleteSelected')
                ->canSee(fn () => auth()->user()->isAdmin()),
        ];
    }

    // Métodos para Lógica y Renderizado
    protected function actions(): array
    {
        return array_merge($this->defaultActions(), $this->additionalActions());
    }

    protected function bulkActions(): array
    {
        return array_merge($this->defaultBulkActions(), $this->additionalBulkActions());
    }

    // Métodos Placeholder para Clases Hijas
    protected function additionalActions(): array
    {
        return [];
    }

    protected function additionalBulkActions(): array
    {
        return [];
    }

    protected function getViewRouteName(): ?string
    {
        return $this->viewRouteName;
    }

    // Métodos para Ejecutar Acciones
    public function callAction(string $methodName, $modelId)
    {
        if (method_exists($this, $methodName)) {
            // $this->{$methodName}($modelId); => RECIBIR SOLO EL ID

            // Use Reflection to inspect the action method
            $reflection = new ReflectionMethod($this, $methodName);
            $parameters = $reflection->getParameters();

            // Check if the first parameter is type-hinted as an Eloquent Model
            if (isset($parameters[0]) && $parameters[0]->hasType() &&
                is_subclass_of($parameters[0]->getType()->getName(), Model::class)
            ) {
                // If yes, find the model and pass the full object
                $model = $this->query()->find($modelId);
                if ($model) {
                    $this->{$methodName}($model);
                }
            } else {
                // Otherwise, just pass the ID as before
                $this->{$methodName}($modelId);
            }
        }
    }

    public function runBulkAction(): void
    {
        if (!$this->activeBulkAction || empty($this->selectedRows)) return;
        $action = collect($this->bulkActions())->first(fn(BulkAction $action) => $action->label === $this->activeBulkAction);
        if ($action && method_exists($this, $action->methodName)) {
            $this->{$action->methodName}();
        }
        $this->activeBulkAction = null;
    }

    // Métodos de Soporte para Selección
    public function updatedSelectAll(bool $value): void
    {
        $this->selectedRows = $value ? $this->rows->pluck('id')->map(fn ($id) => (string) $id)->toArray() : [];
    }

    public function getSelectedRowsQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->query()->whereIn($this->model::make()->getKeyName(), $this->selectedRows);
    }
}
