@props(['details' => []])

<div
    class="rounded-xl border border-white/30 bg-white/20 px-6 py-4 shadow backdrop-blur-lg dark:border-white/10 dark:bg-black/20">
    <div class="flex flex-col gap-6">
        {{-- WALLET DETAILS ROW --}}
        <div class="flex items-start justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-lg font-bold text-slate-800 dark:text-slate-200">Wallet ID: <span
                        class="font-normal">{{ $details['wallet_id'] }}</span></p>
                <div class="space-y-1 text-sm text-slate-500 dark:text-slate-400">
                    <p><span class="font-bold">Direccion: </span>{{ $details['address'] }}</p>
                    <p><span class="font-bold">Moneda: </span>{{ $details['coin_currency'] }}</p>
                    <p><span class="font-bold">Red: </span>{{ $details['network'] }}</p>
                    <p><span class="font-bold">Ultimo movimiento:</span>
                        {{ $details['last_movement_details']['date'] }}, ID: {{ $details['last_movement_details']['id'] }}
                    </p>
                </div>
            </div>
            <div class="flex items-center justify-center rounded-full bg-slate-200/50 p-3 dark:bg-slate-700/30">
                <flux:icon.credit-card variant="solid" />
            </div>
        </div>
        {{-- CREDIT CARD DETAILS ROW --}}
        <div class="border-t border-slate-200 pt-4 dark:border-slate-700/50">
            <div class="flex items-start justify-between gap-4">
                <div class="flex flex-col gap-2">
                    <p class="text-base font-semibold text-slate-800 dark:text-slate-200">Informacion Bancaria</p>
                    <div class="space-y-1 text-sm text-slate-500 dark:text-slate-400">
                        <p><span class="font-medium">Banco: </span> {{ $details['bank_network'] }}</p>
                        <p><span class="font-medium">Numero de cuenta: </span> {{ $details['account_number'] }}</p>
                        <p><span class="font-medium">Number:</span> **** **** **** {{ $details['card_number'] }}</p>
                        <div class="flex items-center gap-4">
                            <p><span class="font-bold">Expires:</span> {{ $details['exp_date'] }}</p>
                            <p><span class="font-bold">CVC:</span> {{ $details['cvc_code'] }}</p>
                        </div>
                    </div>
                </div>
                <div
                    class="flex items-center justify-center rounded-full bg-slate-200/50 p-3 dark:bg-slate-700/30">
                    <flux:icon.wallet variant="solid" />
                </div>
            </div>
        </div>
        {{-- ACTION BTN --}}
        <div class="max-w-sm">
            <flux:modal.trigger name="update-wallet-modal">
                <flux:button
                    variant="primary"
                    class="cursor-pointer"
                    icon:trailing="arrow-long-right"
                    @click="$dispatch('enable-edit-for-update-wallet-modal', { walletId: '{{ $this->userWallet }}' })">
                    Editar wallet
                </flux:button>
            </flux:modal.trigger>
        </div>
    </div>
</div>
