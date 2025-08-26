<flux:modal wire:loading.class='blur-xs' name="generic-confirmation-modal" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Esta seguro de {{ $actionTitleName }}?</flux:heading>
            <flux:text class="mt-2">
                <span>
                    <p class="max-w-[48ch]">Estas a punto de realizar una accion que puede alterar el estado de la informacion de forma significativa. <b>Esta accion no se puede revertir</b></p>
                </span>
            </flux:text>
        </div>
        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Cancelar</flux:button>
            </flux:modal.close>
            <flux:button
                @click="$dispatch('{{ $actionEventName }}', {id: '{{ $targetId }}'})" class="capitalize" type="submit" variant="primary">
                {{ $actionBtnLabel }}
            </flux:button>
        </div>
    </div>
</flux:modal>
