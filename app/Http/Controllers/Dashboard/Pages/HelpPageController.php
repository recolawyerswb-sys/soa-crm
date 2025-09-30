<?php

namespace App\Http\Controllers\Dashboard\Pages;

use App\Data\Pages\Dashboard\Help as DashboardHelp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Helpers\Help;

class HelpPageController extends Controller
{
    public function show()
    {
        // El contenido de la guía vive aquí.
        // Para añadir una nueva sección, solo copia y pega un bloque.
        // Para añadir contenido a una sección, añade un elemento al array 'content'.
        $help = new DashboardHelp();
        return Inertia::render('Dashboard/Help/Index', [
            'sections' => $help->getSections(),
        ]);
    }
}
