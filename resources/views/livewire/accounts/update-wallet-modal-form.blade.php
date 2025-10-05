<form class='space-y-3' wire:submit.prevent="save">
    {{-- PROFILE FIELDS --}}
    <flux:heading>{{ __('Datos de la wallet') }}</flux:heading>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <flux:select label="Moneda" wire:model="form.coin_currency">
            <option value="USDT">USDT</option>
            <option value="USDC">USDC</option>
            <option value="COP">COP</option>
        </flux:select>
        <flux:input label="Red" wire:model="form.network"/>
    </div>

    <div class="grid grid-cols-1 gap-3">
        <flux:textarea label="Dirección de la wallet" class="w-full" wire:model="form.address"/>
    </div>

    <flux:separator />
    <flux:heading>{{ __('Datos bancarios') }}</flux:heading>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <flux:input label="Red bancaria" icon="building-office" wire:model="form.bank_network"/>
        <flux:input label="Número de cuenta" icon="hashtag" wire:model="form.account_number"/>
    </div>

    <flux:separator />
    <flux:heading>{{ __('Datos de la tarjeta') }}</flux:heading>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <flux:input label="Número de tarjeta" mask="9999 9999 9999 9999" icon:trailing="credit-card" wire:model="form.card_number"/>
        <flux:input label="CVC" icon="lock-closed" mask="999" wire:model="form.cvc_code"/>
        <flux:input mask='99/99' icon="calendar-days" label="Fecha de expiracion" wire:model="form.exp_date"/>
    </div>

    @role('admin|banki')
        <flux:separator />
        <flux:heading>{{ __('Balance total') }}</flux:heading>
        <div class="grid grid-cols-1 gap-3">
            <flux:input type='number' step="0.01" label="Balance"  icon="currency-dollar" clearable wire:model="form.balance"/>
        </div>
    @endrole

    {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

    </div> --}}

    <x-dashboard.forms.footer-modal modalName="{{ $this->modalViewName }}" />
</form>
