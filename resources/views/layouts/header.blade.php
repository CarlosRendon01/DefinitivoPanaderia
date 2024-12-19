<style>
    .navbar-nav .nav-link {
        color: #fff;
        transition: color 0.3s ease-in-out, transform 0.3s ease, background-color 0.3s ease;
        /* Añadir transición para el fondo */
        font-size: 1.1em;
        /* Tamaño de letra más grande */
        padding: 0.5em 1em;
        /* Más espaciado */
        border-radius: 5px;
        /* Para aplicar un borde redondeado */
    }

    .navbar-nav .nav-link:hover {
        color: #ddd;
        text-decoration: none;
        transform: translateY(-5px);
        /* Desplazamiento vertical en hover */
        background-color: #6a5acd;
        /* Fondo morado al pasar el cursor */
    }
</style>
<form class="form-inline mr-auto" action="#">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
</form>
<ul class="navbar-nav navbar-right">

    @if(\Illuminate\Support\Facades\Auth::user())
    <li class="dropdown">
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <div class="d-sm-none d-lg-inline-block">
                ¡Hola!, {{\Illuminate\Support\Facades\Auth::user()->name}}</div>
        </a>

        <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-title">
                Bienvenido, {{\Illuminate\Support\Facades\Auth::user()->name}}</div>
            <a class="dropdown-item has-icon edit-profile" data-toggle="modal" data-target="#EditProfileModal" href="#"
                data-id="{{ \Auth::id() }}">
                <i class="fa fa-user"></i>Editar Perfil de Usuario</a>
            <a class="dropdown-item has-icon" data-toggle="modal" data-target="#changePasswordModal" href="#"
                data-id="{{ \Auth::id() }}"><i class="fa fa-lock"> </i>Cambiar Password</a>
            <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger"
                onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                {{ csrf_field() }}
            </form>
        </div>
    </li>
    @else
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            {{-- <img alt="image" src="#" class="rounded-circle mr-1">--}}
            <div class="d-sm-none d-lg-inline-block">{{ __('messages.common.hello') }}</div>
        </a>
        <div class="dropdown-menu dropdown-menu-right" style="background: #6e4141">
            <div class="dropdown-title">{{ __('messages.common.login') }}
                / {{ __('messages.common.register') }}</div>
            <a href="{{ route('login') }}" class="dropdown-item has-icon">
                <i class="fas fa-sign-in-alt"></i> {{ __('messages.common.login') }}
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('register') }}" class="dropdown-item has-icon">
                <i class="fas fa-user-plus"></i> {{ __('messages.common.register') }}
            </a>
        </div>
    </li>
    @endif
</ul>