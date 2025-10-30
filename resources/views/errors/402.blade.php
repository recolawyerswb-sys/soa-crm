@extends('errors::minimal')

@section('title', __('Pago Requerido'))
@section('error_title', __('Pago Requerido 💸'))
@section('code', '402')
@section('code_desc', 'Payment Required')
@section('message', __('Este código existe para indicar que el acceso al recurso requiere un pago, aunque casi nunca se utiliza en la práctica web actual. Es como una caja de pago que aún no ha sido implementada.'))
@section('link')
    <a href="https://developer.mozilla.org/es/docs/Web/HTTP/Status/402" target="_blank">Más sobre 402 Payment Required</a>
@endsection
