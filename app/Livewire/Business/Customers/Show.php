<?php

namespace App\Livewire\Business\Customers;

use App\Models\Customer;
use Livewire\Component;

class Show extends Component
{
     // Propiedad pública para almacenar la instancia del cliente
    public Customer $customer;

    /**
     * El método mount() se ejecuta cuando el componente se inicializa.
     * Gracias al route-model binding de Laravel, recibimos automáticamente
     * la instancia del Customer que corresponde al ID en la URL.
     * * Cargamos las relaciones para evitar problemas de N+1 queries y tener
     * todos los datos disponibles en la vista.
     */
    public function mount(Customer $customer)
    {
        $this->customer = $customer;

        // Cargamos todas las relaciones necesarias para la vista
        $this->customer->load([
            'profile.user.wallet', // Carga el perfil, el usuario y la wallet
            'assignment.agent.profile.user' // Carga la asignación, el agente asignado, su perfil y su usuario
        ]);

        // dd($customer);
    }

    public function placeholder()
    {
        return view('livewire.placeholders.profile-skeleton');
    }

    public function render()
    {
        return view('livewire.business.customers.show');
    }
}
