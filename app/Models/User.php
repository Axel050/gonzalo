<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;
  use HasRoles;
  // use HasPermissions;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  /**
   * Get the user's initials
   */
  public function initials(): string
  {
    return Str::of($this->name)
      ->explode(' ')
      ->map(fn(string $name) => Str::of($name)->substr(0, 1))
      ->implode('');
  }




  public function hasActiveRole2($roleName)
  {
    return $this->roles()
      ->where('name', $roleName)
      ->where('is_active', true) // Asume que tienes un campo 'is_active'
      ->exists();
  }

  public function hasActiveRole($roleName = null)
  {
    $query = $this->roles()->where('is_active', true);

    if ($roleName) {
      $query->where('name', $roleName);
    }

    return $query->exists();
  }

  // User.php
  public function can($ability, $arguments = [])
  {
    // Excepciones para permisos que no requieran rol activo
    if (in_array($ability, ['permiso-sin-rol', 'otro-permiso'])) {
      return parent::can($ability, $arguments);
    }

    return parent::can($ability, $arguments) && $this->hasActiveRole();
  }


  public function adquirente()
  {
    return $this->hasOne(Adquirente::class, 'user_id');
  }
}
