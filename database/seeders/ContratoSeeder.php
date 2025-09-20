<?php

namespace Database\Seeders;

use App\Models\Comitente;
use App\Models\Contrato;
use App\Models\Subasta;
use Illuminate\Database\Seeder;

class ContratoSeeder extends Seeder
{
  public function run(): void
  {
    $subastas = Subasta::all();
    $comitentes = Comitente::take(5)->get();

    foreach ($subastas as $subasta) {
      foreach ($comitentes as $comitente) {
        // Verificar si ya existe contrato para este comitente y subasta
        $contratoExistente = Contrato::where('subasta_id', $subasta->id)
          ->where('comitente_id', $comitente->id)
          ->first();

        if (!$contratoExistente) {
          Contrato::create([
            'archivo_path'   => 'contratos/' . $subasta->titulo . '_' . $comitente->id . '.pdf',
            'fecha_firma'    => now()->subDays(rand(1, 30)),
            'comitente_id'   => $comitente->id,
            'subasta_id'     => $subasta->id,
            'descripcion'    => "Contrato para la subasta: " . $subasta->titulo,
          ]);
        }
      }
    }
  }
}
