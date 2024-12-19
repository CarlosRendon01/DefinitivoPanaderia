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
        background-color: #483eff;
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
        background-color: #ffc107;
        color: #212529;
    }

    #miTabla2 tbody td .btn-warning:hover {
        background-color: #e0a800;
    }

    #miTabla2 tbody td .btn-danger {
        background-color: #dc3545;
        color: #fff;
    }


    #miTabla2 tbody td .btn-danger:hover {
        background-color: #c82333;
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

        /* Estilos para las tarjetas en modo móvil */
        .mobile-card {
            background: #fff;
            border: none;
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

        .btn-mobile-action i {
            font-size: 16px;
            margin-right: 5px;
        }

        .btn-mobile-action:hover {
            opacity: 0.8;
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
</style>
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Logs</h3>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped mt-2" id="miTabla2">
                            <thead style="background-color:#5f42d4">
                                <th style="color:#fff;" class="text-center">Id</th>
                                <th style="color:#fff;" class="text-center">Fecha</th>
                                <th style="color:#fff;" class="text-center">Accion</th>
                                <th style="color:#fff;" class="text-center">Tabla</th>
                                <th style="color:#fff;" class="text-center">Id Afectado</th>
                                <th style="color:#fff;" class="text-center">Ejecutada</th>
                                <th style="color:#fff;" class="text-center">Usuario</th>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                <tr>
                                    <td class="text-center">{{ $log->id}}</td>
                                    <td class="text-center">{{ $log->formatted_date }}</td>
                                    <td class="text-center">{{ $log->action }}</td>
                                    <td class="text-center">{{ $log->table }}</td>
                                    <td class="text-center">{{ $log->record_id }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-primary"
                                            onclick="mostrarInformacion({{ $log->id }})">Mostrar</button>
                                        <div id="info-{{ $log->id }}" style="display: none;">
                                            {{ $log->executedSQL }}
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $log->user_name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @foreach ($logs as $log)
                        <div class="mobile-card d-lg-none">
                            <div class="row">
                                <div class="col-6"><label>ID:</label></div>
                                <div class="col-6">{{ $log->id }}</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><label>Fecga:</label></div>
                                <div class="col-6">{{ $log->formatted_date}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><label>Accion:</label></div>
                                <div class="col-6">{{ $log->action }}</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><label>Tabla:</label></div>
                                <div class="col-6">{{ $log->table }}</div>
                            </div>
                            <div class="row">
                                <div class="col-6"><label>Id Afectado:</label></div>
                                <div class="col-6">{{ $log->record_id }}</div>
                            </div>
                    
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button class="btn btn-primary btn-mobile-action" onclick="mostrarInformacion({{ $log->id }})">Mostrar</button>
                                </div>
                            </div>


                        </div>
                        @endforeach

                        <div class="pagination justify-content-end">
                            {!! $logs->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function mostrarInformacion(id) {
    var info = document.getElementById('info-' + id).textContent;
    Swal.fire({
        title: 'Información del Log',
        text: info,
        icon: 'info',
        confirmButtonText: 'Cerrar'
    });
}

new DataTable('#miTabla2', {
lengthMenu: [
    [2, 5, 10, 15, 50],
    [2, 5, 10, 15, 50]
],
columns: [
    { data: 'id', name: 'Id' },
    { data: 'formatted_date', name: 'Fecha' },
    { data: 'action', name: 'Accion' },
    { data: 'table', name: 'Tabla' },
    { data: 'record_id', name: 'Id Afectado' },
    { data: 'executedSQL', name: 'Ejecutada' },
    { data: 'user_name', name: 'Usuario' }
    
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
</script>
@endsection