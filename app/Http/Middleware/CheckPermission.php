<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(
        Request $request,
        Closure $next,
        string $permission
    ): Response {
        $user = $request->user();

        if (!$user) {
            abort(401, 'Debes iniciar sesión.');
        }

        if (!$user->hasPermission($permission)) {
            abort(403, 'No tienes permiso para acceder.');
        }

        return $next($request);
    }
}
