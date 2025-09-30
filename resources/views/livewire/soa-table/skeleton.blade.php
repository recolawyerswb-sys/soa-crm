<div class="table-bg text-slate-600 dark:text-slate-400 p-4 sm:p-6 rounded-lg">

    {{-- INICIO: CONTROLES DE ACCIONES MASIVAS --}}
    @if(count($selectedRows) > 0 && count($this->bulkActions()) > 0)
    <div class="mb-3 flex justify-between items-center">
        <div class="flex flex-col gap-2">
            <span class="text-xs font-semibold dark:text-slate-400 text-slate-600">{{ count($selectedRows) }} filas seleccionadas</span>
            <div class="flex gap-2">
                <flux:select size='xs' placeholder="Seleccione una opcion..." wire:model.live="activeBulkAction">
                    @foreach($this->bulkActions() as $action)
                        <option value="{{ $action->label }}">{{ $action->label }}</option>
                    @endforeach
                </flux:select>
                <flux:button wire:click="runBulkAction" size="xs" variant="primary">
                    Ejecutar
                </flux:button>
            </div>
        </div>
    </div>
    @endif
    {{-- FIN: CONTROLES DE ACCIONES MASIVAS --}}

    <div class="flex sm:flex-row flex-col sm:justify-between w-full">
        {{-- REFRESH BUTTON --}}
        <div class="flex mb-6 items-center gap-2 w-fit">
            {{-- ========= INICIO: BOTÓN DE REFRESCO ========= --}}
            <x-table.refresh-btn />
            {{-- ========= FIN: BOTÓN DE REFRESCO ========= --}}
        </div>

        {{-- ========= INICIO: SECCIÓN DE FILTROS PERSONALIZADOS ========= --}}
        @if(count($this->filters()) > 0)
        <div class="w-full mb-6 flex flex-wrap justify-end items-center gap-x-3 gap-y-4 py-2">
            <flux:icon.adjustments-vertical variant="solid" />
            @foreach($this->filters() as $filter)
                <div class="flex items-center gap-2">
                    <label for="filter-{{ $filter->key }}" class="text-sm font-semibold dark:text-slate-200 text-slate-600">{{ $filter->label }}: </label>

                    {{-- >> INICIO: RENDERIZADO CONDICIONAL << --}}
                    @if($filter->type === 'input')
                        <flux:input
                            id="filter-{{ $filter->key }}"
                            type="text"
                            size="xs"
                            wire:model.live.debounce.300ms="activeFilters.{{ $filter->key }}"
                            placeholder="Escribe el valor..."
                        />
                    @else
                        <div class="flex items-center gap-2">
                            <flux:dropdown position="bottom">
                                <flux:button
                                    size='xs'
                                    variant="subtle"
                                    class="border dark:border-slate-400 border-slate-600"
                                    icon:trailing="ellipsis-horizontal"></flux:button>
                                <flux:menu class="">
                                @foreach($filter->options as $value => $label)
                                        <flux:menu.item
                                            wire:click="setFilter('{{ $filter->key }}', '{{ $value }}')"
                                            class="px-3 py-1  text-xs rounded-full
                                            {{ (isset($activeFilters[$filter->key]) && $activeFilters[$filter->key] == $value)
                                                ? 'bg-indigo-500! text-white! font-semibold'
                                                : 'dark:text-white/80! text-slate-400' }}">
                                                {{ $label }}
                                        </flux:menu.item>
                                @endforeach
                            </flux:menu>
                        </flux:dropdown>
                        </div>
                    @endif
                    {{-- >> FIN: RENDERIZADO CONDICIONAL << --}}
                </div>
            @endforeach
        </div>
        @endif
        {{-- ========= FIN: SECCIÓN DE FILTROS PERSONALIZADOS ========= --}}
    </div>

    {{-- ========= SECCIÓN DE CABECERA Y FILTROS ========= --}}
    <div class="flex flex-col sm:flex-row sm:justify-end sm:items-center flex-1 gap-3 mb-6 w-full">
        {{-- Contenedor de Controles: Búsqueda y Paginación --}}
        @if ($enableSearch)
            <div class="flex flex-row items-center gap-3 w-full sm:w-1/4 sm:me-auto">
                <div class="flex flex-col md:flex-row w-full h-full justify-between items-center">
                    <div class="relative text-gray-600 focus-within:text-gray-400 w-full">
                        <flux:input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            placeholder="Buscar..."
                            autocomplete="off"
                            size="sm"
                            icon="magnifying-glass"
                        />
                    </div>
                </div>
            </div>
        @endif

        {{-- TIME FILTERS --}}
        <div class="flex items-center gap-2 dark:bg-slate-800 bg-slate-100 p-1 rounded-lg md:h-fit w-full sm:w-auto">
            @php
                $filters = ['all' => 'Todos', '1d' => '1D', '1w' => '1W', '1m' => '1M', '1y' => '1Y'];
            @endphp
            @foreach ($filters as $key => $label)
                <button
                    wire:click="setTimeFilter('{{ $key }}')"
                    class="px-4 py-1 text-sm rounded-md transition-colors {{ $timeFilter === $key ? 'bg-indigo-600 text-white' : 'dark:text-slate-400 text-slate-600 hover:text-indigo-500' }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Paginación Minimalista --}}
        @if ($rows->hasPages())
            <div class="flex justify-end sm:justify-start items-center sm:w-auto gap-2 text-sm text-slate-300">
                <span class="text-slate-600 dark:text-slate-300 font-semibold">{{ $rows->firstItem() }} - {{ $rows->lastItem() }} de {{ $rows->total() }}</span>
                <div class="flex gap-1">
                    <button wire:click="previousPage" @if ($rows->onFirstPage()) disabled @endif class="p-1 rounded-md bg-slate-700 hover:bg-slate-800 disabled:opacity-50">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button wire:click="nextPage" @if (!$rows->hasMorePages()) disabled @endif class="p-1 rounded-md bg-slate-700 hover:bg-slate-800 disabled:opacity-50">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
            </div>
        @endif
    </div>

    {{-- ========= INDICADOR DE CARGA ========= --}}
    <div class="relative">
        <div wire:loading.flex class="absolute inset-0 w-full h-full dark:bg-slate-900/50 bg-slate-100/50 backdrop-blur-md flex items-center justify-center z-10">
            <svg class="animate-spin h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>

        {{-- ========= TABLA ========= --}}
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr>
                        @if (count($actions) > 0)
                            <th scope="col" class="ps-o pe-4 text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Acciones</th>
                        @endif
                        <th class="p-4 w-4">
                            <input type="checkbox" wire:model.live="selectAll"
                                class="rounded border-slate-500 bg-slate-700 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        @foreach ($columns as $column)
                            @if (is_null($column->canSee) || call_user_func($column->canSee))
                                <th scope="col" class="ps-o pe-4 text-left text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider
                                    @if ($column->sortable) cursor-pointer @endif"
                                    @if ($column->sortable) wire:click="sortBy('{{ $column->field }}')" @endif>
                                    <div class="flex items-center gap-2">
                                        <span>{{ $column->label }}</span>
                                        @if ($sortField === $column->field)
                                            <span>@if ($sortDirection === 'asc') &#9650; @else &#9660; @endif</span>
                                        @endif
                                    </div>
                                </th>
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-300 dark:divide-slate-600">
                    @forelse ($rows as $row)
                        <tr wire:key="row-{{ $row->id }}" class="{{ in_array($row->id, $selectedRows) ? 'bg-slate-800' : '' }} hover:bg-slate-700/50">
                            @if (count($actions) > 0)
                                <td class="py-4 text-left text-sm whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <flux:dropdown>
                                            <flux:button icon:trailing="chevron-down" size="sm"></flux:button>
                                            <flux:menu>
                                                @foreach ($actions as $action)
                                                    @if (is_null($action->canSee) || call_user_func($action->canSee, $row))
                                                    <flux:menu.item
                                                        wire:click="callAction('{{ $action->method }}', '{{ $row->id }}')"
                                                        icon="{{ $action->icon }}"
                                                        class="cursor-pointer">
                                                            {{ $action->label }}
                                                    </flux:menu.item>
                                                    @endif
                                                @endforeach
                                            </flux:menu>
                                        </flux:dropdown>
                                    </div>
                                </td>
                            @endif
                            <td class="p-4">
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $row->id }}"
                                    class="rounded border-slate-500 bg-slate-700 text-indigo-600 focus:ring-indigo-500">
                            </td>
                            @foreach ($columns as $column)
                                @if (is_null($column->canSee) || call_user_func($column->canSee))
                                    <td class="py-4 ps-0 pe-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-200 {{ $column->classes }}">
                                        @if ($column->isView)
                                            @include($column->field, ['row' => $row])
                                        @else
                                            @if ($column->formatCallback)
                                                {{-- Lógica personalizada de formato --}}
                                                {!! call_user_func($column->formatCallback, $value, $row) !!}
                                            {{-- ========= INICIO: LÓGICA DE FORMATO ========= --}}
                                            @elseif ($column->isCurrency)
                                                <span class="font-mono text-left">{{ $column->currencySymbol }}{{ number_format(data_get($row, $column->field), $column->currencyDecimals) }}</span>
                                            @elseif ($column->isDate)
                                                {{ \Carbon\Carbon::parse(data_get($row, $column->field))->format($column->dateFormat) }}
                                            @else
                                                <span class="text-left">
                                                    {!! data_get($row, $column->field) !!}
                                                </span>
                                            @endif
                                            {{-- ========= FIN: LÓGICA DE FORMATO ========= --}}
                                        @endif
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + (count($actions) > 0 ? 1 : 0) }}" class="py-12 text-center text-slate-500">
                                No se encontraron resultados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
