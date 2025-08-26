<section class="index-model-section">
    <div class="index-model-header">
        @include('partials.model-heading', ['actions' => false, 'title' => $pageTitle, 'subtitle' => $pageDescription])
        {{-- @livewire('business.agents.agents-table') --}}
        @livewire('business.agents.new-agents-table')
    </div>
    <div class="index-model-actions">
        <flux:modal.trigger name="{{ $primaryModalName }}">
            <flux:button icon="plus" variant="primary" @click="$dispatch('unable-edit-for-create-agent-modal')">
                {{ $primaryBtnLabel }}
            </flux:button>
        </flux:modal.trigger>
        <flux:button variant="ghost">Ultimas llamadas</flux:button>
        <flux:button variant="ghost">Ir a mi perfil</flux:button>
    </div>
</section>
