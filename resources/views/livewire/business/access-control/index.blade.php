<section class="index-model-section bg-shape-dots">
    <div class="index-model-header">
        @include('partials.model-heading', ['actions' => false, 'title' => $pageTitle, 'subtitle' => $pageDescription])
        @livewire('business.access-control.new-access-control-table')
    </div>
    <div class="index-model-actions">
        <flux:modal.trigger name="{{ $primaryModalName }}">
            <flux:button icon="plus" variant="primary" @click="$dispatch('unable-edit-for-create-access-control-role-modal')">
                {{ $primaryBtnLabel }}
            </flux:button>
        </flux:modal.trigger>
        <flux:button variant="ghost">Ir a usuarios</flux:button>
    </div>
</section>

