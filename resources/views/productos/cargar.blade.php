@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="alert alert-success text-center">
    {{ session('success') }}
</div>
@endif

<section class="section" style="min-height: 100vh; display: flex; align-items: center;">
    <div class="container custom-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h3 class="page__heading text-center">Cargar Productos</h3>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <form id="productosForm" action="{{ route('productos.charge') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="producto_select">Seleccionar Producto</label>
                                <select id="producto_select" class="form-control">
                                    <option value="" disabled selected>Seleccione un producto</option>
                                    @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="productosContainer">
                                @foreach($productos as $producto)
                                <div class="form-group product-input" id="producto_{{ $producto->id }}"
                                    style="display: none;">
                                    <label for="cantidad_{{ $producto->id }}">{{ $producto->nombre }}</label>
                                    <input type="number" name="cantidades[{{ $producto->id }}]" class="form-control"
                                        id="cantidad_{{ $producto->id }}" min="0" value="0">
                                </div>
                                @endforeach
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Actualizar Cantidades</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productoSelect = document.getElementById('producto_select');
    const productosContainer = document.getElementById('productosContainer');

    productoSelect.addEventListener('change', function() {
        // Ocultar todos los campos de entrada de cantidad
        const productInputs = productosContainer.querySelectorAll('.product-input');
        productInputs.forEach(function(input) {
            input.style.display = 'none';
        });

        // Mostrar el campo de entrada de cantidad para el producto seleccionado
        const productoId = this.value;
        const selectedProductInput = document.getElementById(`producto_${productoId}`);
        if (selectedProductInput) {
            selectedProductInput.style.display = 'block';
        }
    });
});
</script>
@endsection
