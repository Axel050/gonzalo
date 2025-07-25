<?php

namespace App\Http\Controllers;

use App\Livewire\LotesActivos;
use App\Models\Adquirente;
use App\Models\Lote;
use App\Models\Subasta;
use App\Services\AdquirenteService;
use App\Services\AdquirenteServiceService;
use App\Services\SubastaService;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Livewire\Livewire;

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
  public function perfil()
  {
    $user  = auth()->user();
    // $adquirente = Adquirente::where("user_id", $user->id)->first();
    $adquirente = Adquirente::where("user_id", $user->id)->first();
    // if (auth()->user()->hasPermissionTo('adquirente-logged')) {
    return view('perfil', compact(["user", "adquirente"]));
    // }

  }

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

  public function lotes()
  {
    $lotes = Lote::limit(3)->get();

    return view("lotes", compact("lotes"));
  }

  public function loted(string $id)
  {
    $lote = Lote::find($id);
    return view("detail", compact("lote"));
  }


  public function getLotes(Subasta $subasta)
  {
    return view("lotes-activos", compact("subasta"));
  }


  public function getLotesActivos(Subasta $subasta)
  {
    info("FIRST");
    if (!$subasta->isActiva()) {
      info("IF");
      return response()->json(['error' => 'Subasta no activa'], 403);
    }
    info("SECOND");

    $lotes = app(SubastaService::class)->getLotesActivos($subasta)->toArray();
    // $lotes = $subasta->lotesActivos()->get()->map(function ($lote) use ($subasta) {
    //   return [
    //     'id' => $lote->id,
    //     'titulo' => $lote->titulo,
    //     'precio_base' => $lote->pivot->precio_base,
    //     'puja_actual' => $lote->getPujaFinal()?->monto,
    //     'tiempo_post_subasta_fin' => $lote->pivot->tiempo_post_subasta_fin,
    //     'estado' => $lote->isActivoEnSubasta($subasta->id) ? 'activo' : 'inactivo',
    //   ];
    // });

    return response()->json($lotes);
  }
}
