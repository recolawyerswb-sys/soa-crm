<?php

namespace App\Livewire\Forms\Business\Assignments;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MasiveAssignForm extends Form
{
    #[Validate('required|string|max:255')]
    public $agent_id = '';

    public function save()
    {
        $this->validate();

        // ¡Funciona desde un controlador!
        // Notify::make(
        //     label: '¡Controlador Funcionando!',
        //     message: 'El post fue creado exitosamente.',
        //     status: 'info'
        // );

        DB::transaction(function () {
            //
        });

        $this->reset();
    }
}
