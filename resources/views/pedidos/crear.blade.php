@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Pedido</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Detalles del Pedido
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card-body">
                        <form id="pedidoForm" action="{{ route('pedidos.store') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="descripcion">Descripción</label>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion"
                                        placeholder="Descripción breve del pedido" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="dinero">Dinero Extra ($)</label>
                                    <input type="number" class="form-control" id="dinero" name="dinero" step="0.01" placeholder="Cantidad extra para sumar al total" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="extras">Extras</label>
                                    <textarea class="form-control" id="extras" name="extras" placeholder="Detalles adicionales" readonly></textarea>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="producto">Producto</label>
                                    <select id="producto" class="form-control">
                                        @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}" data-cantidad="{{ $producto->cantidad }}">
                                            {{ $producto->nombre }} - ${{ number_format($producto->precio, 2) }} - <span class="cantidad-disponible">{{ $producto->cantidad }}</span>
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidad">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-success btn-block"
                                        id="addProductButton">Agregar</button>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="materiaPrima">Materia Prima</label>
                                    <select id="materiaPrima" class="form-control">
                                        @foreach ($materiasPrimas as $materiaPrima)
                                        <option value="{{ $materiaPrima->id }}" data-precio="{{ $materiaPrima->precio }}" data-cantidad="{{ $materiaPrima->cantidad }}">
                                            {{ $materiaPrima->nombre }} - ${{ number_format($materiaPrima->precio, 2) }} - <span class="cantidad-disponible">{{ $materiaPrima->cantidad }}</span>
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cantidadMateriaPrima">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidadMateriaPrima">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="button" class="btn btn-warning btn-block"
                                        id="addMateriaPrimaButton">Agregar Materia Prima</button>
                                </div>
                            </div>
                            <div id="productosContainer"></div>
                            <input type="hidden" name="total" id="total">
                        </form>
                        <table class="table table-striped mt-2" id="productosTable">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="container mt-4">
                            <div class="d-flex justify-content-between align-items-center form-group">
                                <h5 class="mb-0">Total: $<span id="totalDisplay">0.00</span></h5>
                                <h6 class="mb-0 mx-2">Recibo: <input class="form-control d-inline-block w-auto" id="recibo" type="number"></h6>
                            </div>
                            <div class="d-flex justify-content-between align-items-center form-group">
                                <div class="ml-auto">
                                    <h6 class="mb-0 mx-2">Cambio: <input class="form-control d-inline-block w-auto" type="text" id="cambio" value="0.00" disabled></h6>
                                </div>
                            </div>
                        </div>
                        <button type="submit" form="pedidoForm" class="btn btn-primary">Guardar Pedido</button>
                        <a href="{{ route('pedidos.index') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('addProductButton').addEventListener('click', agregarProducto);
    document.getElementById('addMateriaPrimaButton').addEventListener('click', agregarMateriaPrima);
    cargarProductosDeLocalStorage();
    actualizarCantidadesDisponibles();

    function finalizarPedido() {
        if (parseFloat(document.getElementById('cambio').value) >= 0) {
            limpiarLocalStorage(); // Llama a la función para limpiar el almacenamiento local
            document.getElementById('pedidoForm').submit();
        } else {
            alert('El dinero recibido no es suficiente para cubrir el total del pedido.');
        }
    }    

    document.getElementById('pedidoForm').addEventListener('submit', function(event) {
        if (!validarRecibo()) {
            event.preventDefault();
        }
        actualizarFormulario();
        limpiarLocalStorage();
    });

    document.getElementById('recibo').addEventListener('input', function() {
        calcularCambio();
    });

    function agregarProducto() {
        const productoSelect = document.getElementById('producto');
        const selectedOption = productoSelect.options[productoSelect.selectedIndex];
        const productoId = selectedOption.value;
        const productoNombre = selectedOption.text.split(' - $')[0];
        const precio = parseFloat(selectedOption.getAttribute('data-precio'));
        const cantidadDisponible = parseInt(selectedOption.getAttribute('data-cantidad'));
        const cantidadInput = document.getElementById('cantidad');
        const cantidad = parseInt(cantidadInput.value);
        const subtotal = precio * cantidad;

        if (cantidad <= 0 || isNaN(cantidad)) {
            alert('Ingrese una cantidad válida.');
            return;
        }

        if (cantidad > cantidadDisponible) {
            alert('La cantidad ingresada excede la cantidad disponible del producto.');
            return;
        }

        const producto = {
            id: productoId,
            nombre: productoNombre,
            cantidad: cantidad,
            precio: precio,
            subtotal: subtotal.toFixed(2)
        };

        selectedOption.setAttribute('data-cantidad', cantidadDisponible - cantidad);
        const cantidadDisponibleSpan = selectedOption.querySelector('.cantidad-disponible');
        if (cantidadDisponibleSpan) {
            cantidadDisponibleSpan.textContent = cantidadDisponible - cantidad;
        }

        guardarEnLocalStorage(producto, 'productosPedido');
        actualizarCantidadesEnLocalStorage(productoId, cantidadDisponible - cantidad, 'cantidadesDisponibles');
        cantidadInput.value = '';
    }

    function agregarMateriaPrima() {
        const materiaPrimaSelect = document.getElementById('materiaPrima');
        const selectedOption = materiaPrimaSelect.options[materiaPrimaSelect.selectedIndex];
        const materiaPrimaId = selectedOption.value;
        const materiaPrimaNombre = selectedOption.text.split(' - $')[0];
        const precio = parseFloat(selectedOption.getAttribute('data-precio'));
        const cantidadDisponible = parseInt(selectedOption.getAttribute('data-cantidad'));
        const cantidadInput = document.getElementById('cantidadMateriaPrima');
        const cantidad = parseInt(cantidadInput.value);
        const subtotal = precio * cantidad;

        if (cantidad <= 0 || isNaN(cantidad)) {
            alert('Ingrese una cantidad válida.');
            return;
        }

        if (cantidad > cantidadDisponible) {
            alert('La cantidad ingresada excede la cantidad disponible de la materia prima.');
            return;
        }

        const materiaPrima = {
            id: materiaPrimaId,
            nombre: materiaPrimaNombre,
            cantidad: cantidad,
            precio: precio,
            subtotal: subtotal.toFixed(2)
        };

        selectedOption.setAttribute('data-cantidad', cantidadDisponible - cantidad);
        const cantidadDisponibleSpan = selectedOption.querySelector('.cantidad-disponible');
        if (cantidadDisponibleSpan) {
            cantidadDisponibleSpan.textContent = cantidadDisponible - cantidad;
        }

        guardarEnLocalStorage(materiaPrima, 'materiasPrimasPedido');
        actualizarCantidadesEnLocalStorage(materiaPrimaId, cantidadDisponible - cantidad, 'cantidadesMateriaPrima');
        actualizarDineroExtra();
        cantidadInput.value = '';
    }

    function guardarEnLocalStorage(item, key) {
        let items = JSON.parse(localStorage.getItem(key)) || [];
        let itemExistente = items.find(p => p.id === item.id);

        if (itemExistente) {
            itemExistente.cantidad += item.cantidad;
            itemExistente.subtotal = (itemExistente.cantidad * itemExistente.precio).toFixed(2);
        } else {
            items.push(item);
        }

        localStorage.setItem(key, JSON.stringify(items));
        actualizarTabla();
        actualizarTotal();
        actualizarFormulario();
    }

    function actualizarCantidadesEnLocalStorage(itemId, nuevaCantidad, key) {
        let cantidades = JSON.parse(localStorage.getItem(key)) || {};
        cantidades[itemId] = nuevaCantidad;
        localStorage.setItem(key, JSON.stringify(cantidades));
    }

    function cargarProductosDeLocalStorage() {
        const productos = JSON.parse(localStorage.getItem('productosPedido')) || [];
        productos.forEach(agregarFilaATabla);
        const materiasPrimas = JSON.parse(localStorage.getItem('materiasPrimasPedido')) || [];
        materiasPrimas.forEach(agregarFilaATabla);
        actualizarTotal();
    }

    function actualizarCantidadesDisponibles() {
        const cantidades = JSON.parse(localStorage.getItem('cantidadesDisponibles')) || {};
        const productoSelect = document.getElementById('producto').options;

        for (let i = 0; i < productoSelect.length; i++) {
            const option = productoSelect[i];
            const itemId = option.value;
            if (cantidades[itemId] !== undefined) {
                const cantidadDisponible = cantidades[itemId];
                option.setAttribute('data-cantidad', cantidadDisponible);
                const cantidadDisponibleSpan = option.querySelector('.cantidad-disponible');
                if (cantidadDisponibleSpan) {
                    cantidadDisponibleSpan.textContent = cantidadDisponible;
                }
            }
        }

        const cantidadesMateriaPrima = JSON.parse(localStorage.getItem('cantidadesMateriaPrima')) || {};
        const materiaPrimaSelect = document.getElementById('materiaPrima').options;

        for (let i = 0; i < materiaPrimaSelect.length; i++) {
            const option = materiaPrimaSelect[i];
            const itemId = option.value;
            if (cantidadesMateriaPrima[itemId] !== undefined) {
                const cantidadDisponible = cantidadesMateriaPrima[itemId];
                option.setAttribute('data-cantidad', cantidadDisponible);
                const cantidadDisponibleSpan = option.querySelector('.cantidad-disponible');
                if (cantidadDisponibleSpan) {
                    cantidadDisponibleSpan.textContent = cantidadDisponible;
                }
            }
        }
    }

    window.removeProduct = function(element, id) {
        var row = element.closest('tr');
        if (!row) {
            console.error("No se encontró la fila.");
            return;
        }

        row.remove();

        let productos = JSON.parse(localStorage.getItem('productosPedido')) || [];
        productos = productos.filter(producto => producto.id.toString() !== id.toString());
        localStorage.setItem('productosPedido', JSON.stringify(productos));

        let materiasPrimas = JSON.parse(localStorage.getItem('materiasPrimasPedido')) || [];
        materiasPrimas = materiasPrimas.filter(materiaPrima => materiaPrima.id.toString() !== id.toString());
        localStorage.setItem('materiasPrimasPedido', JSON.stringify(materiasPrimas));

        actualizarTabla();
        actualizarTotal();
        actualizarFormulario();
        actualizarCantidadesDisponibles();
        actualizarDineroExtra();
    }

    function actualizarTabla() {
        const tbody = document.getElementById('productosTable').querySelector('tbody');
        tbody.innerHTML = '';

        let productos = JSON.parse(localStorage.getItem('productosPedido')) || [];
        productos.forEach(producto => agregarFilaATabla(producto));

        let materiasPrimas = JSON.parse(localStorage.getItem('materiasPrimasPedido')) || [];
        materiasPrimas.forEach(materiaPrima => agregarFilaATabla(materiaPrima));
    }

    function agregarFilaATabla(item) {
        const tbody = document.getElementById('productosTable').querySelector('tbody');
        const row = document.createElement('tr');
        row.innerHTML = `
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(this, '${item.id}')">Eliminar</button></td>
        <td>${item.nombre}</td>
        <td>${item.cantidad}</td>
        <td>$${item.precio}</td>
        <td>$${item.subtotal}</td>
        `;
        tbody.appendChild(row);
    }

    function actualizarTotal() {
        let productos = JSON.parse(localStorage.getItem('productosPedido')) || [];
        let total = productos.reduce((sum, producto) => sum + parseFloat(producto.subtotal), 0);
        let dineroExtra = parseFloat(document.getElementById('dinero').value) || 0;
        total += dineroExtra;
        document.getElementById('totalDisplay').textContent = total.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
    }

    function actualizarFormulario() {
        const productosContainer = document.getElementById('productosContainer');
        productosContainer.innerHTML = '';

        let productos = JSON.parse(localStorage.getItem('productosPedido')) || [];
        productos.forEach(producto => {
            let inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'productos[' + producto.id + '][id]';
            inputId.value = producto.id;

            let inputCantidad = document.createElement('input');
            inputCantidad.type = 'hidden';
            inputCantidad.name = 'productos[' + producto.id + '][cantidad]';
            inputCantidad.value = producto.cantidad;

            productosContainer.appendChild(inputId);
            productosContainer.appendChild(inputCantidad);
        });

        let materiasPrimas = JSON.parse(localStorage.getItem('materiasPrimasPedido')) || [];
        materiasPrimas.forEach(materiaPrima => {
            let inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'materiasPrimas[' + materiaPrima.id + '][id]';
            inputId.value = materiaPrima.id;

            let inputCantidad = document.createElement('input');
            inputCantidad.type = 'hidden';
            inputCantidad.name = 'materiasPrimas[' + materiaPrima.id + '][cantidad]';
            inputCantidad.value = materiaPrima.cantidad;

            productosContainer.appendChild(inputId);
            productosContainer.appendChild(inputCantidad);
        });
    }

    function actualizarDineroExtra() {
        let materiasPrimas = JSON.parse(localStorage.getItem('materiasPrimasPedido')) || [];
        let totalMateriaPrima = materiasPrimas.reduce((sum, materiaPrima) => sum + parseFloat(materiaPrima.subtotal), 0);
        document.getElementById('dinero').value = totalMateriaPrima.toFixed(2);
        document.getElementById('extras').value = JSON.stringify(materiasPrimas.map(mp => mp.nombre + ' x ' + mp.cantidad));
        actualizarTotal();
    }

    function calcularCambio() {
        const total = parseFloat(document.getElementById('total').value);
        const recibo = parseFloat(document.getElementById('recibo').value);
        const cambio = recibo - total;

        if (!isNaN(cambio) && cambio >= 0) {
            document.getElementById('cambio').value = cambio.toFixed(2);
        } else {
            document.getElementById('cambio').value = '0.00';
        }
    }

    function limpiarLocalStorage() {
        localStorage.removeItem('productosPedido');
        localStorage.removeItem('materiasPrimasPedido');
        localStorage.removeItem('cantidadesDisponibles');
        localStorage.removeItem('cantidadesMateriaPrima');
    }

    function validarRecibo() {
        const total = parseFloat(document.getElementById('total').value);
        const recibo = parseFloat(document.getElementById('recibo').value);

        if (isNaN(recibo) || recibo < total) {
            alert('El monto recibido es incorrecto. Debe ser mayor o igual al total.');
            return false;
        }
        return true;
    }

    @if(session('pedido_exitosa'))
    localStorage.removeItem('productosPedido');
    localStorage.removeItem('materiasPrimasPedido');
    localStorage.removeItem('cantidadesDisponibles');
    localStorage.removeItem('cantidadesMateriaPrima');
    @endif
});
</script>
