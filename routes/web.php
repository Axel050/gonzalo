<?php

use App\Http\Controllers\AdquirenteController;
use App\Http\Controllers\ComitenteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubastaController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Mail\ContratoEmail;
use App\Mail\GarantiaDevolucionEmail;
use App\Mail\OrdenEmail;
use App\Mail\PujaSuperadaEmail;
use Illuminate\Support\Facades\Route;
use App\Models\Adquirente;
use App\Models\Contrato;
use App\Models\ContratoLote;
use App\Models\Lote;
use App\Models\Orden;
use App\Models\Subasta;
use Illuminate\Support\Facades\Mail;

Route::get('/test', function () {
  return view('livewire.auth.role-desactivated');
});





Route::get('/dashboard', function () {
  if (auth()->user()->hasPermissionTo('dashboard-ver')) {
    return view('dashboard');
  }
  return redirect()->route('admin.index')->with('error', 'No tienes permiso para acceder al panel de control.');
})->middleware(['auth', 'active.role', 'admin.only'])->name('dashboard');




Route::middleware("optional.verified")->get('/',  HomeController::class)->name('home');
// Route::get('/',  HomeController::class)->name('home');



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


Route::get('/test-devolucion/{subastaId}/{adquirenteId}/{email}', function (int $subastaId, $adquirenteId, string $email) {
  try {
    $subasta = Subasta::findOrFail($subastaId);
    $adquirente = Adquirente::findOrFail($adquirenteId);


    $data = [
      'alias_bancario' => $adquirente->alias_bancario,
      'subasta' => $subasta->titulo,
      'monto_garantia' => $subasta->garantia,
    ];

    $faltante = $adquirente->datosFiscalesFaltantes();

    info(["faltantes" => $faltante]);

    // return new GarantiaDevolucionEmail($data);


    Mail::to($email)->send(new GarantiaDevolucionEmail($data));

    return response()->json([
      'success' => true,
      'message' => 'Correo enviado exitosamente a Brevo',
      'email'   => $email,
    ]);
  } catch (\Exception $e) {

    info('Error enviando correo de prueba', [

      'email'       => $email,
      'error'       => $e->getMessage()
    ]);

    return response()->json([
      'success' => false,
      'message' => 'Error al enviar el correo',
      'error'   => $e->getMessage(),
      'line'    => $e->getLine()
    ], 500);
  }
})->name('test.mail');




Route::get('/test-mail/{contratoId}/{email}', function (int $contratoId, string $email) {
  try {
    $contrato = Contrato::findOrFail($contratoId);
    $contratoLotes = ContratoLote::where('contrato_id', $contratoId)->get();





    $data = [
      'message'   => 'Este es un mensaje de prueba',
      'lotes'     => $contratoLotes,
      'comitente' => ($contrato->comitente?->nombre ?? '') . " " . ($contrato->comitente?->apellido ?? ''),
      'id'        => $contrato->id,
      'subasta'   => $contrato->subasta_id,
      'fecha'     => $contrato->fecha_firma,
      'cuit' => $contrato->comitente?->CUIT,
      'domicilio' => $contrato->comitente?->domicilio,
      'comision' => $contrato->comitente?->comision_formateada,
    ];



    return new ContratoEmail($data);


    // Mail::to($email)->send(new ContratoEmail($data));

    return response()->json([
      'success' => true,
      'message' => 'Correo enviado exitosamente a Brevo',
      'email'   => $email,
    ]);
  } catch (\Exception $e) {

    info('Error enviando correo de prueba', [
      'contrato_id' => $contratoId,
      'email'       => $email,
      'error'       => $e->getMessage()
    ]);

    return response()->json([
      'success' => false,
      'message' => 'Error al enviar el correo',
      'error'   => $e->getMessage(),
      'line'    => $e->getLine()
    ], 500);
  }
})->name('test.mail');


Route::get('/test-mail-orden/{ordenId}/{adquirenteId}', function ($ordenId, $adquirenteId) {

  $orden = Orden::with(['lotes.lote',  'subasta'])->findOrFail($ordenId);
  $adquirente = Adquirente::findOrFail($adquirenteId);
  $faltantes = $adquirente->datosFiscalesFaltantes();

  $fakeData = [
    'message' => "Creación",
    'lotes' => $orden->lotes,
    'adquirente' => $adquirente,
    "orden_id" => $orden->id,
    "subtotal" => $orden->subtotal,
    "total" => $orden->total_final,
    "descuento" => $orden->descuento,
    "envio" => $orden->monto_envio,
    "subasta_id" => $orden->subasta?->id,
    "subasta_titulo" => $orden->subasta?->titulo,
    "faltantes" => $faltantes,
  ];


  // mail::to($adquirente->user?->email)->send(new OrdenEmail($fakeData));
  // mail::to("axel_505050@hotmail.com")->send(new OrdenEmail($fakeData));
  // mail::to("axeldavidpaz@gmail.com")->send(new OrdenEmail($fakeData));

  return new OrdenEmail($fakeData); // Se renderiza directamente en el navegador
});


Route::get('/test-puja-superada/{loteId}/{adquirenteId}', function ($loteId, $adquirenteId) {

  $lote = Lote::FindOrFail($loteId);
  $adquirente = Adquirente::findOrFail($adquirenteId);

  $dataMail = [
    "monto" => 200,
    "lote_id" => 21,
    "titulo" => "ese",
    "foto" => "esculturas3.jpg",
    "subasta" => "vinos",
  ];


  return new PujaSuperadaEmail($dataMail);
  // mail::to($adquirente->user?->email)->send(new PujaSuperadaEmail($dataMail));
});



Route::get('/comitentes/crear', [ComitenteController::class, "create"])->name('comitentes.create');

Route::get('/adquirentes/crear', [AdquirenteController::class, "create"])->name('adquirentes.create');


Route::get('/adquirentes/perfil', [AdquirenteController::class, "perfil"])->name('adquirentes.perfil');
// Route::get('/adquirentes/perfil', [AdquirenteController::class, "perfil"])->name('adquirentes.perfil')->middleware('auth');

// Route::get('/lotes', function () {

//   $lotes = Lote::where("estado", "en_subasta")->get();
//   $subasta = Subasta::find(9);

//   return view("lotes", compact(["lotes", "subasta"]));
// })->name('lotes')->middleware(['auth']);


Route::get('/lotes/{id}', function ($id) {
  return view('detalle-lotes', compact("id"));
})->name('lotes.show')->middleware(['auth', 'verified']);

Route::get('/pantalla-pujas', function () {
  return view('pantalla-pujas');
})->name('pantalla-pujas')->middleware(['auth', 'verified']);

Route::get('/carrito', function () {
  return view('carrito');
})->name('carrito')->middleware(['auth', 'verified']);

Route::middleware("optional.verified")->get('/subastas', function () {
  return view('subastas');
})->name('subastas');


// Route::get('/tuactivos', LotesActivos::class)->name('lotes.activos');


// Route::get('/subastas/{subasta}/lotes-activos', [AdquirenteController::class, 'getLotesActivos']);

Route::get('/subastas/proximas/{subasta}/lotes', [SubastaController::class, 'getLotesProximos'])->name('subasta-proximas.lotes')->middleware(['auth', 'verified']);

Route::get('/subastas/pasadas/{subasta}/lotes', [SubastaController::class, 'getLotesPasados'])->name('subasta-pasadas.lotes')->middleware(['auth', 'verified']);


Route::get('/subastas/buscador/lotes', [SubastaController::class, 'getLotesSearch'])->name('subasta-buscador.lotes')->middleware(['auth', 'verified']);

Route::get('/subastas/{subasta}/lotes', [SubastaController::class, 'getLotes'])->name('subasta.lotes')->middleware(['auth', 'verified']);


Route::get('/terminos-comitentes', function () {
  return view('terminos-comitentes');
})->name('terminos-comitentes');

Route::get('/terminos-adquirentes', function () {
  return view('terminos-adquirentes');
})->name('terminos-adquirentes');


Route::get('/instructivo-comitentes', function () {
  return view('instructivo-comitentes');
})->name('instructivo-comitentes');

Route::get('/faq', function () {
  return view('faq');
})->name('faq');



// MP
// Route::get(
//   '/success',
//   function () {
//     return redirect()->route('lotes.show', ['id' => 17]);
//   }
// );

// Route::get(
//   '/failure',
//   function () {
//     return "<h1> failure</h1>";
//   }
// );

// Route::get(
//   '/pending',
//   function () {
//     return "<h1> pending</h1>";
//   }
// );

// Route::post('/gonza', [MPController::class, 'notificacion'])->name('subasta.lotes')->middleware(['auth']);
// Route::post('/notification', [MPController::class, 'notification']);


require __DIR__ . '/auth.php';
