<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('nombre')
            ->paginate(10);

        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'estado' => 'required|boolean',
        ]);

        $datos['slug'] = $this->generarSlug($datos['nombre']);

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')
                ->store('categorias', 'public');
        }

        Categoria::create($datos);

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría registrada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'estado' => 'required|boolean',
        ]);

        if ($categoria->nombre !== $datos['nombre']) {
            $datos['slug'] = $this->generarSlug(
                $datos['nombre'],
                $categoria->id
            );
        }

        $imagenAnterior = $categoria->imagen;

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')
                ->store('categorias', 'public');
        }

        $categoria->update($datos);

        if (
            $request->hasFile('imagen') &&
            $imagenAnterior
        ) {
            Storage::disk('public')->delete($imagenAnterior);
        }

        return redirect()
            ->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    private function generarSlug(
        string $nombre,
        ?int $exceptoId = null
    ): string {
        $base = Str::slug($nombre);
        $slug = $base ?: 'categoria';
        $contador = 2;

        while (
            Categoria::where('slug', $slug)
                ->when($exceptoId, function ($query) use ($exceptoId) {
                    $query->where('id', '!=', $exceptoId);
                })
                ->exists()
        ) {
            $slug = $base . '-' . $contador;
            $contador++;
        }

        return $slug;
    }
}
