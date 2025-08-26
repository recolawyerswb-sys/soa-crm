<div class="flex gap-2 items-center">
    <flux:dropdown>
        <flux:button size='sm' icon:trailing="ellipsis-horizontal"></flux:button>

        <flux:menu>
            <flux:menu.item icon="eye">Ver</flux:menu.item>
            <flux:menu.item icon="pencil-square">Editar</flux:menu.item>
            <flux:menu.item variant="danger" icon="trash">Eliminar</flux:menu.item>
        </flux:menu>
    </flux:dropdown>
    <a
        href="{{ route('business.customers.edit', ['id' => $model->id]) }}">
        <flux:icon.phone variant="solid" class="dark:text-blue-300 text-blue-600"></flux:icon.phone>
    </a>
</div>
