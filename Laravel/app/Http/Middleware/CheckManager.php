<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckManager
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o usuário está logado e se é um gerente
        if (!$request->user() || $request->user()->role !== 'manager') {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}