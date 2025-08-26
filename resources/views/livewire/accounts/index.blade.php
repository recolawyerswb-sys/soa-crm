<section class="index-model-section">
    <div class="index-model-header">
        @include('partials.model-heading', ['actions' => false, 'title' => $pageTitle, 'subtitle' => $pageDescription])
        @livewire('accounts.wallet.new-wallet-table')
    </div>
    <div class="index-model-actions">
        <flux:button variant="primary" href="{{ route('wallet.movements.index') }}">
            Ir a movimientos
        </flux:button>
        <flux:button variant="ghost" href="{{ route('business.customers.index') }}">Ir a clientes</flux:button>
    </div>
</section>
