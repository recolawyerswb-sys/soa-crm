@php
    $options = [];
@endphp

<div>
    {{-- TODO TU CÓDIGO ACTUAL DEL SELECT (BUSCABLE O NO) VA AQUÍ --}}
    @if($isSearchable ?? null)

        <div class="relative">
            <input type="hidden" name="{{ $inputName ?? null }}" value="{{ $selectedId ?? null }}">
            <input
                type="text"
                wire:model.debounce.300ms="search"
                placeholder="Escribe para buscar..."
                class="w-full px-4 py-2 bg-white border border-slate-300 rounded-md text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-200 dark:placeholder-slate-400"
                autocomplete="off"
            >
            @if($showDropdown ?? null && !$options->isEmpty())
                <ul class="absolute z-10 w-full mt-1 bg-white border border-slate-300 rounded-md shadow-lg max-h-60 overflow-auto text-slate-900 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-200">
                    @foreach($options as $option)
                        <li
                            wire:click="selectItem({{ $option->id }})"
                            class="px-4 py-2 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-600"
                        >
                            {{ $option->{$displayColumn} }}
                        </li>
                    @endforeach
                </ul>
            @elseif($showDropdown ?? null && $options->isEmpty() && !empty($search))
                <div class="absolute z-10 w-full mt-1 px-4 py-2 bg-white border border-slate-300 rounded-md shadow-lg text-slate-500 dark:bg-slate-700 dark:border-slate-600 dark:text-slate-400">
                    No se encontraron resultados.
                </div>
            @endif
        </div>

    @else

        <div>
            <select
                wire:model="selectedId"
                name="{{ $inputName ?? null }}"
                class="w-full px-4 py-2 bg-white border border-slate-300 rounded-md text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-600 dark:text-slate-200"
            >
                <option value="">-- Selecciona una opción --</option>
                @foreach($options as $option)
                    <option value="{{ $option->id }}">
                        {{ $option->{$displayColumn} }}
                    </option>
                @endforeach
            </select>
        </div>

    @endif
</div>
