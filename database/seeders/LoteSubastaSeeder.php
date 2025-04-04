<?php

namespace Database\Seeders;

use App\Models\Contrato;
use App\Models\Lote;
use App\Models\LoteSubasta;
use App\Models\Subasta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoteSubastaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        
            // $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade'); // Relación con lotes
            // $table->foreignId('subasta_id')->constrained('subastas')->onDelete('cascade'); // Relación con subastas
            // $table->decimal('precio_base', 10, 2); // Precio base en el momento de la subasta
            // $table->decimal('precio_final', 10, 2)->nullable(); // Precio final (si se vendió)
            // $table->string('estado')->default('pendiente'); // Estado del lote en la subasta (pendiente, activo, vendido, no_vendido)
        
        for ($i = 0; $i < 10; $i++) {
          $precio =rand(100, 10000);
            LoteSubasta::create([              
              "lote_id" => Lote::inRandomOrder()->first()->id,            
              "subasta_id" => Subasta::inRandomOrder()->first()->id,              
              "contrato_id" => Contrato::inRandomOrder()->first()->id,              
              "precio_base" =>  $precio, 
              "precio_final" =>  $precio + 500, 
            ]);
        
          }
    }
}
