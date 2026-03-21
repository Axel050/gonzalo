<?php

namespace App\Enums;

/**
 * Tipos de factura según destinatario y concepto.
 * Adquirentes: comision, garantia, envio, nota_credito, papel_lotes
 * Comitentes: comision, retiro
 */
class FacturaTipo
{
  public const COMISION = 'comision';
  public const GARANTIA = 'garantia';
  public const ENVIO = 'envio';
  public const RETIRO = 'retiro'; // solo comitentes
  public const NOTA_CREDITO = 'nota_credito';
  /** Factura papel con lotes y martillo (solo adquirentes) */
  public const PAPEL_LOTES = 'papel_lotes';

  public static function all(): array
  {
    return [
      self::COMISION,
      self::GARANTIA,
      self::ENVIO,
      self::RETIRO,
      self::NOTA_CREDITO,
      self::PAPEL_LOTES,
    ];
  }

  public static function getLabel(string $tipo): string
  {
    return match ($tipo) {
      self::COMISION => 'Comisión',
      self::GARANTIA => 'Garantía',
      self::ENVIO => 'Envío',
      self::RETIRO => 'Retiro',
      self::NOTA_CREDITO => 'Nota de crédito',
      self::PAPEL_LOTES => 'Venta (lotes y martillo)',
      default => 'Desconocido',
    };
  }

  /** Tipos válidos para adquirentes */
  public static function paraAdquirente(): array
  {
    return [
      self::COMISION,
      self::GARANTIA,
      self::ENVIO,
      self::NOTA_CREDITO,
      self::PAPEL_LOTES,
    ];
  }

  /** Tipos válidos para comitentes */
  public static function paraComitente(): array
  {
    return [self::COMISION, self::RETIRO];
  }
}
