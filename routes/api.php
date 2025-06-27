<?php

use App\Http\Controllers\AdquirenteController;
use Illuminate\Http\Request;
use App\Http\Controllers\ComitenteController;
use Illuminate\Support\Facades\Route;


// <!-- Route::middleware('auth:sanctum')->group(function () { -->



Route::get('/comitentes/test', function () {
  return response()->json(['message' => 'Ruta de test funcionando correctamente']);
})->name("comitentes.test");


Route::post('/comitentes/store', [ComitenteController::class, 'store'])->name('comitentes.store');

Route::post('/adquirentes/store', [AdquirenteController::class, 'store'])->name('adquirentes.store');
// });
