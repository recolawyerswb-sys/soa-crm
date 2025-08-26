<?php

use Livewire\Volt\Component;
use function Livewire\Volt\{computed, state};

$authUserBalance = computed(fn () => auth()->user()->wallet->balance);
state(['authUserCurrency' => auth()->user()->wallet->coin_currency]);

?>

<section class="index-model-section">
    <div class="index-model-header">
        @include('partials.model-heading', ['actions' => false, 'title' => __('Lista de movimientos'), 'subtitle' => __('Maneja el control de las asignaciones y seguimientos')])
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="w-full sm:w-1/3">
                <x-dashboard.stat
                    title="Balance Total"
                    description="El balance que presentas actualment."
                >
                    {{-- Data: sum(movimientos where status='pendiente') --}}
                    <span class="text-white" wire:poll.10s>
                        ${{ $this->authUserBalance }}
                    </span>
                </x-dashboard.stat>
            </div>
            <div class="w-full sm:w-1/3">
                <x-dashboard.stat
                    title="Moneda actual"
                    description="El balance que presentas actualment."
                >
                    {{-- Data: sum(movimientos where status='pendiente') --}}
                    <span class="text-white">
                        {{ $this->authUserCurrency }}
                    </span>
                </x-dashboard.stat>
            </div>
            <div class="w-full sm:w-1/3">
                <!-- Column 3 content -->
            </div>
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
