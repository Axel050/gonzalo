<?php

namespace App\Livewire\Admin\Personal\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Permisos extends Component
{

  public $id;
  public $rol;

  public $modules = [
    [
      'name' => 'Dashboard',
      'ver' => false,
      'crear' => false,
      'actualizar' => false,
      'eliminar' => false,
    ],
    [
      'name' => 'Personal',
      'ver' => false,
      'crear' => false,
      'actualizar' => false,
      'eliminar' => false,
    ],
    // [
    //   'name' => 'Usuarios',
    //   'ver' => false,
    //   'crear' => false,
    //   'actualizar' => false,
    //   'eliminar' => false,
    // ],
    // [
    //   'name' => 'Roles',
    //   'ver' => false,
    //   'crear' => false,
    //   'actualizar' => false,
    //   'eliminar' => false,
    // ],
    [
      'name' => 'Subastas',
      'ver' => false,
      'crear' => false,
      'actualizar' => false,
      'eliminar' => false,
    ],
    [
      'name' => 'Comitentes',
      'ver' => false,
      'crear' => false,
      'actualizar' => false,
      'eliminar' => false,
    ],
    [
      'name' => 'Adquirentes',
      'ver' => false,
      'crear' => false,
      'actualizar' => false,
      'eliminar' => false,
    ],
    [
      'name' => 'Contratos',
      'ver' => false,
      'crear' => false,
      'actualizar' => false,
      'eliminar' => false,
    ],
    [
      'name' => 'Lotes',
      'ver' => false,
      'crear' => false,
      'actualizar' => false,
      'eliminar' => false,
    ],
    [
      'name' => 'Auxiliares',
      'ver' => false,
      'crear' => false,
      'actualizar' => false,
      'eliminar' => false,
    ],
    [
      'name' => 'Auditoria',
      'ver' => false,
      'crear' => false,
      'actualizar' => false,
      'eliminar' => false,
    ],
    [
      'name' => 'Ordenes',
      'ver' => false,
      'crear' => false,
      'actualizar' => false,
      'eliminar' => false,
    ]

  ];

  public function mount()
  {
    $this->rol = Role::find($this->id);
    $this->initializePermissions();
  }

  public function initializePermissions()
  {
    $permissions = $this->rol->permissions->pluck('name')->toArray();

    foreach ($this->modules as $index => $module) {
      foreach ($module as $action => $enabled) {
        if ($action !== 'name') {
          $permissionName = strtolower($module['name']) . '-' . $action;
          $this->modules[$index][$action] = in_array($permissionName, $permissions);
        }
      }
    }
  }


  public function save()
  {
    $permissions = [];

    foreach ($this->modules as $module) {
      foreach ($module as $action => $enabled) {
        if ($action !== 'name' && $enabled) {
          $permissions[] = strtolower($module['name']) . '-' . $action;
        }
      }
    }

    $this->rol->syncPermissions($permissions);
    $this->dispatch("permisosAdded");
  }

  public function render()
  {
    return view('livewire.admin.personal.roles.permisos');
  }
}
