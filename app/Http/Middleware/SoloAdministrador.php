<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SoloAdministrador
{
    public function handle(Request $solicitud, Closure $siguiente): Response
    {
        abort_unless($solicitud->user()?->esAdministrador(), 403, 'No tienes permisos para entrar al panel de administración.');
        return $siguiente($solicitud);
    }
}