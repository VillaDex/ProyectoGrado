<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }
    
        // Superadmin tiene acceso a TODO
        if (auth()->user()->hasRole('superadmin')) {
            return $next($request);
        }
    
        // Permitir acceso a productos a funcionarios de compra y venta
        if ($request->route()->getName() === 'productos.index' &&
            (auth()->user()->hasRole('funcionario-compra') || auth()->user()->hasRole('funcionario-venta'))) {
            return $next($request);
        }
    
        // Verificar otros roles
        foreach ($roles as $role) {
            if (auth()->user()->hasRole($role)) {
                return $next($request);
            }
        }
    
        abort(403, 'Acceso restringido');
    }
    
}
