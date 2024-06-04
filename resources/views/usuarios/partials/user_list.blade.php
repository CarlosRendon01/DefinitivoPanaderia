<table class="table table-striped mt-2" id="miTabla2">
    <thead style="background-color:#5f42d4">
        <tr>
            <th style="color:#fff;" class="text-center">Nombre</th>
            <th style="color:#fff;" class="text-center" >E-mail</th>
            <th style="color:#fff;" class="text-center">Rol</th>
            <th style="color:#fff;" class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $usuario)
        <tr>
            <td class="text-center">{{ $usuario->name }}</td>
            <td class="text-center">{{ $usuario->email }}</td>
            <td class="text-center">
                @foreach($usuario->getRoleNames() as $rolNombre)
                <h5><span class="badge custom-badge">{{ $rolNombre }}</span></h5>
                @endforeach
            </td>
            <td class="text-center">
                @can('editar-usuario')
                <a href="{{ route('usuarios.edit', $usuario->id) }}"
                    class="btn btn-warning mr-1 css-button-sliding-to-left--yellow">
                    <i class="fas fa-edit"></i>Editar
                </a>
                @endcan

                @can('eliminar-usuario')
                <button type="button" class="btn btn-danger css-button-sliding-to-left--red" onclick="confirmarEliminacion({{ $usuario->id }})">
                    <i class="fas fa-trash-alt"></i>
                    Eliminar
                </button>
                <form id="eliminar-form-{{ $usuario->id }}" action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="pagination justify-content-end">
    {!! $usuarios->links() !!}
</div>
