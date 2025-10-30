<section class="index-model-section bg-shape-dots">
    <div class="index-model-header">
        <div class="flex w-full justify-end">
            <button wire:click='create'>Crear cliente</button>
        </div>
        @include('partials.model-heading', [
            'actions' => false,
            'title' => $pageTitle,
            'subtitle' => $pageDescription,
        ])
        {{-- @livewire('business.customers.customers-table') --}}
        @livewire('testing.fixed-customers-table')
        <x-soa-crm.soa-modal livewireModel="showModal">
            @if($showModal)
                <livewire:business.customers.create-client-modal-form
                    id="3"
                    lazy
                />
            @endif
        </x-soa-crm.soa-modal>
    </div>
</section>

