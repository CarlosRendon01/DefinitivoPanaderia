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

.btn {
    font-size: 0.9rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    transition: all 0.3s ease-in-out;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0069d9;
    border-color: #0062cc;
}

.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #212529;
}

.btn-warning:hover {
    background-color: #e0a800;
    border-color: #d39e00;
    color: #212529;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

/* Estilos para la paginación */
.pagination {
    margin-bottom: 0;
}

.page-link {
    color: #007bff;
    background-color: #fff;
    border-color: #dee2e6;
    transition: all 0.3s ease-in-out;
}

.page-link:hover {
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.page-item.active .page-link {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
}
</style>
@section('content')
<div class="container">
    <h1 class="text-center my-4">Productos</h1>

    @if(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif
   
    <div class="d-flex justify-content-center align-items-center mb-5">
    @can('crear-producto')
        <a class="btn btn-info mx-3" href="{{ route('productos.create') }}">
            <i class="fas fa-plus"></i> Crear Producto
        </a>

        <a class="btn btn-info" href="{{ route('productos.showChargeForm') }}">
            <i class="fas fa-plus"></i> Cargar Producto
        </a>
        @endcan

    </div>

    <div class="row justify-content-center">
        @foreach($productos as $producto)
        <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
            <div class="card border-0 rounded-0 shadow">
                <div class="card-img-top d-flex justify-content-center align-items-center" style="height: 150px;">
                    @if($producto->imagen_url)
                    <img src="{{ asset('storage/' . $producto->imagen_url) }}" class="img-fluid"
                        style="object-fit: cover; max-height: 100%; transition: transform 0.5s ease;"
                        onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"
                        alt="{{ $producto->nombre }}">
                    @else
                    <img src="https://via.placeholder.com/150" class="img-fluid"
                        style="object-fit: cover; max-height: 100%; transition: transform 0.5s ease;"
                        onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"
                        alt="{{ $producto->nombre }}">
                    @endif
                </div>

                <div class="card-body d-flex flex-column">
                    <h4 class="text">{{ $producto->nombre }}</h4>
                    <p class="mb-0"><strong>Cantidad:</strong> {{ $producto->cantidad }}</p>
                    <p class="text-truncate">{{ $producto->descripcion }}</p>

                    <div class="">
                        <h5 class="display-5">${{ number_format($producto->precio, 2) }}</h5>
                        @can('editar-producto')
                        <a href="{{ route('productos.edit', $producto->id) }}"
                            class="btn btn-primary mb-1 p-2 rounded-0 w-100">Editar</a>
                            @endcan
                            @can('borrar-producto')
                                                    <button type="button" class="btn btn-danger p-2 rounded-0 w-100"
                                                        onclick="confirmarEliminacion({{ $producto->id }})">
                                                        <i class="fas fa-trash-alt"></i> Eliminar
                                                    </button>
                                                    <form id="eliminar-form-{{ $producto->id }}"
                                                        action="{{ route('productos.destroy', $producto->id) }}" method="POST"
                                                        class="w-100">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    @endcan
                        @can('editar-producto')
                        <button class="btn btn-secondary mt-auto w-100" data-toggle="modal"
                            data-target="#materiaModal{{ $producto->id }}">Ver Materias Primas</button>
                            @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="materiaModal{{ $producto->id }}" tabindex="-1" role="dialog"
            aria-labelledby="materiaModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="materiaModalLabel">Materias Primas de {{ $producto->nombre }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-unstyled">
                            @foreach ($producto->materias as $materia)
                            <li>{{ $materia->nombre }} ({{ $materia->pivot->cantidad }} {{ $materia->unidad }})</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $productos->links() }}
    </div>
    
</div>


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
                text: 'El producto ha sido eliminado correctamente.',
                icon: 'success',
                timer: 4000,
                showConfirmButton: false
            });
        }
    });
}
</script>
@endsection