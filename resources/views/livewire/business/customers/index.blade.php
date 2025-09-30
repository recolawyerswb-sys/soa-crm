<section class="index-model-section bg-shape-dots">
    <div class="index-model-header">
        @include('partials.model-heading', ['actions' => false, 'title' => $pageTitle, 'subtitle' => $pageDescription])
        {{-- @livewire('business.customers.customers-table') --}}
        @livewire('business.customers.new-customers-table')
    </div>
    <div class="index-model-actions">
        <!-- Trigger for creating a new client. MODAL. Only change the name -->
        <flux:modal.trigger name="{{ $primaryModalName }}">
            <flux:button icon="plus" variant="primary" @click="$dispatch('unable-edit-for-create-client-modal')">
                {{ $primaryBtnLabel }}
            </flux:button>
        </flux:modal.trigger>
        <flux:button variant="ghost" href="{{ route('wallet.movements.index') }}">Ir a movimientos</flux:button>
        {{-- <flux:button variant="ghost" href="{{ route('sells.calls.index') }}">Ir a reporte de llamadas</flux:button> --}}
        <flux:button href="{{ route('pages.help') }}" variant="filled" icon="information-circle" class="ms-auto">
            Ayuda
        </flux:button>
    </div>
</section>
