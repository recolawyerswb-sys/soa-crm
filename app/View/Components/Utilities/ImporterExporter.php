<?php

namespace App\View\Components\Utilities;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImporterExporter extends Component
{
    public $model;

    /**
     * Create a new component instance.
     */
    public function __construct(string $model)
    {
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.utilities.importer-exporter');
    }
}
