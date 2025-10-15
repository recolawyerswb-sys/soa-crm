<?php

use App\Models\User;
use App\Models\Agent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $userName = '';
    public string $fullName = '';
    public string $email = '';
    public string $password = '';
    public string $country = '';
    public string $phone_1 = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'userName' => ['required', 'string', 'max:255'],
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'country' => ['required', 'string', 'max:255'],
            'phone_1' => ['required', 'string', 'max:255'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $assignedAgentId = Agent::whereHas('profile', function ($query) {
            $query->where('full_name', 'crm');
        })->first()->id;

        event(new Registered(($user = User::create([
            'name' => $validated['userName'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]))));

        $user->assignRole('customer');

        // 3. Crear perfil relacionado
        $profile = $user->profile()->create([
            'full_name' => $validated['fullName'],
            'country' => $validated['country'],
            'phone_1' => $validated['phone_1'],
        ]);

        // 3.1. Crear cliente relacionado con el perfil
        $customer = $profile->customer()->create([
            'type' => 'lead',
            'status' => 'new',
            'origin' => 'web',
            'phase' => 'activo',
        ]);

        // 4. Crear una asignacion para el cliente
        $customer->assignment()->create([
            'agent_id' => $assignedAgentId,
            'notes' => 'Asignado al registrar',
            'status' => '1', // Asignado
        ]);

        // 5. Crear wallet relacionada
        $user->wallet()->create([
            'coin_currency' => 'USDT',
            'address' => '',
            'network' => 'TRC20',
        ]);

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Crear una cuenta')" :description="__('Ingresa tus datos a continuación para crear tu cuenta')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <!-- Full Name -->
            <flux:input
                wire:model="fullName"
                :label="__('Nombre Completo')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Jhon Doe')"
            />

            <!-- Name -->
            <flux:input
                wire:model="userName"
                :label="__('Usuario')"
                type="text"
                required
                autocomplete="username"
                :placeholder="__('jhondoe1232')"
            />
        </div>

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Correo electrónico')"
            type="email"
            required
            autocomplete="email"
            placeholder="correo@ejemplo.com"
        />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <!-- Country -->
            <flux:input
                wire:model="country"
                :label="__('Pais')"
                type="text"
                required
                autocomplete="country"
                placeholder="Mexico"
            />

            <!-- Phone 1 -->
            <flux:input
                wire:model="phone_1"
                :label="__('Telefono celular')"
                type="text"
                required
                autocomplete="phone"
                placeholder="+573117772652"
            />
        </div>


        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Contraseña')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Contraseña')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirmar contraseña')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirmar contraseña')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Crear cuenta') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('¿Ya tienes una cuenta?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Iniciar sesión') }}</flux:link>
    </div>
</div>
