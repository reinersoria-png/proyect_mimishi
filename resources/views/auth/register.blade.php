<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta | MIMISHI</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: #fff7f0;
            font-family: Arial, sans-serif;
            color: #3c2417;
        }
        .card {
            width: 100%;
            max-width: 460px;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 8px 30px #3c24171a;
        }
        h1 { color: #ff8a00; text-align: center; }
        h2, p { text-align: center; }
        label { display: block; font-weight: bold; margin: 15px 0 7px; }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd0c5;
            border-radius: 8px;
            font-size: 15px;
        }
        button {
            width: 100%;
            padding: 14px;
            background: #ff8a00;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 22px;
        }
        .error {
            color: #b42318;
            background: #fff0ee;
            padding: 12px;
            border-radius: 8px;
            margin-top: 15px;
        }
        .link { display: block; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <h1>MIMISHI 🐱</h1>
        <h2>Crea tu cuenta</h2>
        <p>Únete a nuestra comunidad de amantes de los gatos.</p>

        <div id="error" class="error" hidden></div>

        <form id="registroForm" action="{{ route('registro') }}" method="POST">
            @csrf

            <label for="name">Nombre completo *</label>
            <input id="name" name="name" required maxlength="255">

            <label for="email">Correo electrónico *</label>
            <input type="email" id="email" name="email" required>

            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" maxlength="20">

            <label for="password">Contraseña *</label>
            <input type="password" id="password" name="password"
                   minlength="8" required>

            <label for="password_confirmation">Confirmar contraseña *</label>
            <input type="password" id="password_confirmation"
                   name="password_confirmation" minlength="8" required>

            <button type="submit">Crear cuenta</button>
        </form>

        <a class="link" href="{{ route('login.form') }}">
            ¿Ya tienes cuenta? Inicia sesión
        </a>
    </div>

    <script>
        document.getElementById('registroForm')
            .addEventListener('submit', async function (event) {
                event.preventDefault();

                const error = document.getElementById('error');
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

                    const data = await response.json();

                    if (response.ok) {
                        window.location.href = '/';
                        return;
                    }

                    if (data.errors) {
                        error.textContent = Object.values(data.errors)
                            .flat().join(' ');
                    } else {
                        error.textContent = data.message ||
                            'No se pudo crear la cuenta.';
                    }

                    error.hidden = false;
                } catch (e) {
                    error.textContent = 'Error de conexión con el servidor.';
                    error.hidden = false;
                }
            });
    </script>
</body>
</html>
