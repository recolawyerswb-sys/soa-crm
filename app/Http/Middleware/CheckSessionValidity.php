<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionValidity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario no está logueado, no hacemos nada.
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        $sessionLoginTime = session('logged_in_at');

        // 🔑 LA LÓGICA CLAVE:
        // Si el usuario tiene una fecha de invalidación Y esa fecha es MÁS RECIENTE
        // que la fecha en que se inició esta sesión, la sesión ya no es válida.
        if ($user->last_session_invalidation_at && $user->last_session_invalidation_at->timestamp > $sessionLoginTime) {

            Auth::logout(); // Cierra la sesión del usuario.
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirige al login con un mensaje.
            return redirect()->route('login')->with('error', 'Tu sesión ha expirado, por favor inicia sesión de nuevo.');
        }

        return $next($request);
    }
}
