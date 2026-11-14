<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contacto | MIMISHI</title>
    <link rel="stylesheet" href="{{ asset('css/mimishi-info.css') }}">
</head>
<body>

<header class="navbar">
    <div class="container nav-content">
        <a href="{{ route('home') }}" class="logo">MIMISHI 🐾</a>

        <nav class="nav-links">
            <a href="{{ route('home') }}">Inicio</a>
            <a href="{{ route('home') }}#productos">Productos</a>
            <a href="{{ route('nosotros') }}">Nosotros</a>
            <a href="{{ route('contacto') }}">Contacto</a>
        </nav>

        <a href="{{ route('home') }}#productos" class="btn btn-orange">
            Ver tienda
        </a>
    </div>
</header>

<section class="hero">
    <div class="container hero-content">
        <div>
            <span class="eyebrow">ESTAMOS AQUÍ PARA AYUDARTE</span>
            <h1>¿Necesitas una patita de ayuda?</h1>
            <p>
                Encuentra información sobre productos,
                compras y entregas de MIMISHI.
            </p>
            <a href="#ayuda" class="btn">Ver opciones de ayuda</a>
        </div>

        <div class="hero-art" aria-hidden="true">🐱💬</div>
    </div>
</section>

<section class="section" id="ayuda">
    <div class="container">
        <div class="section-heading">
            <h2>¿En qué podemos ayudarte?</h2>
            <p>
                Consulta las principales opciones de atención
                disponibles en nuestra tienda.
            </p>
        </div>

        <div class="cards">
            <article class="card">
                <div class="card-icon">🛍️</div>
                <h3>Productos</h3>
                <p>
                    Explora nuestro catálogo de juguetes,
                    accesorios y artículos para el cuidado
                    de tus gatos.
                </p>
                <p>
                    <a href="{{ route('home') }}#productos"
                       style="color:#e87800;font-weight:bold;">
                        Explorar catálogo →
                    </a>
                </p>
            </article>

            <article class="card">
                <div class="card-icon">📦</div>
                <h3>Pedidos y entregas</h3>
                <p>
                    MIMISHI contempla entregas locales y
                    envíos por transportistas externos.
                    El seguimiento de pedidos forma parte
                    del desarrollo del sistema.
                </p>
            </article>

            <article class="card">
                <div class="card-icon">👤</div>
                <h3>Mi cuenta</h3>
                <p>
                    Crea una cuenta o inicia sesión para
                    acceder a las funcionalidades disponibles.
                </p>
                <p>
                    @guest
                        <a href="{{ route('registro.form') }}"
                           style="color:#e87800;font-weight:bold;">
                            Crear mi cuenta →
                        </a>
                    @else
                        <a href="{{ route('home') }}"
                           style="color:#e87800;font-weight:bold;">
                            Volver a mi inicio →
                        </a>
                    @endguest
                </p>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="feature">
            <div>
                <span class="eyebrow">ATENCIÓN MIMISHI</span>
                <h2>Queremos que compres con confianza</h2>
                <p>
                    Estamos desarrollando nuestros canales oficiales
                    de atención y soporte al cliente.
                </p>
                <p>
                    Mientras tanto, puedes explorar nuestro
                    catálogo y conocer más sobre la tienda.
                </p>
                <a href="{{ route('nosotros') }}" class="btn btn-orange">
                    Conoce MIMISHI
                </a>
            </div>

            <div class="feature-visual" aria-hidden="true">💌🐾</div>
        </div>
    </div>
</section>

<section class="cta">
    <h2>¡Gracias por formar parte de MIMISHI! 🧡</h2>
    <p>Seguimos construyendo una mejor experiencia para ti y tu gato.</p>
    <a href="{{ route('home') }}" class="btn">
        Volver a la tienda
    </a>
</section>

<footer class="footer">
    <h2>MIMISHI 🐱</h2>
    <p>Juguetes • Accesorios • Amor</p>
    <div class="footer-links">
        <a href="{{ route('home') }}">Inicio</a>
        <a href="{{ route('nosotros') }}">Nosotros</a>
        <a href="{{ route('contacto') }}">Contacto</a>
    </div>
    <small>© {{ date('Y') }} MIMISHI</small>
</footer>

</body>
</html>
