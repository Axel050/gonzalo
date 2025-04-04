<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoAdquirenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          DB::table('estados_adquirentes')->insert(
            [
            ['nombre' => 'habitual'],
            ['nombre' => 'nuevo'],
            ['nombre' => 'suspendido']
        ]);
    }
}
