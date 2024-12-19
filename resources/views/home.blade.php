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
        background-color: #8e44ad;
        /* Color morado */
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
        background-color: #732d91;
        /* Color morado oscuro */
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
        margin-bottom: 20px;
        /* Espacio entre columnas */
    }

    .custom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0px;
        margin: 20px;
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

@section('content')
@can('ver-dashboard')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Dashboard</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-xl-3">
                                <div class="card card-custom bg-primary text-white shadow">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Pedidos Pendientes</h5>
                                        <h2 class="text-center">{{ $totalPedidos }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <div class="card card-custom bg-primary text-white shadow">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Pedidos Para Hoy</h5>
                                        <h2 class="text-center">{{ $totalPedidosHoy }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <div class="card card-custom bg-primary text-white shadow">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Total En Pedidos Hoy</h5>
                                        <h2 class="text-center">${{ number_format($totalAcumuladoHoy, 2) }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <div class="card card-custom bg-primary text-white shadow">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Productos Para Pedidos</h5>
                                        <h2 class="text-center">{{ $totalProductosVendidosHoy }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Pedidos de Hoy</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Descripción</th>
                                                <th>Total</th>
                                                <th>Fecha</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pedidosHoy as $pedido)
                                            <tr>
                                                <td>{{ $pedido->id }}</td>
                                                <td>{{ $pedido->descripcion }}</td>
                                                <td>${{ number_format($pedido->total, 2) }}</td>
                                                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <button onclick="showModal({{ $pedido->id }})"
                                                        class="btn btn-info btn-sm">Detalles</button>
                                                    <button
                                                        onclick="showTerminarModal({{ $pedido->id }}, {{ $pedido->total }})"
                                                        class="btn btn-primary btn-sm">Terminar</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Modales -->
                        <div id="terminarPedidoModal" class="custom-modal" style="display: none;">
                            <div class="custom-modal-dialog">
                                <div class="custom-modal-content">
                                    <div class="custom-modal-header">
                                        <h5 class="custom-modal-title">Finalizar Pedido</h5>
                                        <button type="button" class="custom-modal-close" onclick="closeTerminarModal()">&times;</button>
                                    </div>
                                    <form id="terminarPedidoForm" method="POST" action="{{ url('pedidos/' . $pedido->id . '/finalizar') }}">
                                        @csrf
                                        <div class="custom-modal-body">
                                            <p><strong>Total del Pedido:</strong> $<span id="totalPedido"></span></p>
                                            <p><strong>Falta la mitad:</strong> $<span id="mitadPedido"></span></p>
                                            <div class="form-group">
                                                <label for="pagoPedido"><strong>Ingrese el pago:</strong></label>
                                                <input type="number" id="pagoPedido" name="pago" class="form-control" min="0" step="0.01" placeholder="Ingrese el monto" value="{{ old('pago') }}">
                                            </div>
                                            @if ($errors->has('error'))
                                                <div style="color: red; margin-top: 10px;">
                                                    {{ $errors->first('error') }}
                                                </div>
                                            @endif
                                            @if (session('success'))
                                                <div style="color: green; margin-top: 10px;">
                                                    {{ session('success') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="custom-modal-footer">
                                            <button type="button" class="btn btn-secondary" onclick="closeTerminarModal()">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Procesar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@else
<div class="welcome-section">
    <h1 class="welcome-title">Bienvenido al Sistema</h1>
    <p class="welcome-message">Explora nuestras funcionalidades.</p>
</div>
@endcan
@endsection

<script>
   function showTerminarModal(pedidoId, totalPedido) {
    var modal = document.getElementById('terminarPedidoModal');
    modal.style.display = "block";

    document.getElementById('totalPedido').innerText = totalPedido.toFixed(2);
    document.getElementById('mitadPedido').innerText = (totalPedido / 2).toFixed(2);
}

function closeTerminarModal() {
    var modal = document.getElementById('terminarPedidoModal');
    modal.style.display = "none";
}

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">