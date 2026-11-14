<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'telefono' => ['nullable', 'string', 'max:20'],
        ]);

        $cliente = Role::where('nombre', 'Cliente')
            ->where('estado', true)
            ->firstOrFail();

        DB::transaction(function () use ($datos, $cliente, &$user) {
            $user = User::create([
                'name' => $datos['name'],
                'email' => $datos['email'],
                'password' => $datos['password'],
                'telefono' => $datos['telefono'] ?? null,
                'estado' => true,
            ]);

            $user->roles()->attach($cliente->id);
        });

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Registro exitoso',
            'user' => $user->only('id', 'name', 'email'),
        ], 201);
    }

    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credenciales['estado'] = true;

        if (!Auth::attempt($credenciales)) {
            throw ValidationException::withMessages([
                'email' => 'Credenciales incorrectas o cuenta inactiva.',
            ]);
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'user' => Auth::user()->only('id', 'name', 'email'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Sesión cerrada correctamente',
        ]);
    }
}
