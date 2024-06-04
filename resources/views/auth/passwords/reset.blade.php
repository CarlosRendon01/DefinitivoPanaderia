@extends('layouts.auth_app')

@section('title')
    Restablecer Contraseña
@endsection

@section('content')
<style>
    body {
        background-color: #FAFAFA;
        font-family: 'Nunito', sans-serif;
        color: #51545E;
    }

    .reset-password-container {
        max-width: 360px;
        margin: 8% auto;
        padding: 30px;
        background: #FFF;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-radius: 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .reset-password-container:hover {
        box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    .card-header h4 {
        color: #2C3E50;
        text-align: center;
        margin-bottom: 24px;
        font-size: 22px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        color: #607D8B;
        font-weight: 600;
    }

    .form-control {
        border: 1px solid #B0BEC5;
        border-radius: 4px;
        padding: 12px 16px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #42A5F5;
        box-shadow: inset 0 1px 3px rgba(66,165,245,0.3);
    }

    .form-control.is-invalid {
        border-color: #EF5350;
    }

    .invalid-feedback {
        color: #D32F2F;
        font-size: 13px;
        margin-top: 6px;
    }

    .btn-primary {
        background-color: #42A5F5;
        border-color: #42A5F5;
        font-size: 16px;
        padding: 10px 18px;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #1E88E5;
        border-color: #1E88E5;
    }

    .text-muted {
        text-align: center;
        margin-top: 15px;
        font-size: 14px;
    }

    .text-muted a {
        color: #42A5F5;
        transition: color 0.3s ease;
    }

    .text-muted a:hover {
        color: #1E88E5;
    }
</style>

<div class="reset-password-container">
    <div class="card card-primary">
        <div class="card-header">
            <h4>Establece una Nueva Contraseña</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('/password/reset') }}" class="reset-form">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" tabindex="1" value="{{ old('email') }}" autofocus>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" tabindex="2">
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" tabindex="3">
                    <div class="invalid-feedback">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Establecer Nueva Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-3 text-muted text-center">
        <a href="{{ route('welcome') }}">Regresar al Inicio</a>
    </div>
</div>

@endsection
