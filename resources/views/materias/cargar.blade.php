@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="alert alert-success text-center">
    {{ session('success') }}
</div>
@endif

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
                            <i class="fas fa-cubes mr-2"></i>Cargar Materias
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

                        <form action="{{ route('materias.charge') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="materia_select">Seleccionar Materia</label>
                                <select id="materia_select" class="form-control">
                                    <option value="" disabled selected>Seleccione una materia</option>
                                    @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="materiasContainer">
                                @foreach($materias as $materia)
                                <div class="form-group materia-input" id="materia_{{ $materia->id }}"
                                    style="display: none;">
                                    <label for="unidad_{{ $materia->id }}">{{ $materia->nombre }}</label>
                                    <select name="unidades[{{ $materia->id }}]" class="form-control mb-2" disabled>
                                        <option value="gramos" {{ $materia->unidad == 'gramos' ? 'selected' : '' }}>
                                            Bulto de 50kg (gramos)</option>
                                        <option value="mililitros"
                                            {{ $materia->unidad == 'mililitros' ? 'selected' : '' }}>Litros (mililitros)
                                        </option>
                                        <option value="piezas" {{ $materia->unidad == 'piezas' ? 'selected' : '' }}>Caja
                                            de 360 piezas</option>
                                        <option value="individual"
                                            {{ $materia->unidad == 'individual' ? 'selected' : '' }}>Piezas individuales
                                        </option>
                                    </select>
                                    <input type="hidden" name="unidades[{{ $materia->id }}]"
                                        value="{{ $materia->unidad }}">
                                    <input type="number" name="cantidades[{{ $materia->id }}]" class="form-control"
                                        min="0" value="0">
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
    const materiaSelect = document.getElementById('materia_select');
    const materiasContainer = document.getElementById('materiasContainer');

    materiaSelect.addEventListener('change', function() {
        // Ocultar todos los campos de entrada de cantidad
        const materiaInputs = materiasContainer.querySelectorAll('.materia-input');
        materiaInputs.forEach(function(input) {
            input.style.display = 'none';
        });

        // Mostrar el campo de entrada de cantidad para la materia seleccionada
        const materiaId = this.value;
        const selectedMateriaInput = document.getElementById(`materia_${materiaId}`);
        if (selectedMateriaInput) {
            selectedMateriaInput.style.display = 'block';
        }
    });
});
</script>
@endsection