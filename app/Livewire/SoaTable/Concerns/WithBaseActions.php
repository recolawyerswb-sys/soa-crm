<?php

namespace App\Livewire\SoaTable\Traits;

use App\Livewire\SoaTable\BulkAction;
use Illuminate\Database\Eloquent\Collection;

trait WithBaseActions
{
    protected function bulkActions(): array
    {
        return [
            BulkAction::make('Eliminar Seleccionados', function (Collection $models) {
                // dd($models);
                $models->each->delete();
            })
        ];
    }
}
