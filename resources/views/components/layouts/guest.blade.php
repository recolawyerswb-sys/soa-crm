{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'SOA CRM - Tu mejor aliado' }}</title>
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/crm.js'])
        @fluxAppearance
    </head>
    <body class="antialiased">
        {{-- Aquí Livewire inyectará el contenido de tu componente --}}
        {{ $slot }}
        @fluxScripts
    </body>
</html>
