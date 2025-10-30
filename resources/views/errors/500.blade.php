@extends('errors::minimal')

@section('title', __('Error del Servidor'))
@section('error_title', __('Error Interno del Servidor 💥'))
@section('code', '500')
@section('code_desc', 'Internal Server Error')
@section('message', __('Algo salió mal en el servidor, ¡y no sabemos exactamente qué! Es un error inesperado que el equipo técnico debe revisar. Por favor, inténtalo de nuevo más tarde.'))
@section('link')
    <a href="https://developer.mozilla.org/es/docs/Web/HTTP/Status/500" target="_blank">Más sobre 500 Internal Server Error</a>
@endsection
