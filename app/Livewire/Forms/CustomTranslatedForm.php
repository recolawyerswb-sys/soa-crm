<?php

namespace App\Livewire\Forms;

use Livewire\Form;

abstract class CustomTranslatedForm extends Form
{
    /**
     * Mensajes de validación personalizados en español
     */
    protected function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'El campo :attribute debe ser una dirección de correo válida.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'max' => 'El campo :attribute no debe exceder de :max caracteres.',
            'confirmed' => 'La confirmación de :attribute no coincide.',
            // agrega aquí más mensajes comunes
        ];
    }

    /**
     * Traducción de atributos que es basicamente WIRE:MODEL
     */
    protected function validationAttributes()
    {
        return [
            'full_name' => 'nombre',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            // puedes traducir más atributos aquí
        ];
    }
}
