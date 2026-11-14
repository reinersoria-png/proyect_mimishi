<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar categoría | MIMISHI</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff7f0;
            color: #3c2417;
        }

        header {
            background: #ff8a00;
            padding: 22px 6%;
            color: white;
        }

        header h1 { margin: 0; }

        main {
            max-width: 750px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 5px 20px #3c241714;
        }

        h2 { margin-top: 0; }

        label {
            display: block;
            font-weight: bold;
            margin: 18px 0 8px;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd0c5;
            border-radius: 9px;
            font: inherit;
        }

        input:focus, textarea:focus, select:focus {
            outline: 2px solid #ffad27;
            border-color: #ff8a00;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .imagen-actual {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            display: block;
            margin: 10px 0;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 20px;
            border-radius: 9px;
            text-decoration: none;
            font-weight: bold;
            border: 0;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-primary {
            background: #ff8a00;
            color: white;
        }

        .btn-secondary {
            background: #f1e8e1;
            color: #3c2417;
        }

        .error {
            color: #b42318;
            font-size: 13px;
            margin-top: 5px;
        }

        .alert-error {
            background: #fff0ee;
            color: #b42318;
            padding: 15px;
            border-radius: 9px;
        }
    </style>
</head>

<body>
    <header>
        <h1>MIMISHI | Administración</h1>
    </header>

    <main>
        <div class="card">
            <h2>Editar categoría</h2>
            <p>Modifica los datos de la categoría seleccionada.</p>

            @if ($errors->any())
                <div class="alert-error">
                    Revisa los campos marcados antes de continuar.
                </div>
            @endif

            <form
                action="{{ route('admin.categorias.update', $categoria) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                <label for="nombre">Nombre de la categoría *</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre', $categoria->nombre) }}"
                    maxlength="150"
                    required
                >
                @error('nombre')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="descripcion">Descripción</label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                >{{ old('descripcion', $categoria->descripcion) }}</textarea>
                @error('descripcion')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label>Imagen actual</label>

                @if ($categoria->imagen)
                    <img
                        src="{{ asset('storage/' . $categoria->imagen) }}"
                        alt="{{ $categoria->nombre }}"
                        class="imagen-actual"
                    >
                @else
                    <p>Esta categoría todavía no tiene imagen.</p>
                @endif

                <label for="imagen">Cambiar imagen (opcional)</label>
                <input
                    type="file"
                    id="imagen"
                    name="imagen"
                    accept=".jpg,.jpeg,.png,.webp"
                >
                @error('imagen')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="estado">Estado *</label>
                <select id="estado" name="estado" required>
                    <option
                        value="1"
                        @selected(old('estado', (string) (int) $categoria->estado) == '1')
                    >
                        Activo
                    </option>
                    <option
                        value="0"
                        @selected(old('estado', (string) (int) $categoria->estado) == '0')
                    >
                        Inactivo
                    </option>
                </select>
                @error('estado')
                    <div class="error">{{ $message }}</div>
                @enderror

                <div class="actions">
                    <button type="submit" class="btn btn-primary">
                        Guardar cambios
                    </button>

                    <a
                        href="{{ route('admin.categorias.index') }}"
                        class="btn btn-secondary"
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
