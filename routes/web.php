<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

/*
Página principal de MIMISHI
*/
Route::get('/', function () {
    $categorias = \App\Models\Categoria::where('estado', true)
        ->orderBy('nombre')
        ->get();

    $productos = \App\Models\Producto::with('categoria')
        ->where('estado', true)
        ->whereHas('categoria', function ($query) {
            $query->where('estado', true);
        })
        ->latest()
        ->take(8)
        ->get();

    return view('home', compact('categorias', 'productos'));
})->name('home');

Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/contacto', 'contacto')->name('contacto');

/*Autenticación de usuarios*/


Route::middleware('guest')->group(function () {

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login.form');

    Route::get('/registro', function () {
        return view('auth.register');
    })->name('registro.form');

    Route::post('/registro', [AuthController::class, 'register'])
        ->name('registro');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login');

});

/*
|--------------------------------------------------------------------------
| Cierre de sesión
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Prueba del sistema de permisos
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'permission:usuarios.administrar'])
    ->get('/prueba-permisos', function () {

        return response()->json([
            'success' => true,
            'message' => 'Acceso autorizado a MIMISHI',
        ]);

    });


Route::middleware(['auth', 'permission:productos.gestionar'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource(
            'categorias',
            \App\Http\Controllers\Admin\CategoriaController::class
        )->except(['show', 'destroy']);

        Route::resource(
            'productos',
            \App\Http\Controllers\Admin\ProductoController::class
        )->except(['show', 'destroy']);

    });


Route::middleware('auth')->group(function () {

    Route::post('/carrito/agregar',
        [\App\Http\Controllers\CompraController::class, 'agregar']
    )->name('carrito.agregar');

    Route::get('/carrito',
        [\App\Http\Controllers\CompraController::class, 'carrito']
    )->name('carrito.index');

    Route::post('/carrito/quitar/{detalle}',
        [\App\Http\Controllers\CompraController::class, 'quitar']
    )->name('carrito.quitar');

    Route::get('/checkout',
        [\App\Http\Controllers\CompraController::class, 'checkout']
    )->name('compra.checkout');

    Route::post('/checkout',
        [\App\Http\Controllers\CompraController::class, 'confirmar']
    )->name('compra.confirmar');

    Route::get('/mis-pedidos/{pedido}',
        [\App\Http\Controllers\CompraController::class, 'verPedido']
    )->name('pedidos.ver');

});

