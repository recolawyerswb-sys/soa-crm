@extends('errors::minimal')

@section('title', __('No Autorizado'))
@section('error_title', __('No Autorizado 🔑'))
@section('code', '401')
@section('code_desc', 'Unauthorized')
@section('message', __('¡Alto ahí! Necesitas iniciar sesión o proporcionar tus credenciales para acceder a esta página o recurso. Es como si la puerta estuviera cerrada y te pidiera tu llave.'))
@section('link')
    <a href="https://developer.mozilla.org/es/docs/Web/HTTP/Status/401" target="_blank">Más sobre 401 Unauthorized</a>
@endsection
