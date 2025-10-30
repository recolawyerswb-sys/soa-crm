<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <div
            class="relative w-full h-auto"
            x-cloak
            x-data="{
                showRecoveryInput: @js($errors->has('recovery_code')),
                code: '',
                recovery_code: '',
                toggleInput() {
                    this.showRecoveryInput = !this.showRecoveryInput;

                    this.code = '';
                    this.recovery_code = '';

                    $dispatch('clear-2fa-auth-code');

                    $nextTick(() => {
                        this.showRecoveryInput
                            ? this.$refs.recovery_code?.focus()
                            : $dispatch('focus-2fa-auth-code');
                    });
                },
            }"
        >
            <div x-show="!showRecoveryInput">
                <x-auth-header
                    :title="__('Código de Autenticación')"
                    :description="__('Ingrese el código de autenticación proporcionado por su aplicación autenticadora.')"
                />
            </div>

            {{-- @role('developer|admin')
                <div x-show="showRecoveryInput">
                    <x-auth-header
                        :title="__('Codigo de Recuperacion')"
                        :description="__('Confirma el acceso a la plataforma usando un código de emergencia')"
                    />
                </div>
            @endrole --}}

            <form method="POST" action="{{ route('two-factor.login.store') }}">
                @csrf

                <div class="space-y-5 text-center">
                    <div x-show="!showRecoveryInput">
                        <div class="flex items-center justify-center my-5">
                            <x-input-otp
                                name="code"
                                digits="6"
                                autocomplete="one-time-code"
                                x-model="code"
                            />
                        </div>

                        @error('code')
                            <flux:text color="red">
                                {{ $message }}
                            </flux:text>
                        @enderror
                    </div>

                    <div x-show="showRecoveryInput">
                        <div class="my-5">
                            <flux:input
                                type="text"
                                name="recovery_code"
                                x-ref="recovery_code"
                                x-bind:required="showRecoveryInput"
                                autocomplete="one-time-code"
                                x-model="recovery_code"
                            />
                        </div>

                        @error('recovery_code')
                            <flux:text color="red">
                                {{ $message }}
                            </flux:text>
                        @enderror
                    </div>

                    <flux:button
                        variant="primary"
                        type="submit"
                        class="w-full"
                    >
                        {{ __('Continuar') }}
                    </flux:button>
                </div>

                {{-- @role('developer|admin')
                    <div class="mt-5 space-x-0.5 text-sm leading-5 text-center">
                        <span class="opacity-50">{{ __('También puedes') }}</span>
                        <div class="inline font-medium underline cursor-pointer opacity-80">
                            <span x-show="!showRecoveryInput" @click="toggleInput()">{{ __('Ingresar usando un código de recuperación') }}</span>
                            <span x-show="showRecoveryInput" @click="toggleInput()">{{ __('Ingresar usando un código de autenticación') }}</span>
                        </div>
                    </div>
                @endrole --}}
            </form>
        </div>
    </div>
</x-layouts.auth>
