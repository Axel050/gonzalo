<?php

namespace App\Enums;

class LotesEstados
{
  public const INCOMPLETO = 'incompleto';
  public const DISPONIBLE = 'disponible';
  // public const ASIGNADO = 'asignado';
  public const EN_SUBASTA = 'en_subasta';
  public const VENDIDO = 'vendido';
  public const DEVUELTO = 'devuelto';
  public const STANDBY = 'standby';

  /**
   * Obtener todos los estados como array.
   *
   * @return array
   */
  public static function all(): array
  {
    return [
      self::INCOMPLETO,
      self::DISPONIBLE,
      // self::ASIGNADO,
      self::EN_SUBASTA,
      self::VENDIDO,
      self::DEVUELTO,
      self::STANDBY,
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
      self::INCOMPLETO => 'Incompleto',
      self::DISPONIBLE => 'Disponible',
      // self::ASIGNADO => 'Asignado',
      self::EN_SUBASTA => 'En Subasta',
      self::VENDIDO => 'Vendido',
      self::DEVUELTO => 'Devuelto',
      self::STANDBY => 'Standby',
      default => 'Desconocido',
    };
  }
}
