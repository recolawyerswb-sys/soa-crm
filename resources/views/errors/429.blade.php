@extends('errors::minimal')

@section('title', __('Demasiadas Peticiones'))
@section('error_title', __('Demasiadas Peticiones 🐢'))
@section('code', '429')
@section('code_desc', 'Too Many Requests')
@section('message', __('¡Estás yendo muy rápido! Has enviado demasiadas solicitudes al servidor en poco tiempo. Por favor, espera un momento y vuelve a intentarlo para no sobrecargarlo.'))
@section('link')
    <a href="https://developer.mozilla.org/es/docs/Web/HTTP/Status/429" target="_blank">Más sobre 429 Too Many Requests</a>
@endsection
