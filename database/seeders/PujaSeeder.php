<?php

namespace Database\Seeders;

use App\Models\Adquirente;
use App\Models\Lote;
use App\Models\Puja;
use App\Models\Subasta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PujaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
          for ($i = 0; $i < 10; $i++) {
            Puja::create([              
              "lote_id" => Lote::inRandomOrder()->first()->id,
              "adquirente_id" => Adquirente::inRandomOrder()->first()->id,
              "subasta_id" => Subasta::inRandomOrder()->first()->id,              
              "monto" =>  rand(100, 10000), 
            ]);

          }
    }
}
