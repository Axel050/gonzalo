<?php

namespace App\Enums;

class SubastaEstados
{
  public const ACTIVA = 'activa';
  public const INACTIVA = 'inactiva';
  public const ENPUJA = 'enpuja';

  /**
   * Obtener todos los estados como array.
   *
   * @return array
   */
  public static function all(): array
  {
    return [
      self::ACTIVA,
      self::INACTIVA,
      self::ENPUJA,
    ];
  }

  /**
   * Obtener el nombre legible de un estado.
   *
   * @param string $estado
   * @return string
   */
  public static function getLabel(string $estado): string
  {
    return match ($estado) {
      self::ACTIVA => 'Activa',
      self::INACTIVA => 'Inactiva',
      self::ENPUJA => 'En Puja',
      default => 'Desconocido',
    };
  }
}
