@extends('layouts.app')

<style>
/* Estilos generales */
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f9fa;
}

.container {
    max-width: 960px;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    font-weight: 500;
}

.form-control {
    border-radius: 0.25rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0069d9;
    border-color: #0062cc;
}
</style>

@section('content')
<section class="section">
    <div class="container">
        <h1 class="my-4">Crear Nuevo Producto</h1>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data"
            onsubmit="return validateMateriasPrimas()">
            @csrf
            {{-- Campos existentes (nombre, descripcion, precio, cantidad, imagen) --}}
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre"
                    value="{{ old('nombre') }}">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" class="form-control" id="descripcion"
                    required>{{ old('descripcion') }}</textarea>
            </div>
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" class="form-control" id="cantidad" value="{{ old('cantidad') }}"
                    required>
            </div>
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" class="form-control-file" id="imagen">
            </div>
            {{-- Campos para materias primas --}}
            <div class="form-group">
                <label for="materias_primas">Agregar Materia Prima</label>
                <div id="materias-primas-container">
                    <div class="materia-prima-row row mb-2">
                        <div class="col-md-6">
                            <select name="materias_primas[]" class="form-control" required>
                                <option value="">Seleccionar materia prima</option>
                                @foreach ($materiasPrimas as $materiaPrima)
                                <option value="{{ $materiaPrima->id }}">{{ $materiaPrima->nombre }}
                                    ({{ $materiaPrima->unidad }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="cantidades[]" class="form-control" placeholder="Cantidad" min="1"
                                required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-materia-prima">Eliminar</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-materia-prima" class="btn btn-secondary mt-2">Añadir Materia
                    Prima</button>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</section>

<script>
document.getElementById('add-materia-prima').addEventListener('click', () => {
    const container = document.getElementById('materias-primas-container');
    const existingSelections = Array.from(container.querySelectorAll('select[name="materias_primas[]"]')).map(
        select => select.value);
    const row = document.createElement('div');
    row.classList.add('materia-prima-row', 'row', 'mb-2');
    let optionsHtml = '<option value="">Seleccionar materia prima</option>';
    @foreach($materiasPrimas as $materiaPrima)
    if (!existingSelections.includes('{{ $materiaPrima->id }}')) {
        optionsHtml +=
            `<option value="{{ $materiaPrima->id }}">{{ $materiaPrima->nombre }} ({{ $materiaPrima->unidad_estandar }})</option>`;
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

document.getElementById('materias-primas-container').addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-materia-prima')) {
        e.target.closest('.materia-prima-row').remove();
    }
});

document.querySelector('form').addEventListener('submit', function(event) {
    const materiaPrimaSelects = document.querySelectorAll('select[name="materias_primas[]"]');
    let isValid = false;
    materiaPrimaSelects.forEach(select => {
        if (select.value !== '') isValid = true;
    });

    if (!isValid) {
        event.preventDefault(); // Detener el envío del formulario
        alert('Por favor, añade al menos una materia prima.');
    }
});
</script>
@endsection