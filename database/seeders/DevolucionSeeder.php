<?php

namespace Database\Seeders;

use App\Models\Devolucion;
use App\Models\Lote;
use App\Models\MotivoDevolucion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevolucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           MotivoDevolucion::create([
            'nombre' => 'Producto Defectuoso',
            'descripcion' => 'El producto presenta fallas de fábrica.',
        ]);

        MotivoDevolucion::create([
            'nombre' => 'Producto Incorrecto',
            'descripcion' => 'Se recibió un producto diferente al solicitado.',
        ]);

        MotivoDevolucion::create([
            'nombre' => 'No Satisfecho',
            'descripcion' => 'El producto no cumple con las expectativas del cliente.',
        ]);

        // ... puedes agregar más motivos de devolución

        // Luego, seeder para Devolucion (depende de MotivoDevolucion y Lote)

        //  Necesitas tener registros en la tabla 'lotes' antes de crear devoluciones.
        //  Aquí te dejo un ejemplo asumiendo que ya existen lotes con IDs 1, 2 y 3.
        //  Debes ajustar los IDs de lote a los que realmente existan en tu base de datos.

        $motivos = MotivoDevolucion::all(); // Obtener todos los motivos para asignarlos aleatoriamente.
        $lotes = Lote::all(); // Obtener todos los motivos para asignarlos aleatoriamente.

        Devolucion::create([
            'motivo_id' => $motivos->random()->id, // Asigna un motivo aleatorio
            'lote_id' => 1, // Reemplaza con un ID de lote válido
            'fecha' => '2024-07-26',
            'descripcion' => 'Devolución por producto defectuoso.',
            'estado' => 'A',
        ]);

        Devolucion::create([
            'motivo_id' => $motivos->random()->id, // Asigna un motivo aleatorio
            'lote_id' => 2, // Reemplaza con un ID de lote válido
            'fecha' => '2024-07-27',
            'descripcion' => 'Devolución por producto incorrecto.',
        ]);


        Devolucion::create([
            'motivo_id' => $motivos->random()->id, // Asigna un motivo aleatorio
            'lote_id' => 3, // Reemplaza con un ID de lote válido
            'fecha' => '2024-07-28',
            'descripcion' => 'Devolución por no satisfacción.',
        ]);

    }
}
