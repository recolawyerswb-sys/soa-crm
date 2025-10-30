@extends('errors::minimal')

@section('title', __('No Encontrado'))
@section('error_title', __('Página No Encontrada 🗺️'))
@section('code', '404')
@section('code_desc', 'Not Found')
@section('message', __('¡Vaya! La página o el archivo que buscas no existe en esta dirección. Es como un callejón sin salida en la web. Revisa la dirección URL por si hay un error de escritura.'))
@section('link')
    <a href="https://developer.mozilla.org/es/docs/Web/HTTP/Status/404" target="_blank">Más sobre 404 Not Found</a>
@endsection
