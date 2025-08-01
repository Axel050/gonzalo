<?php

namespace App\Enums;

class SubastaEstados
{
  public const ACTIVA = 'activa';
  public const INACTIVA = 'inactiva';
  public const ENPUJA = 'enpuja';
  public const FINALIZADA = 'finalizada';
  public const PAUSADA = 'pausada';

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
      self::FINALIZADA,
      self::PAUSADA,
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
      self::FINALIZADA => 'Finalizada',
      self::PAUSADA => 'Pausada',
      default => 'Desconocido',
    };
  }
}
