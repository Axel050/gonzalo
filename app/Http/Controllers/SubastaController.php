<?php

namespace App\Http\Controllers;

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



  public function lotesProximos(Request $request, Subasta $subasta)
  {
    $search = $request->query('search');
    $perPage = $request->query('per_page', 10);

    // 🔥 optimización clave
    $conCaracteristicas = !empty($search);

    $paginator = app(SubastaService::class)->getLotesProximos(
      $subasta,
      $search,
      $conCaracteristicas,
      1,
      $perPage
    );

    return response()->json([
      'data' => $paginator->items(),
      'meta' => [
        'current_page' => $paginator->currentPage(),
        'last_page'    => $paginator->lastPage(),
        'per_page'     => $paginator->perPage(),
        'total'        => $paginator->total(),
        'has_more'     => $paginator->hasMorePages(),
      ],
    ]);
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
