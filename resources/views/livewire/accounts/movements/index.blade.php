<?php

use Livewire\Volt\Component;
use function Livewire\Volt\{computed, state};

$authUserBalance = computed(fn () => auth()->user()->wallet->balance ?? 0);
state(['authUserCurrency' => auth()->user()->wallet->coin_currency ?? 'No existe']);
state(['authUserTotalDeposit' => auth()->user()->wallet->total_deposit ?? 0]);

?>

<section class="index-model-section bg-shape-dots">
    <div class="index-model-header">
        @include('partials.model-heading', ['actions' => false, 'title' => __('Lista de movimientos'), 'subtitle' => __('Maneja el control de las asignaciones y seguimientos')])
        <x-dashboard.stats.refresh-btn />
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mb-6">
            <x-dashboard.stats.stat
                title="Balance Total"
                description="El balance que presentas actualmente."
                content="{{ '$' . number_format($this->authUserBalance, 2) }}"
            />
            <x-dashboard.stats.stat
                title="Moneda actual"
                description="La moneda en la que tienes tu cuenta."
                :content="$this->authUserCurrency"
            />
            @role('admin|banki')
                <x-dashboard.stats.stat
                    title="Total depositado"
                    description="El balance que has ingresado en total."
                    content="{{ '$' . number_format($this->authUserTotalDeposit, 2) }}"
                />
            @endrole
        </div>
        @livewire('accounts.movements.new-movements-table')
    </div>
    <div class="index-model-actions">
        <flux:modal.trigger name="create-movement-modal">
            <flux:button icon="plus" variant="primary" @click="$dispatch('unable-edit-for-create-movement-modal')">
                Crear movimiento
            </flux:button>
        </flux:modal.trigger>
        <flux:button variant="ghost" href="{{ route('wallet.index') }}">Ir a billeteras</flux:button>
        <flux:button variant="ghost" href="{{ route('business.customers.index') }}">Ir a clientes</flux:button>
        <flux:button variant="ghost">Ayuda</flux:button>
    </div>
</section>
