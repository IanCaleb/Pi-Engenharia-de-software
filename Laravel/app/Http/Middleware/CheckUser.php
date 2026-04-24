<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o usuário está logado e se é um donatário
        if (!$request->user() || $request->user()->role !== 'user') {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}