<?php

namespace App\Enums;

class MotivosCancelaciones
{
  public const ADQUIRENTE = 'adquirente';
  public const COMITENTE = 'comitente';
  public const ADMINISTRACION = 'administracion';
  public const OTRO = 'otro';


  /**
   * Devuelve todos los estados válidos.
   *
   * @return array
   */
  public static function all(): array
  {
    return [
      self::ADQUIRENTE,
      self::COMITENTE,
      self::ADMINISTRACION,
      self::OTRO,
    ];
  }

  /**
   * Devuelve un label legible para el estado.
   */
  public static function getLabel(string $estado): string
  {
    return match ($estado) {
      self::ADQUIRENTE => 'Adquirente',
      self::COMITENTE => 'Comitente',
      self::ADMINISTRACION => 'Administracion',
      self::OTRO => 'Otro',
      default => 'Desconocido',
    };
  }
}
