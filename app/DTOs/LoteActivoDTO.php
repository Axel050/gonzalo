<?php

namespace App\DTOs;

use App\Models\Lote;

class LoteActivoDTO
{
  public function __construct(
    public int $id,
    public string $titulo,
    public ?string $foto,
    public ?string $descripcion,
    public float $precio_base,
    public int $moneda_id,
    public ?float $puja_actual = null,
    public bool $tienePujas = false,
    public ?string $estado = null,
  ) {}

  public static function fromModel(Lote $lote, string $type): self
  {
    return new self(
      id: $lote->id,
      titulo: $lote->titulo,
      foto: $lote->foto1 ??  false,
      descripcion: $lote->descripcion,
      precio_base: (float) $lote->precio_base,
      moneda_id: $lote->moneda_id,
      puja_actual: in_array($type, ['pujas', 'completo'])
        ? $lote->pujas->first()?->monto
        : null,
      tienePujas: in_array($type, ['pujas', 'completo'])
        ? (bool) $lote->pujas_exists
        : false,
      estado: in_array($type, ['estado', 'completo'])
        ? $lote->estado
        : null
    );
  }

  public function toArray(): array
  {
    return array_filter([
      'id'          => $this->id,
      'titulo'      => $this->titulo,
      'foto'        => $this->foto,
      'descripcion' => $this->descripcion,
      'precio_base' => $this->precio_base,
      'moneda_id'   => $this->moneda_id,
      'puja_actual' => $this->puja_actual,
      'tienePujas'  => $this->tienePujas,
      'estado'      => $this->estado,
    ], fn($v) => ! is_null($v));
  }
}
