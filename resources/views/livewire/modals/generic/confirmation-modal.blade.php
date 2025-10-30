<flux:modal name="generic-confirmation-modal" class="min-w-[22rem]">
    <div class="space-y-6">
        <div class="flex flex-col gap-3">
            <div class="flex flex-col gap-2">
                <flux:heading size="lg">Esta seguro de {{ $actionTitleName }}?</flux:heading>
                <flux:text class="max-w-[48ch]">Estas a punto de realizar una accion que puede alterar el estado de la informacion de forma significativa. <b>Esta accion no se puede revertir</b></flux:text>
                <flux:callout icon="chat-bubble-bottom-center-text">
                    <flux:callout.heading>Asegurese de esperar un segundo antes de hacer click en "aprobar"</flux:callout.heading>
                    <flux:callout.text>
                        Como todo sistema, es importante dejar pasar un tiempo antes de hacer click en cualquier accion. Asegurese de esperar <b>1 segundo</b> antes de hacer click en el boton de Aprobar/Rechazar
                    </flux:callout.text>
                </flux:callout>
            </div>

            @if ($actionEnableNote)
                <div class="flex flex-col gap-1">
                    <flux:textarea placeholder="Notas generales" wire:model.live.debounce.750ms="note"/>
                </div>
            @endif
        </div>
        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Cancelar</flux:button>
            </flux:modal.close>
            <flux:button
                @click="$dispatch('{{ $actionEventName }}', {id: '{{ $targetId }}', note: '{{ $this->note }}'})"
                class="capitalize cursor-pointer"
                variant="primary">
                {{ $actionBtnLabel }}
            </flux:button>
        </div>
    </div>
</flux:modal>
