<?php

use App\Http\Controllers\AdquirenteController;
use App\Http\Controllers\ComitenteController;
use App\Http\Controllers\MPController;
use App\Livewire\LotesActivos;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Mail\ContratoEmail;
use Illuminate\Support\Facades\Route;
use App\Mail\TestEmail;
use App\Models\Contrato;
use App\Models\ContratoLote;
use App\Models\Lote;
use App\Models\Subasta;

Route::get('/test', function () {
  return view('livewire.auth.role-desactivated');
});


Route::get('/dashboard', function () {
  if (auth()->user()->hasPermissionTo('dashboard-ver')) {
    return view('dashboard');
  }
  return redirect()->route('admin.index')->with('error', 'No tienes permiso para acceder al panel de control.');
})->middleware(['auth', 'verified', 'active.role'])->name('dashboard');


Route::get('/', function () {
  return view('welcome');
})->name('home');


// Route::view('dashboard', 'dashboard')
//   ->middleware(['auth', 'verified', 'active.role'])
//   ->name('dashboard')
//   ->can("dashboard-ver");


Route::middleware(['auth'])->group(function () {
  Route::redirect('settings', 'settings/profile');
  Route::get('settings/profile', Profile::class)->name('settings.profile');
  Route::get('settings/password', Password::class)->name('settings.password');
  Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});


// Route::get('/lotes/{id}', [QrCodeController::class, 'show'])->name('lotes.show');





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


  return (new ContratoEmail($data))->render();
});

// dd("TTTTEEST EL POST ; CREAR UN FORMULARIO CON PSOT ; SIMPLE PARA ASFGURA EL CSRF TOKEN");
Route::get('/comitentes/crear', [ComitenteController::class, "create"])->name('comitentes.create');

Route::get('/adquirentes/crear', [AdquirenteController::class, "create"])->name('adquirentes.create');

Route::get('/comitentes/test', function () {
  return response()->json(['message' => 'Ruta de test funcionando correctamente']);
});

Route::post('/comitentes/store', [ComitenteController::class, 'store'])->name('comitentes.store');

Route::get('/csrf-token', function () {
  return response()->json(['csrf_token' => csrf_token()]);
});



Route::get('/adquirentes/perfil', [AdquirenteController::class, "perfil"])->name('adquirentes.perfil')->middleware('adquirente.logged');

Route::get('/lotes', function () {

  $lotes = Lote::where("estado", "en_subasta")->get();
  $subasta = Subasta::find(9);

  return view("lotes", compact(["lotes", "subasta"]));
})->name('lotes')->middleware(['auth']);


Route::get('/lotes/{id}', function ($id) {
  return view('detalle-lotes', compact("id"));
})->name('lotes.show')->middleware(['auth']);;

Route::get('/carrito', function () {
  return view('carrito');
})->name('carrito')->middleware(['auth']);;


Route::get('/tuactivos', LotesActivos::class)->name('lotes.activos');
// Route::get('/subastas/{subasta}/lotes-activos', [AdquirenteController::class, 'getLotesActivos']);

Route::get('/subastas/{subasta}/lotes', [AdquirenteController::class, 'getLotes'])->name('subasta.lotes')->middleware(['auth']);


// MP
Route::get(
  '/success',
  function () {
    // return redirect()->route('lotes.show', ['id' => 123]);
    return "<h1> SUCEESS</h1>";
  }
);

Route::get(
  '/failure',
  function () {
    return "<h1> failure</h1>";
  }
);

Route::get(
  '/pending',
  function () {
    return "<h1> pending</h1>";
  }
);

// Route::post('/gonza', [MPController::class, 'notificacion'])->name('subasta.lotes')->middleware(['auth']);
// Route::post('/notification', [MPController::class, 'notification']);


require __DIR__ . '/auth.php';
