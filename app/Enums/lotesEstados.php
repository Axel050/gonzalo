<?php

namespace App\Enums;

class LotesEstados
{
  public const INCOMPLETO = 'incompleto';
  public const DISPONIBLE = 'disponible';
  public const ASIGNADO = 'asignado';
  public const EN_SUBASTA = 'en_subasta';
  public const VENDIDO = 'vendido';
  public const PAGADO = 'pagado';
  public const FACTURADO = 'facturado';
  public const DEVUELTO = 'devuelto';
  public const STANDBY = 'standby';
  public const LIQUIDADO = 'liquidado';

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
      self::ASIGNADO,
      self::EN_SUBASTA,
      self::VENDIDO,
      self::PAGADO,
      self::FACTURADO,
      self::DEVUELTO,
      self::STANDBY,
      self::LIQUIDADO,
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
      self::EN_SUBASTA => 'En Subasta',
      self::VENDIDO => 'Vendido',
      self::PAGADO => 'Pagado',
      self::FACTURADO => 'Facturado',
      self::DEVUELTO => 'Devuelto',
      self::STANDBY => 'Standby',
      self::LIQUIDADO => 'Liquidado',
      self::ASIGNADO => 'Asignado',
      default => 'Desconocido',
    };
  }
}
