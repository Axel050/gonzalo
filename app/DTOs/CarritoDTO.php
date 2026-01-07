<?php

namespace App\DTOs;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class CarritoDTO implements Arrayable, JsonSerializable
{
  public function __construct(
    public array $ordenes,
    public array $lotes,
    public array $garantias,
    public float $totalLotes,
    public float $descuentoGarantias,
    public float $totalCarrito
  ) {}

  public function toArray(): array
  {
    return [
      'ordenes'             => $this->ordenes,
      'lotes'               => $this->lotes,
      'garantias'           => $this->garantias,
      'total_lotes'         => $this->totalLotes,
      'descuento_garantias' => $this->descuentoGarantias,
      'total_carrito'       => $this->totalCarrito,
    ];
  }

  public function jsonSerialize(): array
  {
    return $this->toArray();
  }
}
