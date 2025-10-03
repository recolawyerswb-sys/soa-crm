<section class="index-model-section bg-shape-dots">
    <div class="index-model-header">
        @include('partials.model-heading', ['actions' => false, 'title' => $pageTitle, 'subtitle' => $pageDescription])
        @livewire('business.assignments.new-assignments-table')
    </div>
    <div class="index-model-actions">
        <!-- Trigger for creating a new client. MODAL. Only change the name -->
        @role('admin')
            <flux:modal.trigger name="{{ $primaryModalName }}">
                <flux:button icon="plus" variant="primary" @click="$dispatch('unable-edit-for-create-assignment-modal')">
                    {{ $primaryBtnLabel }}
                </flux:button>
            </flux:modal.trigger>
        @endrole
        <flux:button variant="ghost">Ir a clientes</flux:button>
    </div>
</section>
