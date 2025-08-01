<?php

namespace Database\Seeders;

use App\Models\Adquirente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // create permissions    

    Permission::create(['name' => 'dashboard-ver']);
    Permission::create(['name' => 'usuarios-ver']);
    Permission::create(['name' => 'personal-ver']);
    Permission::create(['name' => 'roles-ver']);
    Permission::create(['name' => 'subastas-ver']);
    Permission::create(['name' => 'comitentes-ver']);
    Permission::create(['name' => 'adquirentes-ver']);
    Permission::create(['name' => 'auxiliares-ver']);
    Permission::create(['name' => 'adquirente-logged']);
    Permission::create(['name' => 'auditoria-ver']);

    // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    $role1 = Role::create(['name' => 'super-admin', "description" => "descripcion test"]);
    $role1->givePermissionTo(Permission::all());

    $role2 = Role::create(['name' => 'admin', "description" => "descripcion test"]);
    $role2->givePermissionTo('dashboard-ver');

    // or may be done by chaining
    // $role3 = Role::create(['name' => 'adq guest', "description" => "descripcion test gue"])
    //   ->givePermissionTo(['dashboard-ver', 'personal-ver']);

    $role4 = Role::create(['name' => 'adquirente', "description" => "descripcion test adq"])->givePermissionTo(['adquirente-logged']);;


    // create roles and assign created permissions

    // this can be done as separate statements







  }
}
