<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PortalTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasCookie('portal_access_token')) {
            $token = $request->cookie('portal_access_token');
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }
        return $next($request);
    }
}
