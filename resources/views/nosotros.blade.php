<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nosotros | MIMISHI</title>
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
            Explorar tienda
        </a>
    </div>
</header>

<section class="hero">
    <div class="container hero-content">
        <div>
            <span class="eyebrow">CONOCE NUESTRA ESENCIA</span>
            <h1>Un mundo más feliz para tu michi.</h1>
            <p>
                En MIMISHI creemos que cada gato merece
                cuidado, diversión y muchísimo amor.
            </p>
            <a href="{{ route('home') }}#productos" class="btn">
                Descubrir productos
            </a>
        </div>

        <div class="hero-art" aria-hidden="true">🐈</div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <h2>¿Quiénes somos?</h2>
            <p>
                Una tienda enfocada en productos que acompañan
                cada etapa de la vida de nuestros gatos.
            </p>
        </div>

        <div class="feature">
            <div class="feature-visual" aria-hidden="true">🐱🧡</div>
            <div>
                <span class="eyebrow">NUESTRA HISTORIA</span>
                <h2>Nacimos del amor por los gatos</h2>
                <p>
                    MIMISHI es una propuesta de tienda especializada
                    en artículos para gatos. Buscamos reunir juguetes,
                    accesorios y productos de cuidado en un solo lugar.
                </p>
                <p>
                    Queremos que encontrar lo necesario para tu michi
                    sea fácil, cómodo y agradable.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <h2>Lo que nos mueve</h2>
            <p>Los principios que orientan nuestra propuesta.</p>
        </div>

        <div class="cards">
            <article class="card">
                <div class="card-icon">🎯</div>
                <h3>Nuestra misión</h3>
                <p>
                    Facilitar el acceso a productos para gatos
                    mediante una experiencia de compra sencilla,
                    confiable y agradable.
                </p>
            </article>

            <article class="card">
                <div class="card-icon">✨</div>
                <h3>Nuestra visión</h3>
                <p>
                    Ser una tienda reconocida por su especialización,
                    atención al cliente y compromiso con el
                    bienestar felino.
                </p>
            </article>

            <article class="card">
                <div class="card-icon">❤️</div>
                <h3>Nuestros valores</h3>
                <p>
                    Amor por los animales, responsabilidad,
                    transparencia y mejora continua en
                    cada experiencia de compra.
                </p>
            </article>
        </div>
    </div>
</section>

<section class="cta">
    <h2>Tu michi merece lo mejor 🐾</h2>
    <p>Explora nuestras categorías y encuentra algo especial.</p>
    <a href="{{ route('home') }}#productos" class="btn btn-orange">
        Ver productos
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
