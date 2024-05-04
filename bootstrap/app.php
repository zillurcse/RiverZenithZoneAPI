<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function (){
            Route::middleware(['api'])
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
        $response = new \App\ApiResponseClass();
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $exception){
            return response()->json('hello world!!!');
        });
        $exceptions->render(function (\Symfony\Component\Routing\Exception\RouteNotFoundException $exception) use($response){
            return $response->errorResponse($exception->getMessage());
        });
        $exceptions->render(function (\Illuminate\Database\QueryException $exception) use($response){
            return $response->errorResponse('sql query error!', [$exception->getMessage()], 500);
        });
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception) use($response){
            return $response->errorResponse('data not found!', [$exception->getMessage()], 404);
        });
        $exceptions->render(function (InvalidArgumentException $exception) use($response){
            return $response->errorResponse('data not found!', [$exception->getMessage()], 404);
        });
    })
    ->create();
