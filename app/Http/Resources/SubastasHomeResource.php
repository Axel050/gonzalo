<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubastasHomeResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'subasta' => [
        'id'          => $this->subasta->id,
        'titulo'      => $this->subasta->titulo,
        'descripcion' => $this->subasta->descripcion,
        'fecha_inicio' => $this->subasta->fecha_inicio_humana,
        'fecha_fin'   => $this->subasta->fecha_fin_humana,
        'estado'      => $this->subasta->estado,
        'desc_extra'      => $this->subasta->desc_extra,
        'envio'      => $this->subasta->envio,
      ],

      'lotes' => $this->lotes->map(fn($lote) => [
        'id'     => $lote->id,
        'titulo' => $lote->titulo,
        'foto'   => $lote->foto1,
      ])->values(),
    ];
  }
}
