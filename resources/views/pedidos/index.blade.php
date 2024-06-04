@extends('layouts.app')

<style>
/* Navbar Styles */
.navbar {
    background-color: #8B4513;
    /* Color café */
    border-bottom: 2px solid #A0522D;
    /* Línea inferior café más claro */
    padding: 1rem 1.5rem;
}

.navbar .navbar-brand {
    color: #fff;
    font-size: 1.5rem;
    font-weight: bold;
    transition: color 0.3s;
}

.navbar .navbar-brand:hover {
    color: #FFD700;
    /* Dorado */
}

.navbar .navbar-nav .nav-link {
    color: #fff;
    font-size: 1rem;
    margin: 0 0.5rem;
    transition: color 0.3s;
}

.navbar .navbar-nav .nav-link:hover {
    color: #FFD700;
    /* Dorado */
}

/* Sidebar Styles */
#sidebar-wrapper {
    background-color: #8B4513;
    /* Color café */
    color: #fff;
    transition: all 0.3s;
}

.sidebar-brand a {
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    padding: 10px 0;
}

.brand-name {
    font-family: 'Arial', sans-serif;
    font-size: 24px;
    font-weight: bold;
    color: #fff;
    padding: 0 10px;
}

.sidebar-menu {
    list-style: none;
    padding: 20px 10px;
}

.sidebar-menu li a {
    display: block;
    color: #fff;
    /* Color blanco para el texto de los enlaces */
    padding: 10px;
    border-radius: 4px;
    transition: color 0.3s, background-color 0.3s;
}

.sidebar-menu li a:hover {
    color: #FFD700;
    /* Dorado */
    background-color: #A0522D;
    /* Color café más claro */
    text-decoration: none;
}

.app-header-logo {
    transition: transform 0.3s ease-in-out;
}

.app-header-logo:hover {
    transform: scale(1.1);
}

.sidebar-brand-sm {
    display: none;
}

@media (max-width: 768px) {
    .sidebar-brand-sm {
        display: block;
    }

    .sidebar-brand {
        display: none;
    }
}

/* Table Styles */
#miTabla2 {
    font-family: 'Open Sans', sans-serif;
    border-collapse: collapse;
    width: 100%;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

#miTabla2 thead {
    background-color: #8B4513;
    /* Color café */
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

.btn-pink {
    transition: all 0.3s ease;
    background-color: #ff69b4;
    /* Fondo rosa */
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
    background-color: #ff1493;
    /* Cambiar a rosa oscuro */
}

.btn-pink:focus {
    outline: none;
    box-shadow: 0 0 10px rgba(255, 105, 180, 0.3);
    /* Cambiar a rosa */
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

/* Estilos para dispositivos móviles */
@media (max-width: 992px) {
    #miTabla2 {
        display: none;
    }

    .mobile-table {
        display: block;
    }


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
}

@media (min-width: 993px) {
    .mobile-table {
        display: none;
    }
}

.custom-badge {
    background-color: #483eff;
    color: white;
}

*,
*:before,
*:after {
    box-sizing: border-box;
}

body {
    height: 100vh;
    background: #ccc;
    overflow: hidden;
}

.modal-container {
    margin: 60px auto;
    padding-top: 0px;
    position: relative;
    width: 160px;

    .modal-btn {
        display: block;
        margin: 0 auto;
        color: #fff;
        width: 160px;
        height: 50px;
        line-height: 50px;
        background: #446CB3;
        font-size: 22px;
        border: 0;
        border-radius: 3px;
        cursor: pointer;
        text-align: center;
        box-shadow: 0 5px 5px -5px #333;
        transition: background 0.3s ease-in;

        &:hover {
            background: #365690;
        }
    }

    .modal-content,
    .modal-backdrop {
        height: 0;
        width: 0;
        opacity: 0;
        visibility: hidden;
        overflow: hidden;
        cursor: pointer;
        transition: opacity 0.2s ease-in;
    }

    .modal-close {
        color: #aaa;
        position: absolute;
        right: 5px;
        top: 5px;
        padding-top: 3px;
        background: #fff;
        font-size: 16px;
        width: 25px;
        height: 25px;
        font-weight: bold;
        text-align: center;
        cursor: pointer;

        &:hover {
            color: #333;
        }
    }

    .modal-content-btn {
        position: absolute;
        text-align: center;
        cursor: pointer;
        bottom: 20px;
        right: 30px;
        background: #446CB3;
        color: #fff;
        width: 50px;
        border-radius: 2px;
        font-size: 14px;
        height: 32px;
        padding-top: 9px;
        font-weight: normal;

        &:hover {
            color: #fff;
            background: #365690;
        }
    }

    #modal-toggle {
        display: none;

        &.active~.modal-backdrop,
        &:checked~.modal-backdrop {
            background-color: rgba(0, 0, 0, 0.6);
            width: 100vw;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 9;
            visibility: visible;
            opacity: 1;
            transition: opacity 0.2s ease-in;
        }

        &.active~.modal-content,
        &:checked~.modal-content {
            opacity: 1;
            background-color: #fff;
            max-width: 400px;
            width: 400px;
            height: 280px;
            padding: 10px 30px;
            position: fixed;
            left: calc(50% - 200px);
            top: 12%;
            border-radius: 4px;
            z-index: 999;
            pointer-events: auto;
            cursor: auto;
            visibility: visible;
            box-shadow: 0 3px 7px rgba(0, 0, 0, 0.6);

            @media (max-width: 400px) {
                left: 0;
            }
        }
    }
}
</style>


@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Pedidos</h3> <!-- Título de la página actualizado -->
    </div>
    @if(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <!-- Formulario de búsqueda -->
                            <div class="form-inline my-2 my-lg-0">
                                <input type="search" class="form-control mr-sm-2" id="searchInput"
                                    placeholder="Buscar por ID, Concepto o Total">
                            </div>
                            <!-- Botón para añadir nueva venta -->
                            @can('crear-ventas')
                            <a class="btn btn-success" href="{{ route('pedidos.create') }}">
                                <i class="fas fa-plus"></i> Nuevo
                            </a>
                            @endcan
                        </div>

                        <!-- Tabla de ventas -->

                        <div class="table-responsive">

                            <table class="table">
                                <thead style="background-color:#8B4513">
                                    <tr>
                                        <th class="text-center text-white">ID</th>
                                        <th class="text-center text-white">Concepto</th>
                                        <th class="text-center text-white">Total</th>
                                        <th class="text-center text-white">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">

                                    @foreach ($pedidos as $pedido)
                                    <tr>
                                        <td class="text-center">{{ $pedido->id }}</td>
                                        <td class="text-center">{{ $pedido->descripcion }}</td>
                                        <td class="text-center">{{ $pedido->total }}</td>
                                        <td class="text-center">
                                            <div>
                                                <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('¿Estás seguro de eliminar esta pedido?')">
                                                        <i class="fas fa-trash-alt"></i> Eliminar
                                                    </button>
                                                </form>
                                                <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-warning">Editar</a>
                                                <a class="btn btn-info" onclick="showModal({{ $pedido->id }})">Ver
                                                    Detalle</a>
                                                    <a href="{{ route('pedidos.pdf', $pedido->id) }}" class="btn btn-primary">Generar PDF</a>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div id="detalleVentaModal" class="custom-modal mt-5" style="margin-top:200px">
                            <div class="custom-modal-dialog">
                                <div class="custom-modal-content">
                                    <div class="custom-modal-header">
                                        <h5 class="custom-modal-title">Detalle del Pedido</h5>
                                        <button type="button" class="custom-modal-close"
                                            onclick="closeModal()">&times;</button>
                                    </div>
                                    <div class="custom-modal-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detalleVentaBody">
                                                <!-- Detalles de la venta se llenarán aquí -->
                                                <div class="custom-modal-footer">
                                        <p><strong>Extras:</strong> <span id="extrasInfo"></span></p>
                                        <p><strong>Dinero Extra:</strong> $<span id="dineroInfo"></span></p>
                                    </div>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="custom-modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            onclick="closeModal()">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <style>
                        .custom-modal {
                            display: none;
                            position: fixed;
                            z-index: 9999;
                            left: 0;
                            top: 0px;
                            margin:20px;
                            width: 100%;
                            height: 100%;
                            overflow: auto;
                            background-color: rgba(0, 0, 0, 0.5);
                        }

                        .custom-modal-dialog {
                            position: relative;
                            margin: auto;
                            padding: 20px;
                            border: 1px solid #888;
                            width: 80%;
                            max-width: 600px;
                            background-color: white;
                            border-radius: 8px;
                        }

                        .custom-modal-header,
                        .custom-modal-footer {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            padding: 10px;
                            background-color: white;
                        }

                        .custom-modal-title {
                            margin: 0;
                        }

                        .custom-modal-close {
                            background: none;
                            border: none;
                            font-size: 1.5rem;
                            cursor: pointer;
                        }

                        .custom-modal-body {
                            padding: 10px;
                            background-color: white;
                        }
                        </style>

                        <script>
                        function showModal(pedidoId) {
                            var modal = document.getElementById('detalleVentaModal');
                            modal.style.display = "block";

                            // Aquí puedes hacer la solicitud AJAX para obtener los detalles de la venta
                            // y llenar el contenido del modal.
                            $.ajax({
                                url: '/pedidos/' + pedidoId + '/detalles',
                                method: 'GET',
                                success: function(data) {
                                    var detalleVentaBody = document.getElementById('detalleVentaBody');
                                    detalleVentaBody.innerHTML = '';
                                    data.forEach(function(item) {
                                        detalleVentaBody.innerHTML += '<tr><td>' + item.producto +
                                            '</td><td>' + item.cantidad + '</td></tr>';
                                    });
                                }
                            });
                        }

                        function closeModal() {
                            var modal = document.getElementById('detalleVentaModal');
                            modal.style.display = "none";
                        }

                        // Opcional: cerrar el modal si el usuario hace clic fuera del contenido del modal
                        window.onclick = function(event) {
                            var modal = document.getElementById('detalleVentaModal');
                            if (event.target == modal) {
                                modal.style.display = "none";
                            }
                        }
                        </script>


                        <!-- Paginación -->
                        <div class="pagination justify-content-end">
                            {!! $pedidos->appends(request()->query())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
function showModal(pedidoId) {
    var modal = document.getElementById('detalleVentaModal');
    modal.style.display = "flex";

    // Solicitar los detalles del pedido, incluyendo extras y dinero extra
    $.ajax({
        url: '/pedidos/' + pedidoId + '/detalles',
        method: 'GET',
        success: function (data) {
            var detalleVentaBody = document.getElementById('detalleVentaBody');
            detalleVentaBody.innerHTML = '';
            data.productos.forEach(function (item) {
                detalleVentaBody.innerHTML += '<tr><td>' + item.producto + '</td><td>' + item.cantidad + '</td></tr>';
            });
            // Asumiendo que la respuesta también incluye 'extras' y 'dinero'
            var extrasInfo = document.getElementById('extrasInfo');
            extrasInfo.textContent = data.extras || 'No especificado'; // Maneja casos donde no hay extras
            var dineroInfo = document.getElementById('dineroInfo');
            dineroInfo.textContent = data.dinero || '0'; // Maneja casos donde no hay dinero extra
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar los detalles: " + error);
        }
    });
}

function closeModal() {
    var modal = document.getElementById('detalleVentaModal');
    modal.style.display = "none";
}

// Opcional: cerrar el modal si el usuario hace clic fuera del contenido del modal
window.onclick = function(event) {
    var modal = document.getElementById('detalleVentaModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#detalleVentaModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var ventaId = button.data('id');
        var modal = $(this);

        $.ajax({
            url: '/pedidos/' + pedidoId + '/detalles',
            method: 'GET',
            success: function(data) {
                var detalleVentaBody = $('#detalleVentaBody');
                detalleVentaBody.empty();
                data.forEach(function(item) {
                    detalleVentaBody.append('<tr><td>' + item.producto +
                        '</td><td>' + item.cantidad + '</td></tr>');
                });
            }
        });
    });
});
</script>

<script>
// Limpiar localStorage si la venta fue exitosa
@if(session('success'))
localStorage.removeItem('productosVenta');
localStorage.removeItem('cantidadesDisponibles');
@endif
</script>

<script>
const searchInput = document.getElementById('searchInput');
const tableBody = document.getElementById('tableBody');
const originalRows = tableBody.innerHTML; // Guardar el contenido original

searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    tableBody.innerHTML = originalRows; // Restaurar el contenido original

    const rows = tableBody.querySelectorAll('tr');
    rows.forEach(row => {
        const idCell = row.querySelector('td:nth-child(1)');
        const conceptoCell = row.querySelector('td:nth-child(2)');
        const totalCell = row.querySelector('td:nth-child(3)');

        const shouldShow =
            idCell.textContent.toLowerCase().includes(searchTerm) ||
            conceptoCell.textContent.toLowerCase().includes(searchTerm) ||
            totalCell.textContent.toLowerCase().includes(searchTerm);

        if (!shouldShow) {
            row.style.display = 'none';
        }
    });
});
</script>


<script>
function confirmarEliminacion(id) {
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
            document.getElementById('eliminar-form-' + id).submit();
            Swal.fire({
                title: 'Eliminado!',
                text: 'El ingrediente ha sido eliminado correctamente.',
                icon: 'success',
                timer: 4000,
                showConfirmButton: false
            });
        }
    });
}
</script>
@endsection