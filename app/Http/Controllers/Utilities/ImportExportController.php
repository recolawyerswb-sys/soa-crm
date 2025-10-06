<?php

namespace App\Http\Controllers\Utilities;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;
use App\Http\Controllers\Controller;
use App\Imports\GenericImport;

class ImportExportController extends Controller
{
    public function export(Request $request)
    {
        $request->validate(['model' => 'required|string']);
        $modelClass = $request->model;

        if (!class_exists($modelClass)) {
            return back()->with('error', 'El modelo especificado no existe.');
        }

        $fileName = strtolower(class_basename($modelClass)) . '-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new GenericExport($modelClass), $fileName);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,txt',
            'model' => 'required|string',
        ]);

        $modelClass = $request->model;

        $sessionMsg = '';

        if (!class_exists($modelClass)) {
            return back()->with('error', 'El modelo especificado no existe.');
        }

        try {
            Excel::import(new GenericImport($modelClass), $request->file('file'));
            $sessionMsg = '¡Datos importados correctamente!';
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errorMessages = [];
            foreach ($failures as $failure) {
                $row = $failure->row();
                $attribute = $failure->attribute();
                foreach ($failure->errors() as $error) {
                    $errorMessages[] = "Fila {$row}, columna '{$attribute}': {$error}";
                }
            }

            $sessionMsg = implode(' | ', $errorMessages);
        }

        return redirect(route('business.customers.index'))->with('success', $sessionMsg);
    }
}
