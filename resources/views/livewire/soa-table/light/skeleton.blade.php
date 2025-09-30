<div class="table-bg text-slate-300 rounded-lg">
    <div class="flex justify-between items-center p-4">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white">{{ $title }}</h3>
        <x-table.refresh-btn />
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr>
                    @if (count($this->actions()) > 0)
                        <th scope="col" class="relative p-4 text-left text-xs font-bold text-slate-600 dark:text-slate-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    @endif
                    @foreach ($columns as $column)
                        @if (is_null($column->canSee) || call_user_func($column->canSee))
                            <th scope="col" class="p-4 text-left text-xs font-bold text-slate-600 dark:text-slate-500 uppercase tracking-wider
                                @if ($column->sortable) cursor-pointer hover:text-slate-300 @endif"
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
            <tbody class="">
                @forelse ($rows as $row)
                    <tr wire:key="light-row-{{ $row->id }}">
                        @if (count($this->actions()) > 0)
                            <td class="p-4 whitespace-nowrap text-left text-sm w-[1px]">
                                <div class="flex items-center space-x-2">
                                    @foreach ($this->actions() as $action)
                                        @if (is_null($action->canSee) || call_user_func($action->canSee, $row))
                                             {{-- ========= INICIO: LÓGICA CONDICIONAL DE ACCIÓN ========= --}}
                                            @if ($action->routeName)
                                                {{-- Si tiene URL, renderiza un enlace --}}
                                                <a wire:navigate href="{{ route($action->routeName, $row) }}" class="font-medium transition-colors {{ $action->foreground }}">
                                                    {{ $action->title }}
                                                </a>
                                            @elseif ($action->execCallback)
                                                {{-- Si tiene un callback, renderiza un botón --}}
                                                <flux:button
                                                    variant='primary'
                                                    :color="$action->bgBtn"
                                                    size="xs"
                                                    wire:click="callLightAction('{{ $action->title }}', '{{ $row->id }}')"
                                                >
                                                    {{ $action->title }}
                                                </flux:button>
                                            @endif
                                            {{-- ========= FIN: LÓGICA CONDICIONAL DE ACCIÓN ========= --}}
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                        @endif
                        @foreach ($columns as $column)
                            @if (is_null($column->canSee) || call_user_func($column->canSee))
                                <td class="p-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-200">
                                    @php $value = data_get($row, $column->field); @endphp
                                    @if ($column->isCurrency)
                                        {{-- If it's a currency, format it --}}
                                        <span class="font-mono">{{ $column->currencySymbol }}{{ number_format($value, $column->currencyDecimals) }}</span>
                                    @elseif ($column->isDate)
                                        {{-- >> NEW: Date formatting logic << --}}
                                        {{ \Carbon\Carbon::parse($value)->translatedFormat($column->dateFormat) }}
                                    @elseif ($column->isBadge)
                                        {{-- >> INICIO: LÓGICA DE BADGE ACTUALIZADA << --}}
                                        @if ($column->badgeResolver)
                                            {{-- Caso Dinámico: Ejecutamos el callback --}}
                                            @php
                                                // El callback recibe la fila completa y debe retornar un array ['color' => ..., 'label' => ...]
                                                $badgeData = call_user_func($column->badgeResolver, $row);
                                            @endphp
                                            <flux:badge
                                                color="{{ $badgeData['color'] ?? 'primary' }}"
                                            >
                                                {{ $badgeData['label'] ?? $value }}
                                            </flux:badge>
                                        @else
                                            {{-- Caso Estático: Usamos el color y el valor por defecto --}}
                                            <flux:badge color="{{ $column->badgeColor }}">
                                                {{ $value }}
                                            </flux:badge>
                                        @endif
                                        {{-- >> FIN: LÓGICA DE BADGE ACTUALIZADA << --}}
                                    @else
                                        {!! $value !!}
                                    @endif
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + (count($this->actions()) > 0 ? 1 : 0) }}" class="p-12 text-center text-slate-500">
                            No hay datos para mostrar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
