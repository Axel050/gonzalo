<?php

namespace App\Http\Controllers;

use App\Models\Adquirente;
use App\Services\AdquirenteService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdquirenteController extends Controller
{
  protected $adquirenteService;

  public function __construct(AdquirenteService $adquirenteService)
  {
    $this->adquirenteService = $adquirenteService;
  }

  /**
   * Display a listing of the resource.
   */
  public function index() {}

  /**
   * Show the form for creating a new resource.
   */
  public function perfilGet()
  {

    $user = Auth::user();

    // info(["USER" => $user->adquirente]);

    $ad = $user->adquirente;

    if (!$ad) {
      return response()->json([
        'message' => 'adquirente no encontrado',
      ], 401);
    }

    return response()->json([
      'message' => 'adquirente encontrado',
      'adquirente' => $ad,
    ], 201);
  }


  public function perfilUpd(Request $request)
  {
    $ad = Adquirente::findOrFail($request['adquirente_id']);


    $data = $request->only([
      'nombre',
      'apellido',
      'telefono',
      'CUIT',
      'domicilio',
      'domicilio_envio',
      'banco',
      'numero_cuenta',
      'CBU',
      'alias_bancario',
      'condicion_iva_id',
    ]);

    $data['id'] = $ad->id;
    $adquirente = $this->adquirenteService->updateAdquirente($data);



    return response()->json([
      'message' => 'adquirente actualizado con éxito',
      'adquirente' => $ad,
    ], 201);
  }


  public function perfil()
  {


    if (!auth()->user()->hasRole('adquirente')) {
      return redirect()->route('home');
    }


    return view('perfil');
  }

  public function create()
  {
    return view('adquirente');
  }


  public function store(Request $request)
  {

    try {
      $adquirente = $this->adquirenteService->createAdquirente($request->all());
      return response()->json([
        'message' => 'adquirente creado con éxito',
        'adquirente' => $adquirente,
      ], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return response()->json([
        'message' => 'Errores de validación',
        'errors' => $e->errors(),
      ], 422);
    } catch (\Exception $e) {
      return response()->json([
        'message' => 'Ocurrió un error',
        'error' => $e->getMessage(),
      ], 500);
    }
  }


  /**
   * Display the specified resource.
   */
  public function show(string $id) {}

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id) {}

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id) {}

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id) {}
}
