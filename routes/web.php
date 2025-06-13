<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Mail\TestEmail;
use App\Models\Contrato;
use App\Models\ContratoLote;

Route::get('/test', function () {
  return view('livewire.auth.role-desactivated');
});

Route::get('/', function () {
  return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
  ->middleware(['auth', 'verified', 'active.role'])
  ->name('dashboard')
  ->can("dashboard-ver");

Route::middleware(['auth'])->group(function () {
  Route::redirect('settings', 'settings/profile');

  Route::get('settings/profile', Profile::class)->name('settings.profile');
  Route::get('settings/password', Password::class)->name('settings.password');
  Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});


// Route::get('/lotes/{id}', [QrCodeController::class, 'show'])->name('lotes.show');
Route::get('/lotes/{id}', function ($id) {
  // $id = 11;
  return view('detalle-lotes', compact("id"));
})->name('lotes.show');


// TESTER MAIL 
Route::get('/test-mail', function () {

  $contratoLotes = ContratoLote::where('contrato_id', 6)->get();
  $contrato = Contrato::find(5);
  $data = [
    'message' => 'Este es un mensaje de prueba',
    'lotes' => $contratoLotes,
    'comitente' => $contrato->comitente?->nombre . " " . $contrato->comitente?->apellido,
    "id" => $contrato->id,
    "subasta" => $contrato->subasta_id,
    "fecha" => $contrato->fecha_firma,
  ];


  return (new TestEmail($data))->render();
});

require __DIR__ . '/auth.php';
