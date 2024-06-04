@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="page__heading">Editar Pedido</h3>
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

                <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $pedido->descripcion }}" required>
                    </div>

                    <div class="form-group">
                        <label for="extras">Extras</label>
                        <textarea class="form-control" id="extras" name="extras" rows="4">{{ $pedido->extras }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="dinero">Dinero Extra ($)</label>
                        <input type="number" class="form-control" id="dinero" name="dinero" step="0.01" value="{{ $pedido->dinero }}" placeholder="Cantidad extra para sumar al total">
                    </div>

                    <div class="form-group">
                        <label>Productos</label>
                        @foreach($pedido->productos as $producto)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>{{ $producto->nombre }}</div>
                                <div>
                                    <input type="number" class="form-control" name="productos[{{ $producto->id }}][cantidad]" value="{{ $producto->pivot->cantidad }}" min="1" style="width: 100px;">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
