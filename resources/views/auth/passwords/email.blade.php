@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">

    <div class="d-flex justify-content-center mt-4">
            <div class="row">
                <div class="col-10">
                    <img src="{{ asset('assets/logo-1.jpg') }}" @style(['width: 449px'])>
                </div>
                <div class="col-2 mb-2">
                    <img src="{{ asset('assets/ISC30N24.jpg') }}" @style(['width: 78px', 'height: 102px'])>
                </div>
            </div>
        </div>



        <div class="col-md-8 container d-flex justify-content-center mt-4">
            <div class="card" @style(['width: 470px', 'height: 190px'])>
                <div class="card-header d-flex justify-content-center text-white" @style(['background-color: #9F2241'])>{{ __('Restablecer Contraseña') }}</div>

                <div class="card-body container pe-5">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="pe-3" method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3 mt-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end"><i class="bi bi-person text-black"></i></label>

                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="Ingresa tu Correo Electrónico" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-0 pe-5 ps-5">
                            <div class="mt-4 col-md-8 offset-md-3  d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary" @style(['background-color: #9F2241'])>
                                    {{ __('Enviar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
