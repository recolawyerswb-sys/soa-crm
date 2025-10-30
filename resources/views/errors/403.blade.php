@extends('errors::minimal')

@section('title', __('Restringido'))
@section('error_title', __('Acceso Denegado 🚫'))
@section('code', '403')
@section('code_desc', 'Forbidden')
@section('message', __('Tienes permiso para estar aquí, pero no puedes ver este contenido. El servidor te reconoce, pero no tienes los derechos necesarios (como un administrador o un usuario especial) para ver lo que buscas.'))
@section('link')
    <a href="https://developer.mozilla.org/es/docs/Web/HTTP/Status/403" target="_blank" class="text-blue-500 underline font-medium cursor-pointer">Más sobre 403 Forbidden</a>
@endsection
