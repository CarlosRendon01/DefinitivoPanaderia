<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corte de Caja</title>
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
            <h1>Corte de Caja</h1>
        </div>

        <div class="details">
            <p>Fecha: {{ \Carbon\Carbon::today()->toDateString() }}</p>
            <p>Monto Inicial del Día: ${{ number_format($montoInicial, 2) }}</p>
        </div>

        <div class="ventas">
            @foreach($ventasDelDia as $venta)
                <div class="venta">
                    <div class="venta-header">
                        <p>ID: {{ $venta->id }}</p>
                        <p>Descripción: {{ $venta->descripcion }}</p>
                        <p>Total: ${{ number_format($venta->total, 2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="total">
            TOTAL DEL DÍA CON MONTO INICIAL: ${{ number_format($totalConInicial, 2) }}
        </div>

        <div class="total">
            INVERSIÓN RECUPERADA: ${{ number_format($totalVentas-$totalGanancia, 2) }}
        </div>

        <div class="total">
            GANANCIAS: ${{ number_format($totalGanancia, 2) }}
        </div>

        <div class="footer">
            <p>Reporte generado automáticamente.</p>
            <p>Gracias por utilizar nuestro sistema.</p>
        </div>
    </div>
</body>
</html>
