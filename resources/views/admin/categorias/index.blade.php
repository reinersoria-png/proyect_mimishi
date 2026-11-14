<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías | MIMISHI</title>
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
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            background: #ff8a00;
            color: white;
            padding: 12px 18px;
            border-radius: 9px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-edit {
            background: #3c2417;
            padding: 8px 14px;
            font-size: 14px;
        }

        .card {
            background: white;
            border-radius: 15px;
            overflow-x: auto;
            box-shadow: 0 5px 20px #3c241714;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 17px;
            border-bottom: 1px solid #f1e8e1;
        }

        th { background: #ffead8; }

        .estado {
            font-weight: bold;
        }

        .activo { color: #16803d; }
        .inactivo { color: #b42318; }

        .alerta {
            background: #d9f7e4;
            color: #166534;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .pagination {
            padding: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>MIMISHI | Administración</h1>
</header>

<main>
    <div class="topbar">
        <div>
            <h2>Gestión de categorías</h2>
            <p>Administra las categorías de productos para gatos.</p>
        </div>

        <a href="{{ route('admin.categorias.create') }}" class="btn">
            + Nueva categoría
        </a>
    </div>

    @if (session('success'))
        <div class="alerta">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categorias as $categoria)
                    <tr>
                        <td>
                            @if ($categoria->imagen)
                                <img
                                    src="{{ asset('storage/' . $categoria->imagen) }}"
                                    alt="{{ $categoria->nombre }}"
                                    width="60"
                                    height="60"
                                    style="object-fit:cover;border-radius:8px;"
                                >
                            @else
                                Sin imagen
                            @endif
                        </td>

                        <td>{{ $categoria->nombre }}</td>
                        <td>{{ $categoria->descripcion ?? 'Sin descripción' }}</td>

                        <td>
                            <span class="estado {{ $categoria->estado ? 'activo' : 'inactivo' }}">
                                {{ $categoria->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>

                        <td>
                            <a
                                href="{{ route('admin.categorias.edit', $categoria) }}"
                                class="btn btn-edit"
                            >
                                Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">
                            Todavía no hay categorías registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $categorias->links() }}
        </div>
    </div>
</main>

</body>
</html>
