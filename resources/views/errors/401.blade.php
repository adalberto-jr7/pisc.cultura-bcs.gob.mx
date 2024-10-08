@extends('errors::minimal')

@section('title', __('No autorizado'))
@section('code', '401')
@section('message', __('No autorizado'))
@section('text',__('Usted no tiene acceso a este recurso'))