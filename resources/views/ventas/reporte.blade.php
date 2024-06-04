<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .report {
            width: 400px; /* Ancho ajustado */
            margin: 20px auto;
            padding: 30px;
            border: 1px solid #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 32px; /* Tamaño de fuente ajustado */
            margin: 0;
            font-weight: bold;
        }

        .details {
            font-size: 14px;
            margin-bottom: 25px;
        }

        .details p {
            margin: 5px 0;
        }

        .ventas {
            font-size: 14px;
            margin-bottom: 15px;
        }

        .venta {
            margin-bottom: 15px;
        }

        .venta-header {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .productos {
            margin-left: 15px;
        }

        .producto {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .total {
            font-size: 16px; /* Tamaño de fuente ajustado */
            font-weight: bold;
            text-align: right;
            margin-top: 15px;
        }

        .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
        }

        .report::after {
            content: '';
            display: block;
            margin-top: 20px;
            border-top: 1px dashed #000;
        }
    </style>
</head>
<body>
    <div class="report">
        <div class="header">
            <h1>Reporte de Ventas</h1>
        </div>

        <div class="details">
        <h2 class="mb-2">Panadería "El Triunfo"</h2>

            @if(isset($fecha_inicio) && isset($fecha_fin))
                <p>Desde: {{ $fecha_inicio }} hasta {{ $fecha_fin }}</p>
            @else
                <p>Fecha: {{ now()->toDateString() }}</p>
            @endif
            <p>Hora: {{ now()->toTimeString() }}</p>
            <p>Transacciones realizadas: {{ $num_transacciones }}</p>
            <p>Responsable: <b>Administrador</b> </p>
        </div>

        <div class="ventas">
            @foreach($ventas as $venta)
                <div class="venta">
                    <div class="venta-header">
                        <p>ID: {{ $venta->id }}</p>
                        <p>Descripción: {{ $venta->descripcion }}</p>
                        <p>Total: ${{ number_format($venta->total, 2) }}</p>
                    </div>
                    <div class="productos">
                        <p>Productos Vendidos:</p>
                        @foreach($venta->productos as $producto)
                            <div class="producto">
                                <span>{{ $producto->pivot->cantidad }} x {{ $producto->nombre }}</span>
                                <span>${{ number_format($producto->pivot->cantidad * $producto->precio, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="total">
            TOTAL DE VENTAS: ${{ number_format($total, 2) }}
        </div>

        <div class="footer">
            <p>Reporte generado automáticamente.</p>
            <p>Gracias por utilizar nuestro sistema.</p>
        </div>
    </div>
</body>
</html>
