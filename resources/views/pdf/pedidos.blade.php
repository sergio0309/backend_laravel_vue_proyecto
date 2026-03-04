<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de Pedido #{{ $pedido['id'] }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .header {
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
        }
        .header h2 {
            margin: 0;
        }
        .cliente, .pedido {
            margin-bottom: 10px;
        }
        .datos th, .datos td {
            text-align: left;
            padding: 4px;
        }
        .productos {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .productos th, .productos td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        .total {
            text-align: right;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Recibo de Pedido #{{ $pedido['id'] }}</h2>
        </div>

        <div class="cliente">
            <strong>Cliente:</strong> {{ $pedido['cliente']['nombre_completo'] ?? 'No definido' }}<br>
            <strong>CI/NIT:</strong> {{ $pedido['cliente']['ci_nit'] ?? 'N/A' }}<br>
            <strong>Teléfono:</strong> {{ $pedido['cliente']['telefono'] ?? 'N/A' }}<br>
            <strong>Dirección:</strong> {{ $pedido['cliente']['direccion'] ?? 'N/A' }}
        </div>

        <div class="pedido">
            <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($pedido['fecha'])->format('d/m/Y H:i') }}<br>
            <strong>Estado:</strong>
            @php
                $estados = ['Pendiente', 'Procesado', 'Entregado', 'Cancelado'];
            @endphp
            {{ $estados[$pedido['estado']] ?? 'Desconocido' }}<br>
            <strong>Observación:</strong> {{ $pedido['observacion'] ?? 'Sin observaciones' }}
        </div>

        <table class="productos">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($pedido['productos'] as $index => $producto)
                    @php
                        $precio = is_numeric($producto['precio']) ? $producto['precio'] : 0;
                        $cantidad = $producto['pivot']['cantidad'];
                        $subtotal = $precio * $cantidad;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $producto['nombre'] }}</td>
                        <td>{{ $cantidad }}</td>
                        <td>{{ number_format($precio, 2) }} Bs</td>
                        <td>{{ number_format($subtotal, 2) }} Bs</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            Total: {{ number_format($total, 2) }} Bs
        </div>
    </div>
</body>
</html>
