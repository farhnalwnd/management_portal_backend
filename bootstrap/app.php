<?php

use App\Http\Middleware\PortalTokenMiddleware;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/status',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(['portal.token' => PortalTokenMiddleware::class]);
        $middleware->priority([
            PortalTokenMiddleware::class,
            Authenticate::class,
        ]);
        $middleware->redirectGuestsTo(fn () => config('services.sso.portal_url'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
