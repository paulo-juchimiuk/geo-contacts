<?php

declare(strict_types=1);

namespace App\Modules\Auth\Infrastructure\Adapter\In\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ?string $guard = null): Response
    {
        return $next($request);
    }
}
