<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOrganizador
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->user_type !== 'organizador') {
            return redirect()->route('home')
                ->with('error', '🔒 Acceso restringido: Solo los organizadores pueden acceder a esta sección.');
        }

        return $next($request);
    }
}