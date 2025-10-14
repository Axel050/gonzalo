<?php

namespace App\Enums;

class CarritoLoteEstados
{
  public const ACTIVO = 'activo';              // En el carrito, sin adjudicar aún
  public const ADJUDICADO = 'adjudicado';      // Ganó la subasta
  public const EN_ORDEN = 'en_orden';          // Pasó a formar parte de una orden
  public const PAGADO = 'pagado';              // Pagado junto con la orden
  public const ELIMINADO = 'eliminado';        // Quitado manualmente del carrito
  public const CANCELADO = 'cancelado';        // Cancelado por la casa (ej. lote dañado)
  public const STANDBY = 'standby';            // Esperando resolución
  public const CERRADO = 'cerrado';            // Fin subasta , no ganado , < 24hs del cieere
  public const PERDIDO = 'perdido';            // Fin subasta , no ganado ,>  24hs del cierre


  /**
   * Obtener todos los estados como array.
   *
   * @return array
   */
  public static function all(): array
  {
    return [
      self::ACTIVO,
      self::ADJUDICADO,
      self::EN_ORDEN,
      self::PAGADO,
      self::ELIMINADO,
      self::CANCELADO,
      self::STANDBY,
      self::CERRADO,
      self::PERDIDO,
    ];
  }

  /**
   * Obtener una etiqueta legible.
   */
  public static function getLabel(string $estado): string
  {
    return match ($estado) {
      self::ACTIVO => 'Activo',
      self::ADJUDICADO => 'Adjudicado',
      self::EN_ORDEN => 'En orden',
      self::PAGADO => 'Pagado',
      self::ELIMINADO => 'Eliminado',
      self::CANCELADO => 'Cancelado',
      self::STANDBY => 'En espera',
      self::CERRADO => 'cerrado',
      self::PERDIDO => 'perdido',
      default => 'Desconocido',
    };
  }
}
