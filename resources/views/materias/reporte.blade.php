<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Compras de Materia Prima</title>
</head>
<body>
    <h1>Reporte de Compras de Materia Prima</h1>
    @if(isset($fecha_inicio) && isset($fecha_fin))
        <p>Desde: {{ $fecha_inicio }} hasta {{ $fecha_fin }}</p>
    @else
        <p>Fecha: {{ now()->toDateString() }}</p>
    @endif
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Proveedor</th>
                <th>Precio Unitario</th>
                <th>Unidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materias as $materia)
                <tr>
                    <td>{{ $materia->id }}</td>
                    <td>{{ $materia->nombre }}</td>
                    <td>{{ $materia->cantidad }}</td>
                    <td>{{ $materia->proveedor }}</td>
                    <td>${{ number_format($materia->precio, 2) }}</td>
                    <td>{{ $materia->unidad }}</td>
                    <td>${{ number_format($materia->cantidad * $materia->precio, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
