<!-- resources/views/productos/edit.blade.php -->

@extends('layouts.app')

@section('content')
<section class="section" style="background-color: #e0e0eb; min-height: 100vh; display: flex; align-items: center;">
    <div class="container custom-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header d-flex align-items-center justify-content-between bg-primary text-white">
                        <a href="{{ url()->previous() }}" class="btn btn-back text-white">
                            <i class="fas fa-arrow-left mr-2"></i> Regresar
                        </a>
                        <h3 class="page__heading text-center flex-grow-1 m-0">
                            <i class="fas fa-box-open mr-2"></i> Editar Producto
                        </h3>
                    </div>

                    <div class="card-body p-4 bg-white">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('productos.update', $producto->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" class="form-control" id="nombre"
                                    value="{{ $producto->nombre }}" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" class="form-control" id="descripcion"
                                    required>{{ $producto->descripcion }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" name="cantidad" class="form-control" id="cantidad"
                                    value="{{ $producto->cantidad }}" required>
                            </div>
                            <div class="form-group">
                                <label for="imagen">Imagen</label>
                                @if ($producto->imagen_url)
                                <div>
                                    <img src="{{ asset('storage/' . $producto->imagen_url) }}"
                                        alt="{{ $producto->nombre }}" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                                @endif
                                <input type="file" name="imagen" class="form-control-file" id="imagen">
                            </div>
                            <div class="form-group">
                                <label for="materias_primas">Materias Primas</label>
                                <div id="materias-primas-container">
                                    @foreach($producto->materias as $materia)
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <select name="materias_primas[]" class="form-control" required>
                                                <option value="">Seleccionar materia prima</option>
                                                @foreach($materias as $materiaPrima)
                                                <option value="{{ $materiaPrima->id }}" @if($materia->id ==
                                                    $materiaPrima->id) selected @endif>{{ $materiaPrima->nombre }}({{
                                                    $materiaPrima->unidad }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="cantidades[]" class="form-control"
                                                value="{{ $materia->pivot->cantidad }}" min="1" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button"
                                                class="btn btn-danger remove-materia-prima">Eliminar</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-materia-prima" class="btn btn-secondary mt-2">Añadir
                                    Materia
                                    Prima</button>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('add-materia-prima').addEventListener('click', function() {
        const container = document.getElementById('materias-primas-container');
        const existingSelections = Array.from(container.querySelectorAll('select[name="materias_primas[]"]')).map(select => select.value);
        const row = document.createElement('div');
        row.classList.add('row', 'mb-2');

        let optionsHtml = '<option value="">Seleccionar materia prima</option>';
        @foreach($materias as $materiaPrima)
        if (!existingSelections.includes('{{ $materiaPrima->id }}')) {
            optionsHtml += `<option value="{{ $materiaPrima->id }}">{{ $materiaPrima->nombre }}</option>`;
        }
        @endforeach

        row.innerHTML = `
            <div class="col-md-6">
                <select name="materias_primas[]" class="form-control" required>${optionsHtml}</select>
            </div>
            <div class="col-md-4">
                <input type="number" name="cantidades[]" class="form-control" placeholder="Cantidad" min="1" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-materia-prima">Eliminar</button>
            </div>
        `;
        if (optionsHtml.length > 53) { // Check if there are options available
            container.appendChild(row);
        } else {
            alert("Todas las materias primas han sido seleccionadas.");
        }
    });

    document.getElementById('materias-primas-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-materia-prima')) {
            e.target.closest('.row').remove();
        }
    });
});
</script>
@endsection