<?php

namespace Database\Seeders;

use App\Models\Personal;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PersonalSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $personals = [
      [
        'nombre' => 'Lucas',
        'apellido' => 'Fernández',
        'alias' => 'LFernandez',
        'role_id' => Role::inRandomOrder()->first()->id,
        'CUIT' => '20-54321678-5',
        'domicilio' => 'Las Heras 345, Mendoza',
        'telefono' => '3456789012',
        'user' => [
          'name' => 'Lucas FernándezP',
          'email' => 'lucas.fernandez@example.comP',
          'password' => bcrypt('12345678'),
        ]
      ],
      [
        'nombre' => 'Laura',
        'apellido' => 'García',
        'alias' => 'LGarcia',
        'role_id' => Role::inRandomOrder()->first()->id,
        'CUIT' => '27-34567890-3',
        'domicilio' => 'Mitre 789, Salta',
        'telefono' => '7890123456',
        'user' => [
          'name' => 'Laura GarcíaP',
          'email' => 'laura.garcia@example.comP',
          'password' => bcrypt('12345678'),
        ]
      ],
      [
        'nombre' => 'Martín',
        'apellido' => 'Pérez',
        'alias' => 'MPerez',
        'role_id' => Role::inRandomOrder()->first()->id,
        'CUIT' => '20-98765432-1',
        'domicilio' => 'Roca 123, Tucumán',
        'telefono' => '1239876543',
        'user' => [
          'name' => 'Martín PérezP',
          'email' => 'martin.perez@example.comP',
          'password' => bcrypt('12345678'),
        ]
      ],
      [
        'nombre' => 'Sofía',
        'apellido' => 'Ramírez',
        'alias' => 'SRamirez',
        'role_id' => Role::inRandomOrder()->first()->id,
        'CUIT' => '27-87654321-9',
        'domicilio' => 'Corrientes 456, Chaco',
        'telefono' => '4567891234',
        'user' => [
          'name' => 'Sofía RamírezP',
          'email' => 'sofia.ramirez@example.comP',
          'password' => bcrypt('12345678'),
        ]
      ],
      [
        'nombre' => 'Pablo',
        'apellido' => 'González',
        'alias' => 'PGonzalez',
        'role_id' => Role::inRandomOrder()->first()->id,
        'CUIT' => '20-45612378-5',
        'domicilio' => 'Belgrano 890, Formosa',
        'telefono' => '8901234567',
        'user' => [
          'name' => 'Pablo GonzálezP',
          'email' => 'pablo.gonzalez@example.comP',
          'password' => bcrypt('12345678'),
        ]
      ]
    ];

    foreach ($personals as $personal) {
      $user = User::create($personal['user']);
      unset($personal['user']);
      $personal['user_id'] = $user->id;
      $p = Personal::create($personal);
      $r = Role::find($p->role_id);
      $user->assignRole($r->name);
    }
  }
}
