<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // Para los encabezados
use Illuminate\Support\Facades\Schema;

class GenericExport implements FromCollection, WithHeadings
{
    protected $model;
    protected $headings;

    public function __construct(string $modelClass)
    {
        $this->model = new $modelClass();

        // Obtenemos todas las columnas de la tabla del modelo
        $allColumns = Schema::getColumnListing($this->model->getTable());

        // Filtramos el array para excluir 'updated_at'
        $this->headings = array_diff($allColumns, ['updated_at']);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Seleccionamos solo las columnas que queremos exportar
        return $this->model->select($this->headings)->get();
    }

    /**
     * Define los encabezados para el archivo de exportación.
     *
     * @return array
     */
    public function headings(): array
    {
        return $this->headings;
    }
}
