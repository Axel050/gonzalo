<?php

namespace App\Http\Controllers;

use App\Services\CarritoService;
use App\Services\PujaService;
use DomainException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use InvalidArgumentException;

class CarritoController extends Controller
{
  protected $carritoService;
  protected $pujaService;

  public function __construct(CarritoService $carritoService, PujaService $pujaService)
  {
    $this->carritoService = $carritoService;
    $this->pujaService = $pujaService;
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


  public function store(Request $request)
  {
    try {
      $this->carritoService->agregar(
        $request->input('adquirente_id'),
        $request->input('lote_id')
      );

      return response()->json([
        'success' => true,
        'message' => 'Lote agregado correctamente al carrito'
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 404);
    } catch (InvalidArgumentException | DomainException $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage()
      ], 409);
    } catch (\Exception $e) {
      info('Error en CarritoController::store', ['exception' => $e]);
      return response()->json([
        'success' => false,
        'message' => 'Error interno al agregar el lote.'
      ], 500);
    }
  }


  /**
   * Store a newly created resource in storage.
   */
  public function pujar(Request $request)
  {
    $adquirenteId = $request->input('adquirente_id');
    $loteId = $request->input('lote_id');
    $monto = $request->input('monto');

    try {
      $result = $this->pujaService->registrarPuja($adquirenteId, $loteId, $monto);
      session()->flash('success', 'Puja registrada correctamente.');
      return response()->json($result, $result['code']);
    } catch (ModelNotFoundException $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
    } catch (InvalidArgumentException $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
    } catch (DomainException $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
    } catch (\Exception $e) {
      info('Error en registrarPuja', ['error' => $e->getMessage()]);
      return response()->json(['success' => false, 'message' => 'Error interno'], 500);
    }
  }



  // Quitar lote carrito 
  public function destroy(Request $request)
  {

    $adquirenteId = $request->input('adquirente_id');
    $loteId = $request->input('lote_id');

    if (!$adquirenteId || !$loteId) {
      return response()->json([
        "message" => "Adquirente y lote requeridos"
      ], 400);
    }

    try {
      $this->carritoService->quitar($adquirenteId, $loteId);

      return response()->json([
        'success' => true,
        'message' => 'Lote eliminado del carrito exitosamente',
      ], 200);
    } catch (ModelNotFoundException $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
      ], 404);
    } catch (InvalidArgumentException $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
      ], 400);
    } catch (\Exception $e) {
      info('Error en CarritoController::destroy', ['exception' => $e->getMessage()]);

      return response()->json([
        'success' => false,
        'message' => 'Error interno del servidor.',
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
}
