<?php

namespace App\DTOs;

use App\DTOs\LoteActivoDTO;
use Illuminate\Contracts\Pagination\Paginator;

class PaginatedLotesDTO
{
  public function __construct(
    public array $data,
    public int $current_page,
    public int $per_page,
    public bool $has_more,
    public int $count,
  ) {}

  public static function fromPaginator(
    Paginator $paginator,
    string $type
  ): self {
    $data = collect($paginator->items())
      ->map(fn($lote) => LoteActivoDTO::fromModel($lote, $type)->toArray())
      ->toArray();

    return new self(
      data: $data,
      current_page: $paginator->currentPage(),
      per_page: $paginator->perPage(),
      has_more: $paginator->hasMorePages(),
      count: count($data),
    );
  }

  public function toArray(): array
  {
    return [
      'data' => $this->data,
      'meta' => [
        'current_page' => $this->current_page,
        'per_page'     => $this->per_page,
        'has_more'     => $this->has_more,
        'count'        => $this->count,
      ],
    ];
  }
}
