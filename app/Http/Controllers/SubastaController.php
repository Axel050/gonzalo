<?php

namespace App\Http\Controllers;

use App\DTOs\PaginatedLotesDTO;
use App\Http\Resources\SubastasHomeResource;
use App\Models\Subasta;
use App\Services\ComitenteService;
use App\Services\SubastaService;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

class SubastaController extends Controller
{
  protected $comitenteService;

  public function __construct() {}

  /**
   * Display a listing of the resource.
   */
  public function index() {}

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    // return view('comitente');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {}


  public function subastasAll(SubastaService $service)
  {
    return response()->json([
      'activas' => SubastasHomeResource::collection(
        $service->activas()
      ),
      'proximas' => SubastasHomeResource::collection(
        $service->proximas()
      ),
      'finalizadas' => SubastasHomeResource::collection(
        $service->finalizadas()
      ),
    ]);
  }



  public function getLotesActivos(Subasta $subasta, Request $request)
  {

    if (!$subasta->isActiva()) {

      return response()->json(['error' => 'Subasta no activa'], 403);
    }


    $search  = $request->query('search');
    $page    = (int) $request->query('page', 1);
    $perPage = (int) $request->query('per_page', 6);

    // 📦 Fuente única de datos
    $paginator = app(SubastaService::class)->getLotesActivos(
      $subasta,
      $search,
      ! empty($search),
      $page,
      $perPage
    );

    // 🎯 Contrato idéntico a Livewire
    return response()->json(
      PaginatedLotesDTO::fromPaginator($paginator, 'pujas')->toArray()
    );
  }


  public function lotesPasados(Request $request, Subasta $subasta)
  {
    $search  = $request->query('search');
    $page    = (int) $request->query('page', 1);
    $perPage = (int) $request->query('per_page', 6);

    // 📦 Fuente única de datos
    $paginator = app(SubastaService::class)->getLotesPasados(
      $subasta,
      $search,
      ! empty($search),
      $page,
      $perPage
    );

    // 🎯 Contrato idéntico a Livewire
    return response()->json(
      PaginatedLotesDTO::fromPaginator($paginator, 'estado')->toArray()
    );
  }

  public function lotesProximos(Request $request, Subasta $subasta)
  {
    $search  = $request->query('search');
    $page    = (int) $request->query('page', 1);
    $perPage = (int) $request->query('per_page', 6);

    // 📦 Fuente única de datos
    $paginator = app(SubastaService::class)->getLotesProximos(
      $subasta,
      $search,
      ! empty($search),
      $page,
      $perPage
    );

    // 🎯 Contrato idéntico a Livewire
    return response()->json(
      PaginatedLotesDTO::fromPaginator($paginator, 'estado')->toArray()
    );
  }



  public function getLotes(Subasta $subasta)
  {
    return view("lotes-activos", compact("subasta"));
  }

  public function getLotesProximos(Subasta $subasta)
  {
    return view("lotes-proximos", compact("subasta"));
  }

  public function getLotesPasados(Subasta $subasta)
  {
    return view("lotes-pasados", compact("subasta"));
  }

  public function getLotesSearch()
  {
    return view("lotes-search");
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
