<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $producto->exists ? 'Editar' : 'Nuevo' }} producto | MIMISHI</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #fff7f0; color: #3c2417; font-family: Arial, sans-serif; }
        header { background: #ff8a00; padding: 22px 6%; color: white; }
        header h1 { margin: 0; }
        main { max-width: 750px; margin: 35px auto; padding: 0 20px; }
        .card { padding: 30px; background: white; border-radius: 16px; box-shadow: 0 5px 20px #3c241714; }
        label { display: block; font-weight: bold; margin: 16px 0 7px; }
        input, select, textarea { display: block; width: 100%; padding: 12px; border: 1px solid #ddd0c5; border-radius: 8px; font: inherit; }
        textarea { min-height: 95px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .error { color: #b42318; font-size: 13px; margin-top: 5px; }
        .actions { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 25px; }
        .btn { border: 0; padding: 12px 18px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 15px; cursor: pointer; }
        .primary { background: #ff8a00; color: white; }
        .secondary { background: #f1e8e1; color: #3c2417; }
        @media(max-width: 600px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<header><h1>MIMISHI | Administración</h1></header>
<main>
    <div class="card">
        <h2>{{ $producto->exists ? 'Editar producto' : 'Registrar producto' }}</h2>

        <form
            method="POST"
            action="{{ $producto->exists ? route('admin.productos.update', $producto) : route('admin.productos.store') }}"
        >
            @csrf
            @if($producto->exists)
                @method('PUT')
            @endif

            <label for="categoria_id">Categoría *</label>
            <select name="categoria_id" id="categoria_id" required>
                <option value="">Selecciona una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        @selected(old('categoria_id', $producto->categoria_id) == $categoria->id)>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id') <div class="error">{{ $message }}</div> @enderror

            <div class="grid">
                <div>
                    <label for="sku">SKU *</label>
                    <input id="sku" name="sku" required maxlength="50"
                        value="{{ old('sku', $producto->sku) }}">
                    @error('sku') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="nombre">Nombre *</label>
                    <input id="nombre" name="nombre" required maxlength="150"
                        value="{{ old('nombre', $producto->nombre) }}">
                    @error('nombre') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion">{{ old('descripcion', $producto->descripcion) }}</textarea>
            @error('descripcion') <div class="error">{{ $message }}</div> @enderror

            <div class="grid">
                <div>
                    <label for="marca">Marca</label>
                    <input id="marca" name="marca" maxlength="100"
                        value="{{ old('marca', $producto->marca) }}">
                    @error('marca') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="presentacion">Presentación</label>
                    <input id="presentacion" name="presentacion" maxlength="100"
                        value="{{ old('presentacion', $producto->presentacion) }}">
                    @error('presentacion') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="grid">
                <div>
                    <label for="precio">Precio (S/) *</label>
                    <input type="number" step="0.01" min="0" id="precio"
                        name="precio" required
                        value="{{ old('precio', $producto->precio) }}">
                    @error('precio') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label for="estado">Estado *</label>
                    <select name="estado" id="estado" required>
                        <option value="1" @selected(old('estado', $producto->exists ? (string)(int)$producto->estado : '1') == '1')>Activo</option>
                        <option value="0" @selected(old('estado', $producto->exists ? (string)(int)$producto->estado : '1') == '0')>Inactivo</option>
                    </select>
                    @error('estado') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn primary">
                    {{ $producto->exists ? 'Guardar cambios' : 'Registrar producto' }}
                </button>
                <a class="btn secondary" href="{{ route('admin.productos.index') }}">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</main>
</body>
</html>
