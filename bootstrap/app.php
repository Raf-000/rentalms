<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Trust all proxies for ngrok
        $middleware->trustProxies(at: '*');
        
        // Trust ngrok hosts
        $middleware->trustHosts(at: [
            'veristic-unangular-criselda.ngrok-free.dev',
            'localhost',
            '*.ngrok-free.dev'
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();