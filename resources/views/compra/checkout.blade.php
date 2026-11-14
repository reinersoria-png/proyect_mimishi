<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmar pedido | MIMISHI</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #fff7f0; color: #3c2417; font-family: Arial,sans-serif; }
        header { background: #ff8a00; padding: 22px 6%; }
        main { max-width: 800px; margin: 35px auto; padding: 0 20px; }
        .card { background: white; padding: 28px; border-radius: 16px; margin-bottom: 20px; }
        label { display: block; margin: 15px 0 7px; font-weight: bold; }
        input,textarea { width: 100%; padding: 12px; border: 1px solid #ddd0c5; border-radius: 9px; font: inherit; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .btn { display: inline-block; background: #ff8a00; color: white; border: 0; padding: 13px 20px; border-radius: 9px; font-weight: bold; cursor: pointer; text-decoration: none; }
        .error { background: #fff0ee; color: #b42318; padding: 12px; border-radius: 9px; }
        .nota { background: #fff0df; padding: 14px; border-radius: 9px; }
        @media(max-width:600px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<header><h1>MIMISHI 🐱 | Confirmación</h1></header>
<main>
    <h2>Confirmar mi pedido</h2>

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="card">
        <h3>Resumen del carrito</h3>

        @foreach($articulos as $articulo)
            <p>
                {{ $articulo->nombre }}
                × {{ $articulo->cantidad }}
                — S/ {{ number_format($articulo->precio * $articulo->cantidad, 2) }}
            </p>
        @endforeach

        <h2>Subtotal: S/ {{ number_format($subtotal, 2) }}</h2>

        <p class="nota">
            Demostración académica: este pedido quedará pendiente
            de pago. El costo de envío real todavía no está calculado.
            No se realizará ningún cobro.
        </p>
    </div>

    <div class="card">
        <h3>Datos de entrega</h3>

        <form method="POST" action="{{ route('compra.confirmar') }}">
            @csrf

            <label>Nombre del destinatario *</label>
            <input name="destinatario"
                value="{{ old('destinatario', auth()->user()->name) }}"
                maxlength="150" required>

            <label>Teléfono de entrega *</label>
            <input name="telefono_entrega"
                value="{{ old('telefono_entrega', auth()->user()->telefono) }}"
                maxlength="20" required>

            <div class="grid">
                <div>
                    <label>Departamento *</label>
                    <input name="departamento_entrega"
                        value="{{ old('departamento_entrega', 'Lima') }}"
                        maxlength="100" required>
                </div>
                <div>
                    <label>Provincia *</label>
                    <input name="provincia_entrega"
                        value="{{ old('provincia_entrega', 'Lima') }}"
                        maxlength="100" required>
                </div>
            </div>

            <label>Distrito *</label>
            <input name="distrito_entrega"
                value="{{ old('distrito_entrega') }}"
                maxlength="100" required>

            <label>Dirección *</label>
            <input name="direccion_entrega"
                value="{{ old('direccion_entrega') }}"
                maxlength="255" required>

            <label>Referencia</label>
            <input name="referencia_entrega"
                value="{{ old('referencia_entrega') }}"
                maxlength="255">

            <label>Observaciones</label>
            <textarea name="observaciones">{{ old('observaciones') }}</textarea>

            <p class="nota">
                Al confirmar se registrará una solicitud de pedido
                pendiente de pago. No es una compra pagada.
            </p>

            <button type="submit" class="btn">
                Registrar pedido pendiente
            </button>

            <a href="{{ route('carrito.index') }}" class="btn"
               style="background:#3c2417;">
                Volver al carrito
            </a>
        </form>
    </div>
</main>
</body>
</html>
