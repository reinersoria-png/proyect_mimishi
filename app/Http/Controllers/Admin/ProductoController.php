<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')
            ->orderBy('nombre')
            ->paginate(10);

        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.productos.form', [
            'producto' => new Producto(),
            'categorias' => $categorias,
        ]);
    }

    public function store(Request $request)
    {
        Producto::create($this->validar($request));

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::where('estado', true)
            ->orWhere('id', $producto->categoria_id)
            ->orderBy('nombre')
            ->get();

        return view('admin.productos.form', compact(
            'producto',
            'categorias'
        ));
    }

    public function update(Request $request, Producto $producto)
    {
        $producto->update($this->validar($request, $producto));

        return redirect()
            ->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    private function validar(
        Request $request,
        ?Producto $producto = null
    ): array {
        return $request->validate([
            'categoria_id' => [
                'required',
                Rule::exists('categorias', 'id')
                    ->where('estado', true),
            ],
            'sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('productos', 'sku')
                    ->ignore($producto?->id),
            ],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'marca' => ['nullable', 'string', 'max:100'],
            'presentacion' => ['nullable', 'string', 'max:100'],
            'precio' => ['required', 'numeric', 'min:0'],
            'estado' => ['required', 'boolean'],
        ]);
    }
}
