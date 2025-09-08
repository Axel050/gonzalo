<?php

namespace App\Livewire;

use App\Models\Subasta;
use Livewire\Component;
use Carbon\Carbon;

class CounterHeader extends Component
{
  public $fechaFin;
  public $last;

  public function mount()
  {
    $this->loadSubasta();
  }

  public function loadSubasta()
  {
    // Carbon::setLocale('es');
    // setlocale(LC_TIME, 'es_ES.UTF-8');

    $this->last = Subasta::whereIn('estado', ['activa', 'en_puja'])
      ->where('fecha_fin', '>', Carbon::now())
      ->orderBy('fecha_fin', 'asc')
      ->first();

    if ($this->last) {
      $this->fechaFin = Carbon::parse($this->last->fecha_fin);
    }
  }

  public function render()
  {
    if (! $this->last) {
      return "<div style='display:none'></div>";
    }

    return view('livewire.counter-header');
  }
}
