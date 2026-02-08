<?php

use App\Http\Controllers\AdquirenteController;
use App\Http\Controllers\CarritoController;
use Illuminate\Http\Request;
use App\Http\Controllers\ComitenteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MPController;
use App\Http\Controllers\SubastaController;
use Illuminate\Support\Facades\Route;


// <!-- Route::middleware('auth:sanctum')->group(function () { -->



// Al agregar app,  crear middleware por auth ,  miestras quedaran comentadas

// Route::post('/comitentes/store', [ComitenteController::class, 'store'])->name('comitentes.store');

// Route::post('/adquirentes/store', [AdquirenteController::class, 'store'])->name('adquirentes.store');

// Route::middleware('auth:sanctum')->get('/adquirentes/perfil', [AdquirenteController::class, 'perfilGet'])->name('adquirentes.perfil');
// Route::middleware('auth:sanctum')->put('/adquirentes/perfil', [AdquirenteController::class, 'perfilUpd'])->name('adquirentes.perfil');



// Route::middleware('auth:sanctum')->get('/subastas/{subasta}/lotes', [SubastaController::class, 'getLotesActivos']);

// Route::middleware('auth:sanctum')->get('/subastas-proximas/{subasta}/lotes', [SubastaController::class, 'lotesProximos']);

// Route::middleware('auth:sanctum')->get('/subastas-pasadas/{subasta}/lotes', [SubastaController::class, 'lotesPasados']);

// Route::middleware('auth:sanctum')->get('/subastas-all', [SubastaController::class, 'subastasAll']);



// Route::middleware('auth:sanctum')->get('/carrito-show', [CarritoController::class, 'getEstadoCarrito']);

// Route::middleware('auth:sanctum')->delete('/carrito', [CarritoController::class, 'destroy'])->name('carrito.delete');

// Route::middleware('auth:sanctum')->post('/carrito', [CarritoController::class, 'store'])->name('carrito.store');


// Route::middleware('auth:sanctum')->post('/carrito/pujar', [CarritoController::class, 'pujar'])->name('carrito.pujar');

// Route::middleware('auth:sanctum')->get('/carrito-ordenes', [CarritoController::class, 'getOrdenes']);


// Route::post('/notification', [MPController::class, 'notification']);




// Route::post('/login', [LoginController::class, 'login']);
// Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);



// Route::post('/notification', [MPController::class, 'notificationOrden'])->name("orden.pago.success");


// });
