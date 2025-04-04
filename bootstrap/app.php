<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
          then: function () {
            Route::middleware('web','auth') // <-- Aplica el grupo de middleware 'web' (u otro que necesites, ej: 'auth', ['web', 'auth'])
                 ->prefix('admin')   // <-- Opcional: Añade el prefijo /admin a todas las rutas del archivo
                 ->name('admin.')    // <-- Opcional: Añade el prefijo 'admin.' a los nombres de las rutas
                 ->group(base_path('routes/admin.php')); // <-- Ahora sí, group() carga el archivo dentro del contexto del middleware/prefijo
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
