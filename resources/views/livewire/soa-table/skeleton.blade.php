<div class="bg-zinc-900 text-slate-300 p-4 sm:p-6 rounded-lg">

    {{-- INICIO: CONTROLES DE ACCIONES MASIVAS --}}
    @if(count($selectedRows) > 0 && count($this->bulkActions()) > 0)
    <div class="mb-6 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <select wire:model.live="activeBulkAction"
                    class="px-2 py-1 text-xs bg-zinc-800 focus:outline-none focus:bg-zinc-700 focus:text-gray-100 transition-colors duration-200">
                <option value="">Acción Masiva...</option>
                @foreach($this->bulkActions() as $action)
                    <option value="{{ $action->label }}">{{ $action->label }}</option>
                @endforeach
            </select>
            <button wire:click="runBulkAction"
                    class="px-3 py-1 text-xs rounded-md bg-indigo-600 hover:bg-indigo-500 text-white font-semibold">
                Ejecutar
            </button>
            <span class="text-xs text-slate-400">{{ count($selectedRows) }} filas seleccionadas</span>
        </div>
        {{-- FIN: CONTROLES DE ACCIONES MASIVAS --}}
    </div>
    @endif

    <div class="flex sm:flex-row flex-col sm:justify-between w-full">
        {{-- REFRESH BUTTON --}}
        <div class="flex mb-6 items-center gap-2 w-fit">
            {{-- ========= INICIO: BOTÓN DE REFRESCO ========= --}}
            <flux:button wire:click="refreshTable" title="Recargar tabla" icon='arrow-path' variant='primary' color='zinc'>
                Refrescar
                {{-- Icono que se muestra mientras carga --}}
                <svg class="h-5 w-5 animate-spin" wire:loading wire:target="refreshTable" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </flux:button>
            {{-- ========= FIN: BOTÓN DE REFRESCO ========= --}}
        </div>

        {{-- ========= INICIO: SECCIÓN DE FILTROS PERSONALIZADOS ========= --}}
        @if(count($this->filters()) > 0)
        <div class="mb-6 flex flex-wrap items-center gap-x-3 gap-y-4 py-2">
            <flux:icon.funnel></flux:icon.funnel>
            @foreach($this->filters() as $filter)
                <div class="flex items-center gap-2">
                    <label for="filter-{{ $filter->key }}" class="font-medium text-slate-200">{{ $filter->label }} - </label>

                    {{-- >> INICIO: RENDERIZADO CONDICIONAL << --}}
                    @if($filter->type === 'input')
                        <input
                            id="filter-{{ $filter->key }}"
                            type="text"
                            wire:model.live.debounce.300ms="activeFilters.{{ $filter->key }}"
                            class="px-2 py-1 text-xs bg-zinc-800 focus:outline-none focus:bg-zinc-700 focus:text-gray-100 transition-colors duration-200"
                            placeholder="Introduce el {{ strtolower($filter->label) }}..."
                        >
                    @else
                        <div class="flex items-center gap-2">
                            <flux:dropdown position="bottom">
                                <flux:button
                                    size='sm'
                                    class="bg-zinc-800! border-none"
                                    icon:trailing="ellipsis-horizontal"></flux:button>
                                <flux:menu class="bg-zinc-800!">
                                @foreach($filter->options as $value => $label)
                                        <flux:menu.item
                                            wire:click="setFilter('{{ $filter->key }}', '{{ $value }}')"
                                            class="px-3 py-1 bg-zinc-800 text-xs rounded-full transition-colors
                                            {{ (isset($activeFilters[$filter->key]) && $activeFilters[$filter->key] == $value)
                                                ? 'bg-indigo-500! text-white font-semibold'
                                                : 'bg-zinc-700 hover:bg-zinc-800 text-slate-300' }}" wire::>{{ $label }}</flux:menu.item>
                                    {{-- <button
                                    wire:click="setFilter('{{ $filter->key }}', '{{ $value }}')"
                                    class="px-3 py-1 text-xs rounded-full transition-colors
                                    {{ (isset($activeFilters[$filter->key]) && $activeFilters[$filter->key] == $value)
                                    ? 'bg-indigo-500 text-white font-semibold'
                                    : 'bg-slate-700/50 hover:bg-slate-700 text-slate-300' }}"
                                    >
                                    {{ $label }}
                                </button> --}}
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
        <div class="flex flex-row items-center gap-3 w-full sm:w-1/4 sm:me-auto">
            <div class="flex flex-col md:flex-row w-full h-full justify-between items-center">
                <div class="relative text-gray-600 focus-within:text-gray-400 w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </span>
                    <input
                        wire:model.live.debounce.300ms="search"
                        type="text"
                        placeholder="Buscar..."
                        autocomplete="off"
                        class="py-2 w-full text-sm text-white bg-zinc-800 rounded-md pl-10 h-full focus:outline-none focus:bg-zinc-700 focus:text-gray-100 transition-colors duration-200"
                    >
                </div>
            </div>
        </div>

        {{-- TIME FILTERS --}}
        <div class="flex items-center gap-2 bg-zinc-800 p-1 rounded-lg md:h-fit w-full sm:w-auto">
            @php
                $filters = ['all' => 'All', '1d' => '1D', '1w' => '1W', '1m' => '1M', '1y' => '1Y'];
            @endphp
            @foreach ($filters as $key => $label)
                <button
                    wire:click="setTimeFilter('{{ $key }}')"
                    class="px-4 py-1 text-sm rounded-md transition-colors {{ $timeFilter === $key ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-white' }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Paginación Minimalista --}}
        @if ($rows->hasPages())
            <div class="flex justify-end sm:justify-start items-center sm:w-auto gap-2 text-sm text-slate-400">
                <span>{{ $rows->firstItem() }} - {{ $rows->lastItem() }} of {{ $rows->total() }}</span>
                <div class="flex gap-1">
                    <button wire:click="previousPage" @if ($rows->onFirstPage()) disabled @endif class="p-1 rounded-md bg-slate-800 hover:bg-slate-700 disabled:opacity-50">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button wire:click="nextPage" @if (!$rows->hasMorePages()) disabled @endif class="p-1 rounded-md bg-slate-800 hover:bg-slate-700 disabled:opacity-50">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
            </div>
        @endif
    </div>

    {{-- ========= INDICADOR DE CARGA ========= --}}
    <div class="relative">
        <div wire:loading.flex class="absolute inset-0 w-full h-full bg-zinc-900/75 backdrop-blur-md flex items-center justify-center z-10">
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
                            <th scope="col" class="ps-o pe-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Acciones</th>
                        @endif
                        <th class="p-4 w-4">
                            <input type="checkbox" wire:model.live="selectAll"
                                class="rounded border-slate-500 bg-slate-700 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        @foreach ($columns as $column)
                            @if (is_null($column->canSee) || call_user_func($column->canSee))
                                <th scope="col" class="ps-o pe-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider
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
                <tbody class="divide-y divide-slate-800">
                    @forelse ($rows as $row)
                        <tr wire:key="row-{{ $row->id }}" class="{{ in_array($row->id, $selectedRows) ? 'bg-slate-800' : '' }} hover:bg-slate-700/50">
                            @if (count($actions) > 0)
                                <td class="py-4 w-[1px] whitespace-nowrap">
                                    <div class="flex items-center justify-center w-fit gap-2">
                                        @foreach ($actions as $action)
                                            @if (is_null($action->canSee) || call_user_func($action->canSee, $row))
                                                <button
                                                    wire:click="callAction('{{ $action->method }}', '{{ $row->id }}')"
                                                    class=" {{ $action->classes }}"
                                                    @if($action->label) title="{{ $action->label }}" @endif
                                                >
                                                    <flux:icon name='{{ $action->icon }}' class="size-5"></flux:icon>
                                                    {{-- {!! $action->icon !!} --}}
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            @endif
                            <td class="p-4">
                                <input type="checkbox" wire:model.live="selectedRows" value="{{ $row->id }}"
                                    class="rounded border-slate-500 bg-slate-700 text-indigo-600 focus:ring-indigo-500">
                            </td>
                            @foreach ($columns as $column)
                                @if (is_null($column->canSee) || call_user_func($column->canSee))
                                    <td class="py-4 ps-0 pe-4 whitespace-nowrap text-sm text-slate-200 {{ $column->classes }}">
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
