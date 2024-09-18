@extends('layouts.app')

@section('content')

<div class="container d-flex align-items-start mt-3 " @style(['width: 850px'])>
    
    <div class="row justify-content-center mt-0">

        <div class="d-flex justify-content-center mt-5">
            <div class="row">
                <div class="col-10">
                    <img src="{{ asset('assets/logo-1.jpg') }}" @style(['width: 450px'])>
                </div>
                <div class="col-2 mb-2">
                    <img src="{{ asset('assets/ISC30N24.jpg') }}" @style(['width: 78px'])>
                </div>
            </div>
        </div>


        
        <div class="col-md-8 d-flex justify-content-center mt-4" @style(['width: 850px'])>
            <div class="card" @style(['width: 500px'])>
                <div class="card-header d-flex justify-content-center text-white" @style(['background-color: #9F2241'])>{{ __('Iniciar Sesión') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end"><i class="bi bi-person"></i></label>

                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="Ingresa tu Correo Electrónico" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            
                            <label for="password"  class="col-md-4 col-form-label text-md-end"><i class="bi bi-lock"></i></label> <!-- {{ __('Contraseña') }} -->

                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="Ingresa tu Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Recuérdame') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="col-md-8 offset-md-3">
                                <button type="submit" class="btn btn-primary" @style(['background-color: #9F2241'])>
                                    {{ __('Continuar') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tú contraseña?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 



@endsection