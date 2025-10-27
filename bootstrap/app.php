<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Configuration\Exceptions;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using:function(){
            Route::namespace('App\Http\Controllers')->group(function(){
        
                Route::middleware('web')->prefix('user')->group(base_path('routes/user.php'));
                Route::middleware('web')->group(base_path('routes/web.php'));

            });
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->group('web',[
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(function () {
            if (request()->is('api/*')) {
                return true;
            }
        });
        $exceptions->respond(function (Response $response) {
            if ($response->getStatusCode() === 401) {
                if (request()->is('api/*')) {
                    $notify[] = 'Unauthorized request';
                    return response()->json([
                        'remark' => 'unauthenticated',
                        'status' => 'error',
                        'message' => ['error' => $notify]
                    ]);
                }
            }

            return $response;
        });
    })->create();



