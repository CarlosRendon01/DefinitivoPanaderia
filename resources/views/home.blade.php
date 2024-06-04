@extends('layouts.app')

<style>
.welcome-section {
    background-color: rgb(248, 244, 225);    
    padding: 40px 20px;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    max-width: 700px;
    margin: 50px auto;
}

.welcome-section:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
}

.welcome-title {
    font-size: 32px;
    color: #2c3e50;
    margin-bottom: 15px;
    font-weight: bold;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    animation: titleFadeIn 1s ease-out 0s 1;
}

.welcome-message {
    font-size: 20px;
    color: #34495e;
    margin-bottom: 20px;
    line-height: 1.7;
    animation: messageFadeIn 1.5s ease-out 0s 1;
}

.welcome-button {
    padding: 12px 30px;
    background-color: #8e44ad; /* Color morado */
    color: white;
    border: none;
    border-radius: 6px;
    text-transform: uppercase;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.2s ease-in-out, transform 0.2s ease;
    font-size: 18px;
    margin-top: 20px;
}

.welcome-button:hover {
    background-color: #732d91; /* Color morado oscuro */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}

img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
    animation: fadeIn 2s ease-out 0s 1;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

@keyframes titleFadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes messageFadeIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.card-custom {
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    background-color: #FF9F9F;
}

.card-custom:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
}

.card-custom .card-title {
    font-size: 18px;
    font-weight: bold;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    color: #FFFFFF;
}

.card-custom .card-body {
    padding: 20px;
    color: #FFFFFF;
}

.custom-column {
    margin-bottom: 20px; /* Espacio entre columnas */
}
</style>

@section('content')
@can('editar-perfil')
<div class="welcome-section">
    <h1 class="welcome-title">Sistema de la Panificadora "El Triunfo"</h1>
    <img src="https://i.ibb.co/D5sLS9N/baker-817282.png" alt="Gestión de panadero" width="200px">
</div>
@else
<div class="welcome-section">
    <h1 class="welcome-title">Bienvenido al Sistema de la Panificadora "El Triunfo"</h1>
    <p class="welcome-message text-danger">Contacta al administrador para poder optener permisos .</p>
    <img src="https://i.ibb.co/D5sLS9N/baker-817282.png" alt="Gestión de panadero" width="200px">
</div>
@endcan

@endsection
@push('scripts')
    <script>
        var loggedInUser = {
            id: '{{ \Illuminate\Support\Facades\Auth::user()->id }}',
            name: '{{ \Illuminate\Support\Facades\Auth::user()->name }}',
            email: '{{ \Illuminate\Support\Facades\Auth::user()->email }}'
        };
        var usersUrl = '{{ url('/users') }}';
    </script>
    <script src="{{ asset('js/profile.js') }}"></script>
@endpush