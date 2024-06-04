@extends('layouts.auth_app')
@section('title')
    Registro
@endsection

@section('content')
<style>
    /* Repetimos los estilos aquí para asegurarnos de que se apliquen */
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.2s ease-in-out;
        border: 1px solid #ddd;
    }
    .card-header {
        background-color: #5a67d8;
        color: #fff;
        font-size: 20px;
        border-bottom: 1px solid #4c51bf;
        border-top-left-radius: 7px;
        border-top-right-radius: 7px;
    }
    .btn-primary {
        background-color: #4c51bf;
        border: none;
        border-radius: 20px;
        padding: 10px 24px;
        font-size: 16px;
        transition: background-color 0.2s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .btn-primary:hover {
        background-color: #434190;
    }
    .form-control {
        border-radius: 20px;
        border: 1px solid #ddd;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) inset;
    }
    .form-control:focus {
        border-color: #5a67d8;
        box-shadow: 0 0 8px rgba(90, 103, 216, 0.2);
    }
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #4c51bf;
        border-color: #4c51bf;
    }
    .alert-danger, .text-danger {
        color: #e3342f; /* Rojo para mensajes de error */
    }
    .text-muted.text-center {
        margin-top: 20px;
        font-size: 0.875em;
    }
</style>
<div class="overlay" id="registerOverlay">
    <div class="register-container">
        <div class="register-title">Registro de Usuario</div>
        @extends('layouts.auth_app')
        @section('title')
            Registro
        @endsection

        @section('content')
        <style>
            /* Estilos CSS */
        </style>
        <div class="card card-primary">
            <div class="card-header"><h4>Registro</h4></div>

            <div class="card-body pt-1">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName">Nombre Completo:</label><span class="text-danger">*</span>
                                <input id="firstName" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" tabindex="1" placeholder="Ingresa tu nombre completo" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo Electrónico:</label><span class="text-danger">*</span>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Ingresa tu dirección de correo" name="email" tabindex="1" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="control-label">Contraseña:</label><span class="text-danger">*</span>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" placeholder="Establece una contraseña" name="password" tabindex="2" required>
                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation" class="control-label">Confirmar Contraseña:</label><span class="text-danger">*</span>
                                <input id="password_confirmation" type="password" placeholder="Confirma tu contraseña" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}" name="password_confirmation" tabindex="2">
                                @if ($errors->has('password_confirmation'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password_confirmation') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Registrarse
                                </button>
                                <button type="button" class="btn btn-secondary btn-lg btn-block" onclick="hideRegisterForm()">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-5 text-muted text-center">
            ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia Sesión</a>
        </div>
        @endsection
    </div>
</div>
@endsection
