<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi carrito | MIMISHI</title>
    <style>
        body { margin: 0; background: #fff7f0; color: #3c2417; font-family: Arial,sans-serif; }
        header { background: #ff8a00; padding: 22px 6%; }
        main { max-width: 900px; margin: 35px auto; padding: 0 20px; }
        .card { background: white; padding: 24px; border-radius: 16px; margin: 15px 0; }
        .item { display: flex; justify-content: space-between; gap: 15px; align-items: center; border-bottom: 1px solid #eee; padding: 18px 0; flex-wrap: wrap; }
        .btn { display: inline-block; background: #ff8a00; color: white; padding: 12px 20px; border: 0; border-radius: 9px; text-decoration: none; font-weight: bold; cursor: pointer; }
        .secondary { background: #3c2417; }
        .error { background: #fff0ee; color: #b42318; padding: 12px; border-radius: 9px; }
        .success { background: #dcfce7; padding: 12px; border-radius: 9px; }
    </style>
</head>
<body>
<header><h1>MIMISHI 🐱 | Mi carrito</h1></header>
<main>
    <h2>Tu carrito de compras</h2>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="card">
        @forelse($articulos as $articulo)
            <div class="item">
                <div>
                    <h3>{{ $articulo->nombre }}</h3>
                    <p>Cantidad: {{ $articulo->cantidad }}</p>
                    <p>Precio: S/ {{ number_format((float)$articulo->precio, 2) }}</p>
                </div>

                <div>
                    <strong>
                        S/ {{ number_format($articulo->precio * $articulo->cantidad, 2) }}
                    </strong>

                    <form method="POST"
                        action="{{ route('carrito.quitar', $articulo->detalle_id) }}">
                        @csrf
                        <button type="submit" class="btn secondary">
                            Quitar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p>Tu carrito está vacío.</p>
        @endforelse

        <h2>Subtotal: S/ {{ number_format($subtotal, 2) }}</h2>

        @if($articulos->isNotEmpty())
            <a href="{{ route('compra.checkout') }}" class="btn">
                Continuar compra
            </a>
        @endif

        <a href="{{ route('home') }}" class="btn secondary">
            Seguir comprando
        </a>
    </div>
</main>
</body>
</html>
