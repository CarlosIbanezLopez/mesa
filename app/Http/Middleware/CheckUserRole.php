<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Verifica si el usuario está autenticado y tiene un rol permitido
        if (Auth::check() && in_array(Auth::user()->usertype_id, $roles)) {
            return $next($request);
        }

        // Redirige si no tiene permisos
        return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta acción.');
    }
}
