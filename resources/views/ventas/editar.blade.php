@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-md-8">
                <div class="card-header d-flex align-items-center justify-content-between bg-primary text-white">
                    <a href="{{ url()->previous() }}" class="btn btn-pink text-white">
                        <i class="fas fa-arrow-left mr-2"></i> Regresar
                    </a>
                    <h3 class="page__heading text-center flex-grow-1 m-0">
                        <i class="fas fa-shopping-cart" mr-2"></i> Editar Venta
                    </h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('ventas.update', $venta->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion"
                                value="{{ $venta->descripcion }}" required>
                        </div>

                        <!-- Eliminar el campo de total -->

                        <div class="form-group">
                            <label>Productos</label>
                            @foreach($venta->productos as $producto)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>{{ $producto->nombre }}</div>
                                <div>
                                    <input type="number" class="form-control"
                                        name="productos[{{ $producto->id }}][cantidad]"
                                        value="{{ $producto->pivot->cantidad }}" min="1" style="width: 100px;">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar Venta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection