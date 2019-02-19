<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function handle($request, \Closure $next)
    {
        if ($request->headers->get('Origin') === 'capacitor://localhost') {
            return parent::addCookieToResponse($request, $next($request));
        } else {
            return parent::handle($request, $next);
        }
    }
}