<flux:dropdown class="hidden lg:block" position="bottom" align="start">
    <flux:button icon:trailing="sun" size="sm" variant="subtle">Aspecto</flux:button>
    <flux:menu class="w-auto dark:bg-dropdown-dark-bg!">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('Claro') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Oscuro') }}</flux:radio>
        </flux:radio.group>
    </flux:menu>
</flux:dropdown>
