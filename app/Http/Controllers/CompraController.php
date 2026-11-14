<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CompraController extends Controller
{
    private function articulos(int $userId)
    {
        return DB::table('carrito_detalles as cd')
            ->join('carritos as c', 'c.id', '=', 'cd.carrito_id')
            ->join('productos as p', 'p.id', '=', 'cd.producto_id')
            ->join('categorias as cat', 'cat.id', '=', 'p.categoria_id')
            ->leftJoin('inventarios as i', 'i.producto_id', '=', 'p.id')
            ->where('c.user_id', $userId)
            ->select(
                'cd.id as detalle_id',
                'p.id as producto_id',
                'p.nombre',
                'p.sku',
                'p.precio',
                'p.estado',
                'cat.estado as categoria_activa',
                'cd.cantidad',
                'i.stock_actual'
            )
            ->orderBy('p.id')
            ->get();
    }

    private function subtotal($articulos): int
    {
        return $articulos->sum(
            fn ($a) => (int) round(((float) $a->precio) * 100)
                * (int) $a->cantidad
        );
    }

    public function agregar(Request $request)
    {
        $datos = $request->validate([
            'producto_id' => ['required', 'integer', 'exists:productos,id'],
            'cantidad' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        DB::transaction(function () use ($request, $datos) {
            $producto = DB::table('productos')
                ->where('id', $datos['producto_id'])
                ->where('estado', 1)
                ->first();

            if (!$producto || !DB::table('categorias')
                ->where('id', $producto->categoria_id)
                ->where('estado', 1)->exists()) {
                throw ValidationException::withMessages([
                    'producto_id' => 'El producto no está disponible.',
                ]);
            }

            DB::table('carritos')->insertOrIgnore([
                'user_id' => $request->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $carrito = DB::table('carritos')
                ->where('user_id', $request->user()->id)
                ->lockForUpdate()
                ->first();

            $detalle = DB::table('carrito_detalles')
                ->where('carrito_id', $carrito->id)
                ->where('producto_id', $producto->id)
                ->first();

            $cantidad = ($detalle?->cantidad ?? 0) + $datos['cantidad'];

            if ($cantidad > 100) {
                throw ValidationException::withMessages([
                    'cantidad' => 'Máximo 100 unidades por producto.',
                ]);
            }

            $inventario = DB::table('inventarios')
                ->where('producto_id', $producto->id)
                ->first();

            if (!$inventario || $inventario->stock_actual < $cantidad) {
                throw ValidationException::withMessages([
                    'cantidad' => 'No hay existencias suficientes.',
                ]);
            }

            if ($detalle) {
                DB::table('carrito_detalles')
                    ->where('id', $detalle->id)
                    ->update([
                        'cantidad' => $cantidad,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('carrito_detalles')->insert([
                    'carrito_id' => $carrito->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return redirect()->route('carrito.index')
            ->with('success', 'Producto agregado al carrito.');
    }

    public function carrito(Request $request)
    {
        $articulos = $this->articulos($request->user()->id);
        $subtotal = $this->subtotal($articulos) / 100;

        return view('compra.carrito', compact('articulos', 'subtotal'));
    }

    public function quitar(Request $request, int $detalle)
    {
        DB::table('carrito_detalles')
            ->where('id', $detalle)
            ->whereIn('carrito_id', function ($query) use ($request) {
                $query->select('id')
                    ->from('carritos')
                    ->where('user_id', $request->user()->id);
            })
            ->delete();

        return redirect()->route('carrito.index');
    }

    public function checkout(Request $request)
    {
        $articulos = $this->articulos($request->user()->id);

        if ($articulos->isEmpty()) {
            return redirect()->route('carrito.index');
        }

        $subtotal = $this->subtotal($articulos) / 100;

        return view('compra.checkout', compact('articulos', 'subtotal'));
    }

    public function confirmar(Request $request)
    {
        $datos = $request->validate([
            'destinatario' => ['required', 'string', 'max:150'],
            'telefono_entrega' => ['required', 'string', 'max:20'],
            'departamento_entrega' => ['required', 'string', 'max:100'],
            'provincia_entrega' => ['required', 'string', 'max:100'],
            'distrito_entrega' => ['required', 'string', 'max:100'],
            'direccion_entrega' => ['required', 'string', 'max:255'],
            'referencia_entrega' => ['nullable', 'string', 'max:255'],
            'observaciones' => ['nullable', 'string'],
        ]);

        $pedidoId = DB::transaction(function () use ($request, $datos) {
            $carrito = DB::table('carritos')
                ->where('user_id', $request->user()->id)
                ->lockForUpdate()
                ->first();

            if (!$carrito) {
                throw ValidationException::withMessages([
                    'carrito' => 'El carrito está vacío.',
                ]);
            }

            $articulos = $this->articulos($request->user()->id);

            if ($articulos->isEmpty()) {
                throw ValidationException::withMessages([
                    'carrito' => 'El carrito está vacío.',
                ]);
            }

            foreach ($articulos as $articulo) {
                if (!$articulo->estado || !$articulo->categoria_activa) {
                    throw ValidationException::withMessages([
                        'carrito' => 'Hay productos no disponibles.',
                    ]);
                }

                $inventario = DB::table('inventarios')
                    ->where('producto_id', $articulo->producto_id)
                    ->lockForUpdate()
                    ->first();

                if (!$inventario ||
                    $inventario->stock_actual < $articulo->cantidad) {
                    throw ValidationException::withMessages([
                        'carrito' => 'Stock insuficiente para ' . $articulo->nombre,
                    ]);
                }
            }

            $centimos = $this->subtotal($articulos);
            $subtotal = number_format($centimos / 100, 2, '.', '');

            $pedidoId = DB::table('pedidos')->insertGetId([
                'numero_pedido' => 'MIM-' . Str::upper(Str::random(16)),
                'user_id' => $request->user()->id,
                'subtotal' => $subtotal,
                'descuento' => 0,
                'costo_envio' => 0,
                'total' => $subtotal,
                'estado' => 'pendiente_pago',
                'destinatario' => $datos['destinatario'],
                'telefono_entrega' => $datos['telefono_entrega'],
                'departamento_entrega' => $datos['departamento_entrega'],
                'provincia_entrega' => $datos['provincia_entrega'],
                'distrito_entrega' => $datos['distrito_entrega'],
                'direccion_entrega' => $datos['direccion_entrega'],
                'referencia_entrega' => $datos['referencia_entrega'] ?? null,
                'observaciones' => $datos['observaciones'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($articulos as $articulo) {
                $precio = (int) round(((float) $articulo->precio) * 100);

                DB::table('pedido_detalles')->insert([
                    'pedido_id' => $pedidoId,
                    'producto_id' => $articulo->producto_id,
                    'sku' => $articulo->sku,
                    'nombre_producto' => $articulo->nombre,
                    'cantidad' => $articulo->cantidad,
                    'precio_unitario' => number_format($precio / 100, 2, '.', ''),
                    'descuento_unitario' => 0,
                    'subtotal' => number_format(
                        ($precio * $articulo->cantidad) / 100,
                        2, '.', ''
                    ),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('pedido_estados')->insert([
                'pedido_id' => $pedidoId,
                'estado_anterior' => null,
                'estado_nuevo' => 'pendiente_pago',
                'cambiado_por' => $request->user()->id,
                'observacion' => 'Pedido registrado, pago pendiente.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('carrito_detalles')
                ->where('carrito_id', $carrito->id)
                ->delete();

            return $pedidoId;
        });

        return redirect()->route('pedidos.ver', $pedidoId);
    }

    public function verPedido(Request $request, int $pedido)
    {
        $datosPedido = DB::table('pedidos')
            ->where('id', $pedido)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $detalles = DB::table('pedido_detalles')
            ->where('pedido_id', $pedido)
            ->get();

        return view('compra.pedido', compact('datosPedido', 'detalles'));
    }
}
