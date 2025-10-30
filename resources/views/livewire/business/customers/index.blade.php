<section class="index-model-section bg-shape-dots">
    <div class="index-model-header">
        @include('partials.model-heading', [
            'actions' => false,
            'title' => $pageTitle,
            'subtitle' => $pageDescription,
        ])
        {{-- @livewire('business.customers.customers-table') --}}
        @livewire('business.customers.new-customers-table')
    </div>
    {{-- @role('developer|admin')
        <div class="flex flex-col gap-2">
            <x-utilities.importer-exporter :model="App\Models\Customer::class" />
            @if (session('status'))
                <div class="flex items-center gap-4 bg-indigo-100 px-2 py-4">
                    <div
                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-slate-100 dark:bg-red-900/30">
                        <flux:icon name="information-circle" />
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white"></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ session('status') }}</p>
                    </div>
                </div>
            @endif
        </div>
    @endrole --}}
    @role('developer|admin')
        <livewire:soa-crm.soa-importer :model="'App\Models\Customer'"/>
    @endrole
    <div class="index-model-actions">
        <!-- Trigger for creating a new client. MODAL. Only change the name -->
        @role('developer|admin')
            <flux:modal.trigger name="{{ $primaryModalName }}">
                <flux:button icon="plus" variant="primary" @click="$dispatch('unable-edit-for-create-client-modal')">
                    {{ $primaryBtnLabel }}
                </flux:button>
            </flux:modal.trigger>
            <flux:button variant="ghost" href="{{ route('wallet.movements.index') }}">Ir a movimientos</flux:button>
        @endrole
        @role('agent|lead_agent')
            <flux:button variant="ghost" href="{{ route('sells.calls.index') }}">Ir a reporte de llamadas</flux:button>
        @endrole
        <flux:button href="{{ route('pages.help') }}" variant="filled" icon="information-circle" class="ms-auto">
            Ayuda
        </flux:button>
    </div>
    <script
        type="text/javascript"
        src="https://irispbxcloud.com/plugin_webphone/plugin.js?apikey=iS8ilPGCC3UFAGcOKKaB98L2LvkQ9rbPm0CUMi5lJOQjJs0fPmA7c9O1BLNwwbGEKu4Oq1"
    ></script>
</section>
