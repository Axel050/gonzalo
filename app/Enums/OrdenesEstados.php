<?php

namespace App\Enums;

class OrdenesEstados
{
  public const PENDIENTE = 'pendiente';
  public const PAGADA = 'pagada';
  public const RECHAZADA = 'rechazada';
  public const CANCELADA = 'cancelada';
  // public const PARCIAL = 'parcial'; // opcional, si vas a manejar pagos parciales

  /**
   * Devuelve todos los estados válidos.
   *
   * @return array
   */
  public static function all(): array
  {
    return [
      self::PENDIENTE,
      self::PAGADA,
      self::RECHAZADA,
      self::CANCELADA,
      // self::PARCIAL,
    ];
  }

  /**
   * Devuelve un label legible para el estado.
   */
  public static function getLabel(string $estado): string
  {
    return match ($estado) {
      self::PENDIENTE => 'Pendiente',
      self::PAGADA => 'Pagada',
      self::RECHAZADA => 'Rechazada',
      self::CANCELADA => 'Cancelada',
      // self::PARCIAL => 'Pago parcial',
      default => 'Desconocido',
    };
  }
}
