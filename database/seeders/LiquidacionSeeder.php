<?php

namespace Database\Seeders;

use App\Models\Comitente;
use App\Models\Liquidacion;
use App\Models\LiquidacionLote;
use App\Models\Lote;
use App\Models\Subasta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LiquidacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $comitentes = Comitente::all();
        $lotes = Lote::all(); // Asegúrate de tener lotes creados

        $comId="";
        for ($i=1;$i<10;$i++) { 

          $$comId=$comitentes->random()->id;
            $liquidacion = Liquidacion::create([
                'numero' => rand(1, 1000), // Números de liquidación aleatorios
                'fecha' => '2024-08-21', // Fecha de liquidación
                'estado' => 'Pendiente', // Estado inicial
                'comitente_id' => $$comId,
            ]);

            // Asociar lotes a la liquidación (puedes ajustar la lógica)
            $lotesDelComitente = $lotes->where('comitente_id', $comId)->take(rand(1,3)); // Toma entre 1 y 3 lotes del comitente

            foreach ($lotesDelComitente as $lote) {
                LiquidacionLote::create([
                    'liquidacion_id' => $liquidacion->id,
                    'lote_id' => $lote->id,
                    'subasta_id' => Subasta::inRandomOrder()->first()->id,
                ]);
            }
        }
    }
}
