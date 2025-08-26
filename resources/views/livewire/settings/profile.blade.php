<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $role = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->role = Auth::user()->getCurrentRole(); // Default to 'cliente' if no role is assigned
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],

            'role' => ['string'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->syncRoles($validated['role'] ?? 'admin');

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    @include('partials.model-heading', [ 'title' => __('Perfil y usuario de la cuenta'), 'subtitle' => __('Actualiza tus datos de inicio de sesion y personales.')])

    <x-settings.layout>
        <flux:heading>{{ __('Usuario publico') }}</flux:heading>

        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model="name" :label="__('Nombre')" type="text" required autofocus autocomplete="name" />
                <flux:input wire:model="name" :label="__('Nombre')" type="text" required autofocus autocomplete="name" />
                <flux:input wire:model="email" :label="__('Correo electrónico')" type="email" autocomplete="email" />
                <flux:input wire:model="phone" :label="__('Teléfono')" type="text" autocomplete="tel" />
                <flux:input wire:model="country" :label="__('País')" type="text" autocomplete="country" />
                <flux:input wire:model="city" :label="__('Ciudad')" type="text" autocomplete="address-level2" />
                <flux:input wire:model="address" :label="__('Dirección')" type="text" autocomplete="street-address" />
                <flux:input wire:model="phase" :label="__('Fase')" type="text" />
                <flux:input wire:model="origin" :label="__('Origen')" type="text" />
                <flux:input wire:model="status" :label="__('Estado')" type="text" />
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Guardar') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Guardado!') }}
                </x-action-message>
            </div>
        </form>

        {{-- UPDATE USER FORM --}}
        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
