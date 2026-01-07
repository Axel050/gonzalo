<?php

namespace App\DTOs;

use App\Models\Subasta;
use Illuminate\Support\Collection;

class SubastasDTO
{
  public function __construct(
    public Subasta $subasta,
    public Collection $lotes
  ) {}
}
