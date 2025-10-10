<flux:modal
    :dismissible="false"
    :closable="false"
    name="init-call"
    class="md:w-[800px] max-w-none"
>
    <div class="space-y-6">
        {{-- Modal body --}}
        <livewire:sells.calls.init-call-form lazy>
    </div>
</flux:modal>
