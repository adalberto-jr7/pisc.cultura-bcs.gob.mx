@extends('errors::minimal')

@section('title', __('Demasiadas solicitudes'))
@section('code', '429')
@section('message', __('Demasiadas solicitudes'))
@section('text', 'Lo sentimos usted ha realizado demasiadas solicitudes, pulse el botón para regresar')