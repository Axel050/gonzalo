<?php

namespace Database\Seeders;

use App\Models\Adquirente;
use App\Models\AdquirentesAlias;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdquirentesSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $adquirentes = [
      [
        'nombre' => 'Lucas',
        'apellido' => 'Fernández',
        'estado_id' => 1,
        'CUIT' => '20-54321678-5',
        'condicion_iva_id' => 1,
        'domicilio' => 'Las Heras 345, Mendoza',
        'telefono' => '3456789012',
        'comision' => 20.00,
        'user' => [
          'name' => 'Lucas Fernández',
          'email' => 'lucas.fernandez@example.com',
          'password' => bcrypt('password123'),
        ]
      ],
      [
        'nombre' => 'Laura',
        'apellido' => 'García',
        'estado_id' => 2,
        'CUIT' => '27-34567890-3',
        'condicion_iva_id' => 2,
        'domicilio' => 'Mitre 789, Salta',
        'telefono' => '7890123456',
        'comision' => 22.00,
        'user' => [
          'name' => 'Laura García',
          'email' => 'laura.garcia@example.com',
          'password' => bcrypt('password456'),
        ]
      ],
      [
        'nombre' => 'Martín',
        'apellido' => 'Pérez',
        'estado_id' => 1,
        'CUIT' => '20-98765432-1',
        'condicion_iva_id' => 3,
        'domicilio' => 'Roca 123, Tucumán',
        'telefono' => '1239876543',
        'comision' => 20.00,
        'user' => [
          'name' => 'Martín Pérez',
          'email' => 'martin.perez@example.com',
          'password' => bcrypt('password789'),
        ]
      ],
      [
        'nombre' => 'Sofía',
        'apellido' => 'Ramírez',
        'estado_id' => 2,
        'CUIT' => '27-87654321-9',
        'condicion_iva_id' => 4,
        'domicilio' => 'Corrientes 456, Chaco',
        'telefono' => '4567891234',
        'comision' => 18.75,
        'user' => [
          'name' => 'Sofía Ramírez',
          'email' => 'sofia.ramirez@example.com',
          'password' => bcrypt('password101'),
        ]
      ],
      [
        'nombre' => 'Pablo',
        'apellido' => 'González',
        'estado_id' => 1,
        'CUIT' => '20-45612378-5',
        'condicion_iva_id' => 3,
        'domicilio' => 'Belgrano 890, Formosa',
        'telefono' => '8901234567',
        'comision' => 20.00,
        'user' => [
          'name' => 'Pablo González',
          'email' => 'pablo.gonzalez@example.com',
          'password' => bcrypt('12345678'),
        ]
      ]
    ];

    foreach ($adquirentes as $data) {
      $user = User::create($data['user']);
      unset($data['user']);

      // 2. Crear adquirente SIN alias_id
      $adquirente = Adquirente::create(array_merge($data, ['user_id' => $user->id]));

      // 3. Generar alias automático (ej: "LFernandez")
      // $alias = strtoupper(substr($data['nombre'], 0, 1) . $data['apellido']);
      $alias = substr(
        strtoupper($data['nombre']),
        0,
        1
      ) . $data['apellido'];

      // 4. Crear registro en adquirente_aliases
      $aliasModel = AdquirentesAlias::create([
        'nombre' => $alias,
        'adquirente_id' => $adquirente->id,
      ]);

      // 5. Actualizar adquirente con el alias_id
      $adquirente->update(['alias_id' => $aliasModel->id]);

      $roles = ['adq guest', 'adquirente'];
      $randomRole = $roles[array_rand($roles)];

      $user->assignRole($randomRole);
    }
  }
}
