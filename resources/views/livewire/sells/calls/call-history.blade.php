<div class="space-y-4 max-w-3xl mx-auto p-4">

    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Historial de Llamadas</h1>

    {{-- Mensaje de error --}}
    @if (session()->has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @forelse ($calls as $call)
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                {{-- Información del Llamante y Destinatario --}}
                <div class="flex items-center space-x-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                    <span>{{ $call['from'] }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                    <span>{{ $call['to'] }}</span>
                </div>

                {{-- Estado de la llamada con una insignia de color --}}
                @php
                    $statusClasses = match ($call['status']) {
                        'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                        'no-answer' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                        'busy' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                        'failed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                    };
                @endphp
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses }}">
                    {{ ucfirst($call['status']) }}
                </span>
            </div>

            <div class="mt-3 flex items-end justify-between text-sm text-gray-500 dark:text-gray-400">
                {{-- Fecha y Hora --}}
                <div>
                    <span>{{ $call['start_time']->format('d M Y') }}</span>
                    <span class="mx-1">·</span>
                    <span>{{ $call['start_time']->format('h:i A') }}</span>
                </div>

                {{-- Duración de la llamada formateada --}}
                <div class="font-medium text-gray-700 dark:text-gray-300">
                    @php
                        $minutes = floor($call['duration'] / 60);
                        $seconds = $call['duration'] % 60;
                    @endphp
                    <span>Duración: {{ sprintf('%02d:%02d', $minutes, $seconds) }}</span>
                </div>
            </div>
        </div>
    @empty
        {{-- Mensaje que se muestra si no hay llamadas --}}
        <div class="bg-white dark:bg-gray-800 text-center p-8 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-700">
            <p class="text-gray-500 dark:text-gray-400">No se encontraron registros de llamadas.</p>
        </div>
    @endforelse

</div>
