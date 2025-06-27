<?php

namespace App\Http\Controllers;

use App\Services\ComitenteService;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

class ComitenteController extends Controller
{
  protected $comitenteService;

  public function __construct(ComitenteService $comitenteService)
  {
    $this->comitenteService = $comitenteService;
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
    return view('comitente');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    info('Inicio de store');

    // dd("ásssss");
    try {
      $comitente = $this->comitenteService->createComitente($request->all());
      return response()->json([
        'message' => 'Comitente creado con éxito',
        'comitente' => $comitente,
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
