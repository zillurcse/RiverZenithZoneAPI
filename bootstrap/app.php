<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function (){
            Route::middleware(['api', 'auth:sanctum'])
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            Route::middleware(['api', 'auth:admin'])
                ->prefix('api/admin')
                ->group(base_path('routes/admin.php'));
            Route::middleware(['web'])
                ->group(base_path('routes/web.php'));
        },
//        web: __DIR__.'/../routes/web.php',
//        api: __DIR__.'/../routes/api.php',
//        commands: __DIR__.'/../routes/console.php',
//        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
