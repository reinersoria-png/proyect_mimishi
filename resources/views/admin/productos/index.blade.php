<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | MIMISHI</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #fff7f0; color: #3c2417; font-family: Arial, sans-serif; }
        header { padding: 22px 6%; background: #ff8a00; color: white; }
        header h1 { margin: 0; }
        main { max-width: 1200px; padding: 25px; margin: auto; }
        .top { display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; }
        .card { background: white; border-radius: 14px; overflow-x: auto; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 15px; border-bottom: 1px solid #eee; }
        th { background: #ffead8; }
        .btn { display: inline-block; background: #ff8a00; color: white; text-decoration: none; padding: 11px 16px; border-radius: 8px; font-weight: bold; }
        .edit { background: #3c2417; }
        .alert { background: #dcfce7; padding: 14px; border-radius: 8px; margin-top: 18px; }
        .links { margin-top: 22px; }
        .links a { color: #3c2417; margin-right: 18px; }
        .pagination { padding: 18px; }
    </style>
</head>
<body>
<header><h1>MIMISHI | Administración</h1></header>
<main>
    <div class="top">
        <div>
            <h2>Gestión de productos</h2>
            <p>Catálogo de productos para gatos.</p>
        </div>
        <a class="btn" href="{{ route('admin.productos.create') }}">+ Nuevo producto</a>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                    <tr>
                        <td>{{ $producto->sku }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->categoria?->nombre ?? 'Sin categoría' }}</td>
                        <td>{{ $producto->marca ?? '—' }}</td>
                        <td>S/ {{ number_format((float) $producto->precio, 2) }}</td>
                        <td>{{ $producto->estado ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <a class="btn edit" href="{{ route('admin.productos.edit', $producto) }}">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Todavía no hay productos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination">{{ $productos->links() }}</div>
    </div>

    <div class="links">
        <a href="{{ route('admin.categorias.index') }}">Gestionar categorías</a>
        <a href="/">Volver al inicio</a>
    </div>
</main>
</body>
</html>
