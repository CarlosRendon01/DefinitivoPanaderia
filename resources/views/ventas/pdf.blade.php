<!DOCTYPE html>
<html>
<head>
    <title>Ticket de Pago</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .ticket {
            width: 400px; /* Ancho aumentado */
            margin: 20px auto;
            padding: 30px; /* Padding aumentado */
            border: 1px solid #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 180px;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 32px; /* Tamaño de fuente aumentado */
            margin: 0;
            font-weight: bold;
        }

        .details {
            font-size: 14px; /* Tamaño de fuente aumentado */
            margin-bottom: 25px;
        }

        .details p {
            margin: 5px 0;
        }

        .items {
            font-size: 14px; /* Tamaño de fuente aumentado */
            margin-bottom: 15px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .total {
            font-size: 16px; /* Tamaño de fuente aumentado */
            font-weight: bold;
            text-align: right;
            margin-top: 15px;
        }

        .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
        }

        /* Estilo de ticket */
        .ticket::after {
            content: '';
            display: block;
            margin-top: 20px; /* Espacio aumentado */
            border-top: 1px dashed #000; /* Línea más fina */
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>Ticket de Pago</h1>
        </div>

        <div class="details">
            <h2 class="mb-2">Panadería "El Triunfo"</h2>
            <p>Dirección: [Dirección de la Panadería]</p>
            <p>Tel: 9514785623</p>
            <p>Fecha: {{ $venta->created_at }}</p>
            <p>Hora: {{ date('H:i:s') }}</p>
            <p>Ticket: #{{ $venta->id }}</p>
        </div>

        <div class="items">
            @foreach ($productos as $producto)
            <div class="item">
                <span><strong>{{ $producto->pivot->cantidad }} {{ $producto->nombre }}</strong></span>
                <span><strong>${{ number_format($producto->pivot->cantidad * $producto->precio, 2) }}</strong></span>
            </div>
            @endforeach
        </div>

        <div class="total">
            TOTAL: ${{ number_format($venta->total, 2) }}
        </div>

        <div class="footer">
            <p>Gracias por su compra.</p>
            <p>¡Vuelva pronto!</p>
            <p>[Mensaje promocional opcional]</p>
        </div>
    </div>
</body>
</html>
