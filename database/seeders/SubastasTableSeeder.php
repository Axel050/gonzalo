<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubastasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Factory::create();

        foreach (range(1, 10) as $index) {
            DB::table('subastas')->insert([
                // 'numero_subasta' => $index,
                'titulo' => $faker->sentence(3),
                'descripcion' => $faker->sentence(10),
                'comision' => $faker->randomFloat(2, 10, 25),
                'fecha_inicio' => $faker->dateTimeBetween('-1 months', 'now'),
                'fecha_fin' => $faker->dateTimeBetween('now', '+1 months'),
                'tiempo_post_subasta' => $faker->numberBetween(1, 24),
                'estado' => $faker->boolean,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
