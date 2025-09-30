<div>
    {{-- ✅ Envolvemos la sección dinámica en un div con wire:ignore --}}
    <div>
        <div class="w-full py-2 flex justify-between items-center">
            <div class="w-auto">
                {{-- Título inicial que se ocultará --}}
                <h2 class="text-2xl" id="loading-title">
                    Llamar a <span class="font-bold">{{ $this->full_name }}</span>
                </h2>

                {{-- Título y duración que se mostrarán durante la llamada --}}
                <div id="call-in-progress-title" class="hidden">
                    <h2 class="text-2xl">
                        Llamando a <span class="font-bold">{{ $this->full_name }}</span>
                    </h2>
                    {{-- ✅ Duración y estado de la llamada --}}
                    <div class="text-sm text-gray-500 font-mono flex items-center gap-2">
                        <span id="call-status">Inicializando...</span>
                        <span>-</span>
                        <span id="call-duration">00:00</span>
                    </div>
                </div>
            </div>

            {{-- INFO BASICA CLIENTE --}}
            <div class="flex-1 flex gap-2 justify-end">
                <flux:badge variant="solid" color="indigo">{{ $this->country }}</flux:badge>
                <flux:badge variant="solid" color="yellow">{{ $this->status }}</flux:badge>
                <flux:badge variant="solid" color="green">${{ $this->balance }} </flux:badge>
            </div>
        </div>
    </div>

    <div class="py-4 flex flex-col gap-3">
        {{-- NOTAS --}}
        <div class="grid grid-cols-1 md:grid-cols-1">
            <flux:textarea label="Notas" wire:model="form.notes"/>
        </div>
        {{-- ESTADO, FASE --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:select label="Estado" description:trailing="Seleccione el nuevo estado del cliente" wire:model="form.status" placeholder="Elije el estado...">
            @foreach ($this->statuses as $status)
                <flux:select.option value="{{ $status }}">{{ $status }}</flux:select.option>
            @endforeach
            </flux:select>
            <flux:select label="Fase" description:trailing="Seleccione la nueva fase a la que avanza el cliente" wire:model="form.phase" placeholder="Elije la fase...">
            @foreach ($this->phases as $phase)
                <flux:select.option value="{{ $phase }}">{{ $phase }}</flux:select.option>
            @endforeach
            </flux:select>
        </div>
    </div>

    <div class="flex">
        <flux:button color='zinc' id="close-btn" x-on:click="$flux.modal('init-call').close()">
            Cerrar
        </flux:button>
        <flux:spacer />
        <div class="flex gap-2">
            {{-- ✅ Botón para iniciar llamada, llama a JS con el ID del cliente --}}
            <flux:button id="start-call-btn" variant="primary" data-customer-id="{{ $this->customerId }}">
                Iniciar llamada
            </flux:button>
            {{-- ✅ Botón para colgar, llama a la función hangup() --}}
            <flux:button id="end-call-btn" variant="danger" class="hidden">
                Colgar
            </flux:button>
        </div>
    </div>
</div>
