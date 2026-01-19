<?php

namespace App\Http\Controllers;

use App\Models\Subasta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function __invoke(Request $request)
  {
    // $subastasProx = Subasta::where('fecha_inicio', '>=', Carbon::now())->get();

    // $subastasAct = Subasta::whereIn('estado', ["activa", "enpuja"])->get();
    // $subastasFin = Subasta::whereIn('estado', ["finalizada"])->get();
    $subastasProx = Subasta::proximas()->get();
    $subastasFin = Subasta::finalizadas()->get();
    $last = Subasta::whereIn('estado', ['activa', 'en_puja'])
      ->where('fecha_fin', '>', Carbon::now())
      ->orderBy('fecha_fin', 'asc')
      ->first();
    // info(["subastas " => $subastas]);



    // $destacados = app(SubastaService::class)->getLotesActivosDestacadosHome()->toArray();


    // $contadorDestacados = !empty($destacados);


    $showVerifiedModal = request()->has('verified') && request()->query('verified') == 1;




    return view('welcome', compact(
      'subastasProx',
      'subastasFin',
      'last',
      'showVerifiedModal'
    ));
  }
}
