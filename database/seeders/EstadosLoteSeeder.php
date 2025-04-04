<?php

namespace Database\Seeders;

use App\Models\EstadosLote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosLoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estados_lotes')->insert(
            [
            ['titulo' => 'vendido'],
            ['titulo' => 'devuelvo'],
            ['titulo' => 'disponible']
        ]);
    }
}
