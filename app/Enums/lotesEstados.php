<?php

namespace App\Enums;

class LotesEstados
{
  public const DISPONIBLE = 'disponible';
  public const ASIGNADO = 'asignado';
  public const EN_SUBASTA = 'en_subasta';
  public const VENDIDO = 'vendido';
  public const NO_VENDIDO = 'no_vendido';
  public const DEVUELTO = 'devuelto';

  /**
   * Obtener todos los estados como array.
   *
   * @return array
   */
  public static function all(): array
  {
    return [
      self::DISPONIBLE,
      self::ASIGNADO,
      self::EN_SUBASTA,
      self::VENDIDO,
      self::NO_VENDIDO,
      self::DEVUELTO,
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
      self::DISPONIBLE => 'disponible',
      self::ASIGNADO => 'Asignado',
      self::EN_SUBASTA => 'En Subasta',
      self::VENDIDO => 'Vendido',
      self::NO_VENDIDO => 'No Vendido',
      self::DEVUELTO => 'Devuelto',
      default => 'Desconocido',
    };
  }
}
