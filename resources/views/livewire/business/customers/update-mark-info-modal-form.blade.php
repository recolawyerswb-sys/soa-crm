<div>
    {{-- ========= TABLA ========= --}}
    <h3 class="block mb-4 text-lg font-semibold">Registros seleccionados</h3>
    <div class="overflow-x-auto mb-4">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-b-zinc-700">
                    <th scope="col" class="ps-o py-2 pe-1 w-fit text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <div class="flex items-center gap-2">
                            <span>ID</span>
                        </div>
                    </th>
                    <th scope="col" class="ps-o py-2 pe-1 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        <div class="flex items-center gap-2">
                            <span>Nombre Completo</span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse ($selectedRows as $id => $name)
                    <tr class="border-b border-b-zinc-700 py-2" wire:key="row-{{ $id }}">
                        <td class="py-2 ps-0 pe-1 whitespace-nowrap text-sm text-slate-200">
                            <span class="text-left">
                                {{ $id }}
                            </span>
                        </td>
                        <td class="py-2 ps-0 pe-1 whitespace-nowrap text-sm text-slate-200">
                            <span class="text-left">
                                {{ $name }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="py-12 text-center text-slate-500">
                            No se encontraron resultados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <form class='space-y-3' wire:submit.prevent="save">
        {{-- ASSIGNMENT FIELDS --}}
        <flux:heading>{{ __('Datos nuevos') }}</flux:heading>
        {{-- <flux:callout icon="chat-bubble-bottom-center-text">
            <flux:callout.heading>Importante antes de asignar</flux:callout.heading>
            <flux:callout.text>
                Si desea que el sistema auto-asigne el asesor por defecto a este cliente, deje en blanco los campos de abajo.
                De lo contrario, puede asignar un asesor específico.
            </flux:callout.text>
        </flux:callout> --}}

        {{-- CUSTOMER FIELDS --}}
        <flux:heading>{{ __('Datos de marketing y seguimientos') }}</flux:heading>
        <div class="grid grid-cols-1 gap-3">
            {{-- <flux:input label="Fuente" wire:model="source"/> --}}
            <flux:select label="Fase" wire:model="phase" placeholder="Elije la fase...">
            @foreach ($phases as $phase)
                <flux:select.option value="{{ $phase }}">{{ $phase }}</flux:select.option>
            @endforeach
            </flux:select>
            <flux:select label="Origen" wire:model="origin" placeholder="Elije el origen...">
            @foreach ($origins as $origin)
                <flux:select.option value="{{ $origin }}">{{ $origin }}</flux:select.option>
            @endforeach
            </flux:select>
            <flux:select label="Estado" wire:model="status" placeholder="Elije el estado...">
            @foreach ($statuses as $status)
                <flux:select.option value="{{ $status }}">{{ $status }}</flux:select.option>
            @endforeach
            </flux:select>
        </div>
        <x-dashboard.forms.footer-modal modalName="{{ $this->modalViewName }}" />
    </form>
</div>


