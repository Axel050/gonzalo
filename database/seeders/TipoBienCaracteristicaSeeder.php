<?php

namespace Database\Seeders;

use App\Models\Caracteristica;
use App\Models\TiposBien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoBienCaracteristicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          DB::table('tipo_bien_caracteristicas')->truncate();

        // Relacionar tipos de bien con características
        $relaciones = [
            'Pintura' => ['Título', 'Autor', 'Técnica', 'Medidas', 'Estado', 'Firma'],
            'Escultura' => ['Título', 'Artista', 'Material', 'Medidas', 'Peso', 'Época'],
            'Libro' => ['Título', 'Autor', 'Editorial', 'Año de publicación', 'ISBN'],
            'Objeto' => ['Título', 'Descripción', 'Época', 'Estado', 'Firma']
        ];

        foreach ($relaciones as $tipoBienNombre => $caracteristicas) {
            $tipoBien = TiposBien::where('nombre', $tipoBienNombre)->first();

            if ($tipoBien) {
                foreach ($caracteristicas as $caracteristicaNombre) {
                    $caracteristica = Caracteristica::where('nombre', $caracteristicaNombre)->first();

                    if ($caracteristica) {
                        DB::table('tipo_bien_caracteristicas')->insert([
                            'tipo_bien_id' => $tipoBien->id,
                            'caracteristica_id' => $caracteristica->id,
                        ]);
                    }
                }
            }
          }
    }
}
