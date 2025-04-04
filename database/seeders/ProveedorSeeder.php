<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $proveedores = [          
          [
            'nombre' => 'Proveedor A',
            'CUIT' => '20-12345678-9',
            'domicilio' => 'Calle Ficticia 123',
            'telefono' => '1234567890',
            'email' => 'contacto@proveedora.com',
            'servicio' => 'Consultoría',
            // 'monto' => 50000,
            // 'fecha' => '2025-02-01',
              ],
            [
            'nombre' => 'Proveedor B',
            'CUIT' => '20-98765432-1',
            'domicilio' => 'Avenida Ejemplo 456',
            'telefono' => '0987654321',
            'email' => 'contacto@proveedorb.com',
            'servicio' => 'Mantenimiento',
            // 'monto' => 30000,
            // 'fecha' => '2025-01-15',
            ],
           [
            'nombre' => 'Proveedor C',
            'CUIT' => '20-11223344-2',
            'domicilio' => 'Calle Ejemplo 789',
            'telefono' => '5678901234',
            'email' => 'contacto@proveedorc.com',
            'servicio' => 'Suministro de Materiales',
            // 'monto' => 15000,
            // 'fecha' => '2025-02-10',
          ],
          [
            'nombre' => 'Proveedor D',
            'CUIT' => '20-22334455-3',
            'domicilio' => 'Avenida Principal 101',
            'telefono' => '9876543210',
            'email' => 'contacto@proveedord.com',
            'servicio' => 'Logística',
            // 'monto' => 45000,
            // 'fecha' => '2025-02-03',
          ]
            ,
           [
            'nombre' => 'Proveedor E',
            'CUIT' => '20-33445566-4',
            'domicilio' => 'Calle Secundaria 202',
            'telefono' => '2345678901',
            'email' => 'contacto@proveedore.com',
            'servicio' => 'Diseño Gráfico',
            // 'monto' => 20000,
            // 'fecha' => '2025-01-25',
        ]

        ];


        foreach ($proveedores as $proveedor) {
            Proveedor::create($proveedor);
        }



    }
}
