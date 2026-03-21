<?php

namespace App\Enums;

class FacturaMedio
{
  public const ELECTRONICA = 'electronica';
  public const PAPEL = 'papel';

  public static function all(): array
  {
    return [self::ELECTRONICA, self::PAPEL];
  }

  public static function getLabel(string $medio): string
  {
    return match ($medio) {
      self::ELECTRONICA => 'Electrónica',
      self::PAPEL => 'Papel',
      default => 'Desconocido',
    };
  }
}
