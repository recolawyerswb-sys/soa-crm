@extends('errors::minimal')

@section('title', __('Sesión Expirada'))
@section('error_title', __('Sesión Expirada ⏱️'))
@section('code', '419')
@section('code_desc', 'Page Expired')
@section('message', __('Tu sesión ha caducado por inactividad o por motivos de seguridad. Para continuar, por favor, vuelve a cargar la página o inicia sesión de nuevo.'))
@section('link')
    <a href="https://developer.mozilla.org/es/docs/Web/HTTP/Status/419" target="_blank">Más sobre 419 Page Expired</a>
@endsection
