<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedido registrado | MIMISHI</title>
    <style>
        body { margin: 0; background: #fff7f0; color: #3c2417; font-family: Arial,sans-serif; }
        header { padding: 22px 6%; background: #ff8a00; }
        main { max-width: 780px; margin: 45px auto; padding: 0 20px; }
        .card { background: white; border-radius: 18px; padding: 30px; }
        .ok { color: #16803d; font-size: 28px; }
        .item { padding: 12px 0; border-bottom: 1px solid #eee; }
        .btn { display: inline-block; background: #ff8a00; color: white; padding: 13px 22px; border-radius: 9px; font-weight: bold; text-decoration: none; margin-top: 20px; }
        .nota { background: #fff0df; padding: 15px; border-radius: 9px; }
    </style>
</head>
<body>
<header><h1>MIMISHI 🐱</h1></header>
<main>
    <div class="card">
        <h2 class="ok">✓ ¡Pedido registrado!</h2>

        <p><strong>Número:</strong> {{ $datosPedido->numero_pedido }}</p>
        <p><strong>Estado:</strong> Pendiente de pago</p>
        <p><strong>Destinatario:</strong> {{ $datosPedido->destinatario }}</p>
        <p>
            <strong>Entrega:</strong>
            {{ $datosPedido->direccion_entrega }},
            {{ $datosPedido->distrito_entrega }},
            {{ $datosPedido->provincia_entrega }}
        </p>

        <h3>Productos solicitados</h3>

        @foreach($detalles as $detalle)
            <div class="item">
                {{ $detalle->nombre_producto }}
                × {{ $detalle->cantidad }}
                — S/ {{ number_format((float)$detalle->subtotal, 2) }}
            </div>
        @endforeach

        <h2>Total provisional: S/ {{ number_format((float)$datosPedido->total, 2) }}</h2>

        <p class="nota">
            Este pedido se registró en MySQL, pero aún no se ha pagado.
            El envío definitivo y el pago se implementarán en una etapa posterior.
        </p>

        <a href="{{ route('home') }}" class="btn">
            Volver a la tienda
        </a>
    </div>
</main>
</body>
</html>
