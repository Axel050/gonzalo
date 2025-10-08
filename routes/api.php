<?php

use App\Http\Controllers\AdquirenteController;
use App\Http\Controllers\CarritoController;
use Illuminate\Http\Request;
use App\Http\Controllers\ComitenteController;
use App\Http\Controllers\MPController;
use Illuminate\Support\Facades\Route;


// <!-- Route::middleware('auth:sanctum')->group(function () { -->



Route::get('/comitentes/test', function () {
  return response()->json(['message' => 'Ruta de test funcionando correctamente']);
})->name("comitentes.test");


// Al agregar app,  crear middleware por auth ,  miestras quedaran comentadas

Route::post('/comitentes/store', [ComitenteController::class, 'store'])->name('comitentes.store');

Route::post('/adquirentes/store', [AdquirenteController::class, 'store'])->name('adquirentes.store');

Route::get('/subastas/{subasta}/lotes', [AdquirenteController::class, 'getLotesActivos']);





Route::delete('/carrito', [CarritoController::class, 'destroy'])->name('carrito.delete');

Route::post('/carrito', [CarritoController::class, 'store'])->name('carrito.store');

Route::post('/carrito/pujar', [CarritoController::class, 'pujar'])->name('carrito.pujar');

Route::post('/notification', [MPController::class, 'notification']);



// Route::post('/notification', [MPController::class, 'notificationOrden'])->name("orden.pago.success");
// });
