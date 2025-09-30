@props(['title', 'content' => '122', 'description' => null])

{{--
  Contenedor principal con la clase "relative" y los estilos de glassmorphism.
  Este div reemplaza tu contenedor anterior.
--}}
<div {{ $attributes->merge(['class' => 'relative rounded-xl border border-white/30 bg-white/20 px-6 py-4 shadow backdrop-blur-lg dark:border-white/10 dark:bg-black/20']) }}>

    {{-- 1. Título (Arriba y en negrita) --}}
    <p class="text-slate-700 dark:text-neutral-300">
        {{ $title }}
    </p>

    {{-- 2. Estadística (En medio y sobresaliente) --}}
    <p class="my-2 text-2xl font-bold text-slate-800 dark:text-white">
        {{ $content }}
    </p>

    {{-- 3. Descripción (Abajo, opcional y sutil) --}}
    @if ($description)
        <p class="text-sm text-zinc-600 dark:text-neutral-400">
            {{ $description }}
        </p>
    @endif

</div>
