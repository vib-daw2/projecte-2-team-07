<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtener el token desde la solicitud
        $token = $request->input('token');

        // Extraer el rol del token
        $role = null;
        if ($token) {
            $payload = explode('|', $token);
            $role = isset($payload[1]) ? $payload[1] : null;
        }

        // Agregar la variable 'role' a la solicitud para que esté disponible en el controlador
        $request->merge(['role' => $role]);

        // Puedes realizar otras verificaciones aquí si es necesario

        return $next($request);
    }
}
