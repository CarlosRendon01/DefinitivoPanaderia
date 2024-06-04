<!DOCTYPE html>
<html>
<head>
    <title>Ticket de Pedido</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }
        .ticket {
            width: 400px;
            margin: 20px auto;
            padding: 30px;
            border: 1px solid #000;
        }
        .header, .details, .items, .total, .footer, .extras {
            text-align: center;
            margin-bottom: 20px;
        }
        h1, h2 {
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        p {
            margin: 5px 0;
        }
        .items, .total {
            text-align: right;
        }
        .item {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>Pedido #{{ $pedido->id }}</h1>
        </div>
        <div class="details">
            <h2>Panadería "El Triunfo"</h2>
            <p>Dirección: [Dirección]</p>
            <p>Tel: 9514785623</p>
            <p>Fecha: {{ $pedido->created_at->format('d/m/Y') }}</p>
            <p>Hora: {{ $pedido->created_at->format('H:i') }}</p>
        </div>
        <div class="items">
            @foreach ($productos as $producto)
            <div class="item">
                <span>{{ $producto->pivot->cantidad }}x {{ $producto->nombre }}</span>
                <span>${{ number_format($producto->pivot->cantidad * $producto->precio, 2) }}</span>
            </div>
            @endforeach
        </div>
        <div class="extras">
            <p><strong>Extras:</strong> {{ $extras }}</p>
            <p><strong>Dinero Extra:</strong> ${{ number_format($dinero, 2) }}</p>
        </div>
        <div class="total">
            <h2>TOTAL: ${{ number_format($pedido->total, 2) }}</h2>
        </div>
        <div class="footer">
            <p>Gracias por su compra.</p>
        </div>
    </div>
</body>
</html>
