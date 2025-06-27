<?php

namespace App\Http\Controllers;

use App\Services\AdquirenteService;
use App\Services\AdquirenteServiceService;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

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
  public function create()
  {
    return view('adquirente');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    info('Inicio de store');

    // dd("ásssss");
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
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
