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
        Permission::create(['name' => 'edit lotes']);
        Permission::create(['name' => 'delete lotes']);
        Permission::create(['name' => 'publish lotes']);
        Permission::create(['name' => 'unpublish lotes']);

        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role1 = Role::create(['name' => 'super-admin']);
        $role1->givePermissionTo(Permission::all());

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('edit lotes');

        // or may be done by chaining
        $role3 = Role::create(['name' => 'adq guest'])
            ->givePermissionTo(['publish lotes', 'unpublish lotes']);

        $role4 = Role::create(['name' => 'adquirente'])
            ->givePermissionTo(['publish lotes', 'unpublish lotes']);


        // create roles and assign created permissions

        // this can be done as separate statements



        


        
    }
}
