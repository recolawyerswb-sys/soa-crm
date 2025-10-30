@extends('errors::minimal')

@section('title', __('Servicio No Disponible'))
@section('error_title', __('Servicio No Disponible 👷'))
@section('code', '503')
@section('code_desc', 'Service Unavailable')
@section('message', __('El servidor está temporalmente inactivo o sobrecargado. Puede ser que esté en mantenimiento. Vuelve a intentarlo en unos minutos; ¡pronto estará de vuelta!'))
@section('link')
    <a href="https://developer.mozilla.org/es/docs/Web/HTTP/Status/503" target="_blank">Más sobre 503 Service Unavailable</a>
@endsection
