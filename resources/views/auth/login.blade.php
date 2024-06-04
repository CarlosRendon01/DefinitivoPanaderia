@extends('layouts.auth_app')

@section('title')
    Inicio de Sesión de Administrador
@endsection

@section('content')
<style>
    /* Estilos generales del formulario */
    .card {
        border-radius: 10px; /* Bordes más suaves */
        box-shadow: 0 4px 6px rgba(50,50,93,0.11), 0 1px 3px rgba(0,0,0,0.08); /* Sombra más pronunciada */
        transition: all 0.3s ease-in-out; /* Transición más suave */
        border: none; /* Eliminar el borde para un look más limpio */
        background: #ffffff; /* Fondo blanco para mejor contraste */
    }
    .card-header {
        background-color: #667eea; /* Un color azul ligeramente diferente */
        color: #ffffff;
        font-size: 22px; /* Ligeramente más grande para más énfasis */
        padding: 16px 24px; /* Ajuste de padding para un mejor aspecto */
        border-bottom: none; /* Eliminar el borde inferior para un look más limpio */
        border-top-left-radius: 10px; /* Asegurar consistencia en bordes redondeados */
        border-top-right-radius: 10px;
    }
    .btn-primary {
        background-color: #5a67d8; /* Ajuste del color principal */
        border: none;
        border-radius: 25px; /* Bordes aún más redondeados para botones */
        padding: 12px 30px; /* Ajuste de padding para un botón más prominente */
        font-size: 18px; /* Tamaño de fuente más grande para mejorar legibilidad */
        transition: background-color 0.2s, transform 0.2s; /* Añadir efecto de transformación */
        box-shadow: 0 4px 6px rgba(50,50,93,0.11), 0 1px 3px rgba(0,0,0,0.08); /* Sombra consistente con la tarjeta */
    }
    .btn-primary:hover {
        background-color: #434190; /* Oscurecer al pasar el mouse */
        transform: translateY(-2px); /* Ligero efecto de elevación al pasar el mouse */
    }
    .form-control {
        border-radius: 25px; /* Consistencia en bordes redondeados */
        border: 1px solid #e2e8f0; /* Color de borde más suave */
        transition: border-color 0.2s, box-shadow 0.2s; /* Transición suave para enfoque */
        box-shadow: none; /* Eliminar sombra interna para un look más limpio */
    }
    .form-control:focus {
        border-color: #667eea; /* Cambio de color en el foco */
        box-shadow: 0 0 0 1px rgba(102,126,234,0.5); /* Sombra de foco suave y coherente */
    }
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #5a67d8; /* Consistente con el color principal */
        border-color: #5a67d8;
    }
    .alert-danger {
        background-color: #fef2f2; /* Fondo más suave para el alerta */
        border-color: #fed7d7; /* Borde coherente con el fondo */
        color: #e53e3e; /* Color de texto que contraste bien */
        padding: 12px; /* Ajuste de padding */
        border-radius: 10px; /* Bordes redondeados */
    }
    .text-small {
        font-size: 0.875em; /* Mantener tamaño de fuente pequeño */
    }
    .form-group {
        margin-bottom: 1.25rem; /* Ajuste de margen para mejor espaciado */
    }
</style>

<div class="card card-primary">
    <div class="card-header"><h4>Inicio de Sesión</h4></div>

    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <p>Por favor, corrige los siguientes errores:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Ingresa tu correo" tabindex="1" value="{{ old('email', Cookie::get('email')) }}" autofocus required>
                @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="password" class="control-label">Contraseña</label>
                <a href="{{ route('password.request') }}" class="text-small">
                    ¿Olvidaste tu contraseña?
                </a>
                <input id="password" type="password" placeholder="Ingresa tu contraseña" class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password" tabindex="2" required>
                @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember"{{ old('remember', Cookie::get('remember')) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="remember">Recuérdame</label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Iniciar Sesión
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
