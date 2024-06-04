<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 4.1.1 -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
    <link href="{{ asset('assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



    @yield('page_css')
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/components.css')}}">
    @yield('page_css')

    
    @yield('css')

    <style>
        .bg-primary {
            background-color: #AF8F6F !important; /* Color café */
        }

        .main-navbar {
            background: linear-gradient(to right, #8A492B, #8A492B);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
            font-family: 'Lato', sans-serif;
            transition: all 0.3s ease;
            padding: 0.8em 0; /* Espaciado adicional */
        }
    
        .main-navbar:hover {
            background: linear-gradient(to right, #AF8F6F, #AF8F6F);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2); /* Sombra más pronunciada */
        }
    
        .navbar-nav .nav-link {
            color: #fff;
            transition: color 0.3s ease-in-out, transform 0.3s ease;
            font-size: 1.1em; /* Tamaño de letra más grande */
            padding: 0.5em 1em; /* Más espaciado */
        }
    
        .navbar-nav .nav-link:hover {
            color: #ddd;
            text-decoration: none;
            transform: translateY(-5px); /* Desplazamiento vertical en hover */
        }

        .btn-pink {
            transition: all 0.3s ease;
            background-color: #D8AE7E; /* Fondo rosa */
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-pink:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
            background-color: #D8AE7E; /* Rosa oscuro al hacer hover */
        }

        .btn-pink:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(255, 105, 180, 0.3); /* Sombra rosa */
        }

        .bg-pink {
            background-color: #D8AE7E; /* Fondo rosa */
        }
    
        @media (max-width: 992px) {
            .navbar-expand-lg .navbar-nav .nav-link {
                padding-right: 0.8rem;
                padding-left: 0.8rem;
            }
    
            .main-navbar {
                background: linear-gradient(to right, #2b285c, #4b479c);
            }
        }

    </style>
    
    
</head>

<body>

    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            
            <nav class="navbar navbar-expand-lg main-navbar">
                @include('layouts.header')
            </nav>
            <div class="main-sidebar main-sidebar-postion"  style="background-color:  #f4f4f9">
                @include('layouts.sidebar')
            </div>
            <!-- Main Content -->
            <div class="main-content" style="background-color:  #F8F4E1">
                @yield('content')
            </div>
            <footer class="main-footer">
                @include('layouts.footer')
            </footer>
        </div>
    </div>

    @include('profile.change_password')
    @include('profile.edit_profile')

</body>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('web/js/stisla.js') }}"></script>
<script src="{{ asset('web/js/scripts.js') }}"></script>
<script src="{{ mix('assets/js/profile.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

@yield('page_js')
@yield('scripts')
<script>
    import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";
import { Spanish } from "flatpickr/dist/l10n/es.js";
flatpickr.localize(Spanish);

  $(document).ready(function() {
        $('#changePasswordForm').on('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting normally

            var currentPassword = $('#pfCurrentPassword').val();
            var newPassword = $('#pfNewPassword').val();
            var confirmPassword = $('#pfNewConfirmPassword').val();

            // Limpiar mensajes de error anteriores
            $('#errorAlert').addClass('d-none');
            $('#errorList').empty();

            // Validar si las contraseñas nuevas coinciden
            if (newPassword !== confirmPassword) {
                $('#errorList').append('<li>Las contraseñas no coinciden</li>');
                $('#errorAlert').removeClass('d-none');
                return;
            }

            // Submit the form via AJAX
            $.ajax({
                url: $('#changePasswordForm').attr('action'),
                type: 'POST',
                data: $('#changePasswordForm').serialize(),
                success: function(response) {
                    $('#successAlert').removeClass('d-none');
                    setTimeout(function() {
                        $('#changePasswordModal').modal('hide');
                        $('#successAlert').addClass('d-none');
                        $('#changePasswordForm')[0].reset();
                    }, 2000);
                },
                error: function(response) {
                    if (response.responseJSON && response.responseJSON.errors) {
                        var errors = response.responseJSON.errors;
                        for (var error in errors) {
                            $('#errorList').append('<li>' + errors[error][0] + '</li>');
                        }
                        $('#errorAlert').removeClass('d-none');
                    }
                }
            });
        });
    });
</script>

</html>
