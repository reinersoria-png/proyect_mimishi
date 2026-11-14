<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | MIMISHI</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff7f0;
            font-family: Arial, sans-serif;
            color: #3c2417;
            padding: 20px;
        }

        .card {
            background: white;
            width: 100%;
            max-width: 430px;
            padding: 38px;
            border-radius: 20px;
            box-shadow: 0 10px 35px #3c24171a;
        }

        .logo {
            color: #ff8a00;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
        }

        h2, p { text-align: center; }

        label {
            display: block;
            margin: 18px 0 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd0c5;
            border-radius: 9px;
            font-size: 15px;
        }

        button {
            width: 100%;
            background: #ff8a00;
            color: white;
            border: 0;
            padding: 14px;
            border-radius: 9px;
            margin-top: 25px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover { background: #e77c00; }

        .error {
            background: #fff0ee;
            color: #b42318;
            padding: 12px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .volver {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #3c2417;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">MIMISHI 🐱</div>
        <h2>Bienvenido de nuevo</h2>
        <p>Ingresa a tu cuenta para continuar.</p>

        <div id="mensaje-error" class="error" hidden></div>

        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                autocomplete="email"
            >

            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                autocomplete="current-password"
            >

            <button type="submit">Iniciar sesión</button>
        </form>

        <a class="volver" href="/">Volver al inicio</a>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function (event) {
            event.preventDefault();

            const error = document.getElementById('mensaje-error');
            error.hidden = true;

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (response.ok) {
                    window.location.href = '/admin/categorias';
                    return;
                }

                const data = await response.json();

                error.textContent = data.message || 'No se pudo iniciar sesión.';
                error.hidden = false;
            } catch (e) {
                error.textContent = 'Error de conexión. Inténtalo nuevamente.';
                error.hidden = false;
            }
        });
    </script>
</body>
</html>
