<?php

namespace Database\Seeders;

use App\Models\Adquirente;
use App\Models\Factura;
use App\Models\FacturaLote;
use App\Models\Lote;
use App\Models\Subasta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class FacturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



      $adquirentes = Adquirente::all();
        $subastas = Subasta::all();
        $lotes = Lote::all(); 
        $subId="";
                
            for ($i=1;$i<10;$i++) { 

              $subId=$subastas->random()->id;
              
                $factura = Factura::create([
                    'numero' => rand(1, 1000), 
                    'fecha' => '2024-08-20',
                    'adquirente_id' => $adquirentes->random()->id,
                    'tipo' => 'A',
                    'estado' => 'Pendiente',
                    'condicion_iva' => 'Responsable Inscripto',
                    'comision_subasta' => 100.00,
                    'iva_subasta' => 21.00,
                    // 'subasta_id' => $subId,
                    'observaciones' => 'Factura de prueba',
                ]);


                
                $lotesDeLaSubasta = $lotes->where('subasta_id', $subId)->take(rand(1,3));

                foreach ($lotesDeLaSubasta as $lote) {
                    FacturaLote::create([
                        'factura_id' => $factura->id,
                        'lote_id' => $lote->id,
                        // 'cantidad' => rand(1, 5),
                        'precio' => $lote->precio_base, 
                        'subasta_id' => Subasta::inRandomOrder()->first()->id,
                    ]);
                }

            }


        }
    }

