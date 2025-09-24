<?php

namespace Database\Seeders;

use App\Models\Caracteristica;
use App\Models\Lote;
use App\Models\ValoresCataracteristica;

use Illuminate\Database\Seeder;

class ValoresCaracteristicaSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // $lotes = Lote::all();
    // $caracteristicas = Caracteristica::all();

    // foreach ($lotes as $lote) {
    //   $valoresCaracteristicas = [
    //     [
    //       'lote_id' => $lote->id,
    //       'caracteristica_id' => $caracteristicas->where('nombre', 'Autor')->first()?->id,
    //       'valor' => 'Artista aleatorio ' . rand(1, 100)
    //     ],
    //     [
    //       'lote_id' => $lote->id,
    //       'caracteristica_id' => $caracteristicas->where('nombre', 'Medidas')->first()?->id,
    //       'valor' => rand(20, 80) . 'x' . rand(30, 90) . ' cm'
    //     ],
    //     [
    //       'lote_id' => $lote->id,
    //       'caracteristica_id' => $caracteristicas->where('nombre', 'Estado')->first()?->id,
    //       'valor' => ['Excelente', 'Bueno', 'Regular'][rand(0, 2)]
    //     ],
    //     [
    //       'lote_id' => $lote->id,
    //       'caracteristica_id' => $caracteristicas->where('nombre', 'Audio')->first()?->id,
    //       'valor' => 'audio' . rand(1, 5) . '.mp3'
    //     ],
    //   ];

    //   // Crear los valores si las características existen
    //   foreach ($valoresCaracteristicas as $valor) {
    //     if ($valor['caracteristica_id']) {
    //       ValoresCataracteristica::create($valor);
    //     }
    //   }
    // }


    $lotes = Lote::with('tipo.caracteristicas')->get();

    foreach ($lotes as $lote) {
      $caracteristicas = $lote->tipo->caracteristicas ?? collect();

      foreach ($caracteristicas as $caracteristica) {
        $valor = null;

        switch ($caracteristica->nombre) {
          case 'Autor':
            $valor = 'Artista aleatorio ' . rand(1, 100);
            break;

          case 'Medidas':
            $valor = rand(20, 80) . 'x' . rand(30, 90) . ' cm';
            break;

          case 'Estado':
            $valor = ['Excelente', 'Bueno', 'Regular'][rand(0, 2)];
            break;

          case 'Audio':
            // $valor = 'audio' . rand(1, 5) . '.mp3';
            break;

          default:
            $valor = 'Valor genérico ' . rand(1, 50);
            break;
        }

        // Crear valor si se generó uno
        if ($valor) {
          ValoresCataracteristica::create([
            'lote_id' => $lote->id,
            'caracteristica_id' => $caracteristica->id,
            'valor' => $valor
          ]);
        }
      }
    }
  }
}
