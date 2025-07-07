<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
    then: function () {
      // Route::middleware('web', 'auth', 'active.role') // <-- Aplica el grupo de middleware 'web' (u otro que necesites, ej: 'auth', ['web', 'auth'])
      Route::middleware('web', 'auth', 'active.role') // <-- Aplica el grupo de middleware 'web' (u otro que necesites, ej: 'auth', ['web', 'auth'])
        ->prefix('admin')   // <-- Opcional: Añade el prefijo /admin a todas las rutas del archivo
        ->name('admin.')    // <-- Opcional: Añade el prefijo 'admin.' a los nombres de las rutas
        ->group(base_path('routes/admin.php')); // <-- Ahora sí, group() carga el archivo dentro del contexto del middleware/prefijo

      Route::middleware('api')
        ->prefix('api') // Asegura el prefijo /api
        ->name('api.')  // Opcional: Prefijo para nombres de rutas
        ->group(base_path('routes/api.php'));
    }
  )
  ->withMiddleware(function (Middleware $middleware) {
    //

    $middleware->alias([
      'active.role' => \App\Http\Middleware\CheckActiveRole::class,
      'adquirente.logged' => \App\Http\Middleware\CheckAdquirenteLogged::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();
