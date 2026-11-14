<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIMISHI | Todo para tu michi</title>

    <style>
        :root {
            --orange: #ff8a00;
            --yellow: #ffc34d;
            --cream: #fff7f0;
            --brown: #3c2417;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: var(--brown);
            background: var(--cream);
        }

        a { text-decoration: none; color: inherit; }

        .navbar {
            background: white;
            padding: 18px 6%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .logo {
            color: var(--orange);
            font-size: 28px;
            font-weight: 900;
        }

        .navlinks {
            display: flex;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
        }

        .navlinks a:hover { color: var(--orange); }

        .btn {
            display: inline-block;
            background: var(--brown);
            color: white;
            border: none;
            padding: 13px 22px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-orange { background: var(--orange); }

        .hero {
            background: linear-gradient(120deg, #ff8a00, #ffbe45);
            padding: 65px 7%;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            align-items: center;
            gap: 30px;
            min-height: 430px;
        }

        .hero h1 {
            font-size: clamp(35px, 5vw, 65px);
            line-height: 1.08;
            margin: 15px 0;
        }

        .hero p { font-size: 19px; }

        .hero-art {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            min-height: 260px;
        }

        .cat {
            font-size: clamp(140px, 22vw, 250px);
            filter: drop-shadow(0 15px 5px #5d31002a);
        }

        .sale {
            position: absolute;
            right: 7%;
            top: 0;
            background: white;
            color: #e26900;
            padding: 24px 16px;
            border-radius: 50%;
            font-weight: 900;
            font-size: 22px;
            transform: rotate(13deg);
        }

        section {
            max-width: 1200px;
            margin: auto;
            padding: 55px 22px;
        }

        section h2 {
            font-size: 31px;
            margin-top: 0;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 5px 20px #3c24170c;
        }

        .product-img {
            height: 145px;
            border-radius: 13px;
            background: #fff0df;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 65px;
        }

        .price {
            color: #e87500;
            font-size: 23px;
            font-weight: bold;
        }

        .pill {
            display: inline-block;
            background: #fff0df;
            border-radius: 50px;
            padding: 12px 17px;
            margin: 6px;
            font-weight: bold;
        }

        .info-banner {
            text-align: center;
            background: #ffe4c8;
            padding: 45px 20px;
        }

        footer {
            background: var(--brown);
            color: white;
            padding: 35px 7%;
            text-align: center;
        }

        footer a { margin: 0 12px; }

        @media (max-width: 850px) {
            .hero { grid-template-columns: 1fr; }
            .grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 520px) {
            .grid { grid-template-columns: 1fr; }
            .navbar { justify-content: center; }
            .navlinks { justify-content: center; }
        }

        .carrito-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff0df;
            color: #3c2417;
            padding: 11px 16px;
            border-radius: 12px;
            font-weight: bold;
            transition: 0.2s;
        }

        .carrito-link:hover {
            background: #ff8a00;
            color: white;
        }

    </style>
</head>

<body>
    <header class="navbar">
        <a href="{{ route('home') }}" class="logo">MIMISHI 🐾</a>

        <nav class="navlinks">
            <a href="{{ route('home') }}">Inicio</a>
            <a href="#categorias">Categorías</a>
            <a href="#productos">Productos</a>
            <a href="{{ route('nosotros') }}">Nosotros</a>
            <a href="{{ route('contacto') }}">Contacto</a>
        </nav>


        <div class="navlinks">
            @guest
                <a href="{{ route('login.form') }}">Ingresar</a>

                <a href="{{ route('registro.form') }}"
                class="btn btn-orange">
                    Crear cuenta
                </a>
            @endguest

            @auth
                <a href="{{ route('carrito.index') }}"
                class="carrito-link">
                    🛒 Mi carrito
                </a>

                @if(auth()->user()->hasPermission('productos.gestionar'))
                    <a href="{{ route('admin.productos.index') }}">
                        Administración
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-orange" type="submit">
                        Salir
                    </button>
                </form>
            @endauth
        </div>

    </header>

    <div class="hero">
        <div>
            <strong>Juguetes • Accesorios • Amor</strong>
            <h1>La mejor colección para tu michi</h1>
            <p>Productos pensados para cuidar y consentir a tu gato.</p>
            <a class="btn" href="#productos">COMPRAR AHORA</a>
        </div>

        <div class="hero-art">
            <div class="cat">🐈</div>
            <div class="sale">50% OFF</div>
        </div>
    </div>

    <section id="categorias">
        <h2>Explora nuestras categorías</h2>
        <p>Todo lo que necesita tu compañero de cuatro patas.</p>

        @forelse($categorias as $categoria)
            <span class="pill">{{ $categoria->nombre }}</span>
        @empty
            <p>Próximamente agregaremos nuevas categorías.</p>
        @endforelse
    </section>

    <section id="productos">
        <h2>Productos destacados</h2>
        <p>Descubre lo mejor de MIMISHI.</p>

        <div class="grid">
            @forelse($productos as $producto)
                <article class="card">
                    <div class="product-img">🐱</div>

                    <p>{{ $producto->categoria?->nombre }}</p>

                    <h3>{{ $producto->nombre }}</h3>

                    <p>
                        {{ $producto->descripcion ?: 'Producto especial para tu gato.' }}
                    </p>

                    <p class="price">
                        S/ {{ number_format((float)$producto->precio, 2) }}
                    </p>

                    <form method="POST" action="{{ route('carrito.agregar') }}">
                        @csrf

                        <input type="hidden"
                            name="producto_id"
                            value="{{ $producto->id }}">

                        <input type="hidden" name="cantidad" value="1">

                        <button type="submit" class="btn btn-orange">
                            Agregar al carrito
                        </button>
                    </form>

                    <a href="{{ route('carrito.index') }}">🛒 Mi carrito</a>

                    <span class="pill">
                        {{ $producto->presentacion ?? 'Disponible' }}
                    </span>
                </article>
            @empty
                <p>Pronto encontrarás nuestros productos aquí.</p>
            @endforelse
        </div>
    </section>

    <div class="info-banner">
        <h2>Porque ellos también son familia 🧡</h2>
        <p>En MIMISHI nos apasiona el bienestar de los gatos.</p>
        <a class="btn" href="{{ route('nosotros') }}">
            Conoce nuestra historia
        </a>
    </div>

    <footer>
        <h2>MIMISHI</h2>
        <p>Juguetes • Accesorios • Amor</p>
        <p>
            <a href="{{ route('home') }}">Inicio</a>
            <a href="{{ route('nosotros') }}">Nosotros</a>
            <a href="{{ route('contacto') }}">Contacto</a>
        </p>
        <small>© {{ date('Y') }} MIMISHI</small>
    </footer>
</body>
</html>
