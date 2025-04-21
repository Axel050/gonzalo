<?php

namespace Database\Seeders;

use App\Models\Adquirente;
use App\Models\AdquirentesAlias;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdquirenteAliasSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $adquirentes = Adquirente::all();

    foreach ($adquirentes as $adquirente) {
      // Genera alias automático (ej: "MPAEZ")
      $aliasAuto = strtoupper(
        substr($adquirente->nombre, 0, 1) .
          preg_replace('/\s+/', '', $adquirente->apellido)
      );

      // Crea el registro
      AdquirentesAlias::create([
        'alias' => $aliasAuto,
        'adquirente_id' => $adquirente->id,
        'is_primary' => true // Marca como alias principal
      ]);

      // Opcional: Añadir alias alternativos
      if ($adquirente->id === 1) {
        AdquirentesAlias::create([
          'alias' => 'MIGUELP',
          'adquirente_id' => $adquirente->id,
          'is_primary' => false
        ]);
      }
    }
  }
}
