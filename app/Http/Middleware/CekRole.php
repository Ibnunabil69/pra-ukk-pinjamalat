<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            abort(403); // lebih aman dari redirect
        }

        return $next($request);
    }
}