<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Verificar sesión
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        }
        // 2. Si no hay sesión, verificar idioma del navegador
        else {
            $browserLang = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            if (in_array($browserLang, ['en', 'es'])) {
                app()->setLocale($browserLang);
                session()->put('locale', $browserLang);
            } else {
                app()->setLocale('es'); // idioma por defecto
                session()->put('locale', 'es');
            }
        }
        
        return $next($request);
    }
}