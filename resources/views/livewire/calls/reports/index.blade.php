<section class="index-model-section bg-shape-dots">
    <div class="index-model-header">
        @include('partials.model-heading', ['actions' => false, 'title' => $pageTitle, 'subtitle' => $pageDescription])
        {{-- @livewire('business.customers.customers-table') --}}
        @livewire('calls.reports.new-call-reports-table')
    </div>
    <div class="index-model-actions">
        <flux:button variant="ghost" href="{{ route('business.customers.index') }}">Ir a clientes</flux:button>
        {{-- <flux:button variant="ghost" href="{{ route('sells.calls.index') }}">Ir a reporte de llamadas</flux:button> --}}
        <flux:button variant="filled" icon="information-circle" class="ms-auto">
            Ayuda
        </flux:button>
    </div>
</section>
