@extends('layouts.app')

<style>
    #miTabla2 {
        font-family: 'Open Sans', sans-serif;
        border-collapse: collapse;
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    #miTabla2 thead {
        background-color: #483eff;
        color: #fff;
    }

    #miTabla2 thead th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    #miTabla2 tbody tr {
        border-bottom: 1px solid #ddd;
        transition: background-color 0.3s ease;
    }

    #miTabla2 tbody tr:hover {
        background-color: #f5f5f5;
    }

    #miTabla2 tbody td {
        padding: 12px 15px;
    }

    #miTabla2 tbody td .custom-badge {
        background-color: #000000;
        color: #fff;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    #miTabla2 tbody td .btn {
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    #miTabla2 tbody td .btn-warning {
        background-color: #fff;
        color: #212529;
    }

    #miTabla2 tbody td .btn-warning:hover {
        background-color: #e0a800;
    }

    #miTabla2 tbody td .btn-danger {
        background-color: #fff;
        color: #041014;
    }

    #miTabla2 tbody td .btn-danger:hover {
        background-color: #c82333;
    }

    .css-button-sliding-to-left--red {
        min-width: 130px;
        height: 40px;
        color: #fff;
        padding: 5px 10px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: inline-block;
        outline: none;
        border-radius: 5px;
        z-index: 0;
        background: #fff;
        overflow: hidden;
        border: 2px solid #d90429;
        color: #d90429;
    }

    .css-button-sliding-to-left--red:hover {
        color: #fff;
    }

    .css-button-sliding-to-left--red:hover:after {
        width: 100%;
    }

    .css-button-sliding-to-left--red:after {
        content: "";
        position: absolute;
        z-index: -1;
        transition: all 0.3s ease;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        background: #d90429;
    }

    .css-button-sliding-to-left--yellow {
        min-width: 130px;
        height: 40px;
        color: #fff;
        padding: 5px 10px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: inline-block;
        outline: none;
        border-radius: 5px;
        z-index: 0;
        background: #fff;
        overflow: hidden;
        border: 2px solid #ffd819;
        color: #ffd819;
    }

    .css-button-sliding-to-left--yellow:hover {
        color: #fff;
    }

    .css-button-sliding-to-left--yellow:hover:after {
        width: 100%;
    }

    .css-button-sliding-to-left--yellow:after {
        content: "";
        position: absolute;
        z-index: -1;
        transition: all 0.3s ease;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        background: #ffd819;
    }

    /* Estilos para el campo de búsqueda */
    .dataTables_filter {
        position: relative;
    }

    .dataTables_filter input[type="search"] {
        padding: 12px 40px 12px 20px;
        border: none;
        border-radius: 25px;
        background-color: #f2f2f2;
        font-size: 16px;
        width: 300px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .dataTables_filter input[type="search"]:focus {
        outline: none;
        width: 350px;
        background-color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .dataTables_filter::after {
        content: "\f002";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
        color: #999;
        transition: color 0.3s ease;
    }

    .dataTables_filter input[type="search"]:focus+::after {
        color: #333;
    }

    /* Estilos para el menú de selección de registros */
    .dataTables_length {
        position: relative;
        display: inline-block;
        margin-bottom: 20px;
    }

    .dataTables_length label {
        font-size: 16px;
        font-weight: bold;
        color: #555;
    }

    .dataTables_length select {
        padding: 10px 40px 10px 20px;
        border: none;
        border-radius: 25px;
        background-color: #f2f2f2;
        font-size: 16px;
        width: 120px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23999'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .dataTables_length select:focus {
        outline: none;
        background-color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .dataTables_length select:hover {
        background-color: #e6e6e6;
    }

    .dataTables_length::after {
        content: "";
        position: absolute;
        top: 50%;
        right: 30px;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #999;
        pointer-events: none;
        transition: border-color 0.3s ease;
    }

    .dataTables_length select:focus+::after {
        border-top-color: #333;
    }

    @media (max-width: 992px) {
        #miTabla2 {
            display: none;
        }

        .mobile-table {
            display: block;
        }

        .mobile-card {
        background: #fff;
        border: 1px solid #ddd; /* Añadir borde */
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 16px;
        padding: 16px;
    }

    .mobile-card .row {
        margin-bottom: 8px;
    }

    .mobile-card label {
        font-weight: bold;
        color: #333;
    }

    .mobile-card .data {
        font-size: 14px;
        color: #666;
    }

    .action-buttons {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
    }

    .btn-mobile {
        flex: 0 1 48%;
        margin: 0;
        padding: 10px;
        border-radius: 4px;
        font-size: 14px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .btn-mobile i {
        font-size: 16px;
        margin-right: 5px;
    }

    .btn-mobile:hover {
        opacity: 0.8;
    }

    .btn-warning.btn-mobile {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-danger.btn-mobile {
        background-color: #dc3545;
        color: #fff;
    }

        /* Estilos para los botones de acción en modo móvil */
        .action-buttons {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
        }

        .btn-mobile {
            flex: 0 1 48%;
            margin: 0;
            padding: 10px;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-mobile i {
            font-size: 16px;
            margin-right: 5px;
        }

        .btn-mobile:hover {
            opacity: 0.8;
        }

        /* Colores de los botones */
        .btn-warning.btn-mobile {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-danger.btn-mobile {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-mobile-action {
            flex: 0 1 48%;
            margin: 0;
            padding: 10px;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-mobile-action:hover {
            opacity: 0.8;
        }

        .mobile-table {
            display: none;
        }

        .dataTables_length,
        .dataTables_filter,
        .dataTables_paginate {
            display: none !important;
        }
    }

    @media (min-width: 993px) {
        .mobile-table {
            display: none;
        }
    }

    .custom-badge {
        background-color: #483eff;
        color: white;
        /* Cambia el color del texto a blanco para mejorar la legibilidad */
    }

    .role-badge {
        display: inline-block;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: bold;
        text-align: center;
        border-radius: 12px;
        color: #fff;
        margin: 2px;
    }

    .role-badge.admin {
        background-color: #28a745;
        /* Verde para administradores */
        border: 1px solid #218838;
    }

    .role-badge.user {
        background-color: #007bff;
        /* Azul para usuarios */
        border: 1px solid #0069d9;
    }

    .role-badge.moderator {
        background-color: #ffc107;
        /* Amarillo para moderadores */
        border: 1px solid #e0a800;
    }

    /* Estilo predeterminado para cualquier otro rol */
    .role-badge.default {
        background-color: #6c757d;
        /* Gris para otros roles */
        border: 1px solid #5a6268;
    }
</style>

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Usuarios</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            @can('crear-usuario')
                            <a class="btn btn-warning" href="{{ route('usuarios.create') }}">
                                <i class="fas fa-plus"></i> Nuevo Usuario
                            </a>
                            @endcan
                        </div>

                        <!-- Contenedor para la tabla de usuarios -->
                        <div id="userListContainer" class="table-responsive mt-3">
                            <table class="table table-striped mt-2" id="miTabla2">
                                <thead style="background-color:#5f42d4">
                                    <tr>
                                        <th style="color:#fff;" class="text-center">Nombre</th>
                                        <th style="color:#fff;" class="text-center">E-mail</th>
                                        <th style="color:#fff;" class="text-center">Rol</th>
                                        <th style="color:#fff;" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td class="text-center">{{ $usuario->name }}</td>
                                        <td class="text-center">{{ $usuario->email }}</td>
                                        <td class="text-center">
                                            @foreach($usuario->getRoleNames() as $rolNombre)
                                            @php
                                            $roleClass = strtolower($rolNombre) === 'admin' ? 'admin' :
                                            (strtolower($rolNombre) === 'user' ? 'user' : (strtolower($rolNombre) ===
                                            'moderator' ? 'moderator' : 'default'));
                                            @endphp
                                            <span class="role-badge {{ $roleClass }}">{{ $rolNombre }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @can('editar-usuario')
                                            <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                                class="btn btn-warning mr-1 css-button-sliding-to-left--yellow">
                                                <i class="fas fa-edit"></i>Editar
                                            </a>
                                            @endcan

                                            @can('eliminar-usuario')
                                            <button type="button" class="btn btn-danger css-button-sliding-to-left--red"
                                                onclick="confirmarEliminacion({{ $usuario->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                                Eliminar
                                            </button>
                                            <form id="eliminar-form-{{ $usuario->id }}"
                                                action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @foreach ($usuarios as $usuario)
                            <div class="mobile-card d-lg-none">
                                <div class="row">
                                    <div class="col-6"><label>Nombre:</label></div>
                                    <div class="col-6">{{ $usuario->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-6"><label>Email:</label></div>
                                    <div class="col-6">{{ $usuario->email }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-6"><label>Rol:</label></div>
                                    <div class="col-6">
                                        @foreach($usuario->getRoleNames() as $rolNombre)
                                        @php
                                        $roleClass = strtolower($rolNombre) === 'admin' ? 'admin' :
                                        (strtolower($rolNombre) === 'user' ? 'user' : (strtolower($rolNombre) ===
                                        'moderator' ? 'moderator' : 'default'));
                                        @endphp
                                        <span class="role-badge {{ $roleClass }}">{{ $rolNombre }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row action-buttons">
                                    @can('editar-usuario')
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                        class="btn btn-warning btn-mobile">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    @endcan
                                    @can('eliminar-usuario')
                                    <button type="button" class="btn btn-danger btn-mobile"
                                        onclick="confirmarEliminacion({{ $usuario->id }})">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                    <form id="eliminar-form-{{ $usuario->id }}"
                                        action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST"
                                        class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endcan
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="pagination justify-content-end">
                            {!! $usuarios->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<!-- DATATABLES -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- BOOTSTRAP -->
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new DataTable('#miTabla2', {
        lengthMenu: [
            [2, 5, 10, 15, 50],
            [2, 5, 10, 15, 50]
        ],
        columns: [
                { data: 'name', title: 'Nombre' },
                { data: 'email', title: 'E-mail' },
                { data: 'roles', title: 'Rol' },
                { data: 'actions', title: 'Acciones' }
            ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            search: "_INPUT_",
            searchPlaceholder: "Buscar...",
            lengthMenu: "Mostrar registros _MENU_ "
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        pageLength: 10
    });

    function confirmarEliminacion(usuarioId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('eliminar-form-' + usuarioId).submit();
                Swal.fire({
                    title: 'Eliminado!',
                    text: 'El usuario ha sido eliminado correctamente.',
                    icon: 'success',
                    timer: 4000, // Duración en milisegundos
                    showConfirmButton: false
                });
            }
        });
    }

    // Función para actualizar la lista de usuarios
    function actualizarListaUsuarios() {
        $.ajax({
            url: '{{ route('usuarios.getUserList') }}', // Asegúrate de que esta ruta apunte a tu método getUserList
            type: 'GET',
            success: function(response) {
                $('#userListContainer').html(response); // Reemplaza el contenedor con la lista de usuarios actualizada
                new DataTable('#miTabla2', {
                    lengthMenu: [
                        [2, 5, 10, 15, 50],
                        [2, 5, 10, 15, 50]
                    ],
                    columns: [
                            { data: 'name', title: 'Nombre' },
                            { data: 'email', title: 'E-mail' },
                            { data: 'roles', title: 'Rol' },
                            { data: 'actions', title: 'Acciones' }
                        ],
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                        search: "_INPUT_",
                        searchPlaceholder: "Buscar...",
                        lengthMenu: "Mostrar registros _MENU_ "
                    },
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    pageLength: 10
                });
            }
        });
    }

    // Llama a la función actualizarListaUsuarios después de editar un perfil
    $(document).ready(function() {
        $('#editProfileForm').on('submit', function(event) {
            event.preventDefault(); // Prevenir el envío normal del formulario

            // Limpiar mensajes de error anteriores
            $('#editProfileErrorAlert').addClass('d-none');
            $('#editProfileErrorList').empty();
            $('#editProfileSuccessAlert').addClass('d-none');

            // Enviar el formulario vía AJAX
            $.ajax({
                url: $('#editProfileForm').attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editProfileSuccessAlert').removeClass('d-none');
                    setTimeout(function() {
                        $('#EditProfileModal').modal('hide');
                        $('#editProfileSuccessAlert').addClass('d-none');
                        $('#editProfileForm')[0].reset();

                        // Actualizar la lista de usuarios
                        actualizarListaUsuarios();
                    }, 2000);
                },
                error: function(response) {
                    if (response.responseJSON && response.responseJSON.errors) {
                        var errors = response.responseJSON.errors;
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                $('#editProfileErrorList').append('<li>' + errors[key][0] + '</li>');
                                if (key === 'email') {
                                    $('#pfEmail').addClass('is-invalid');
                                } else if (key === 'name') {
                                    $('#pfName').addClass('is-invalid');
                                }
                            }
                        }
                        $('#editProfileErrorAlert').removeClass('d-none');
                    } else {
                        $('#editProfileErrorList').append('<li>Ocurrió un error inesperado. Por favor, inténtelo de nuevo más tarde.</li>');
                        $('#editProfileErrorAlert').removeClass('d-none');
                    }
                }
            });
        });

        $('#pfEmail').on('input', function() {
            $(this).removeClass('is-invalid');
        });

        $('#pfName').on('input', function() {
            $(this).removeClass('is-invalid');
        });
    });
</script>
@endsection
