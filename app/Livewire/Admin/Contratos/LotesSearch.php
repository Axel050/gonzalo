<?php

namespace App\Livewire\Admin\Contratos;

use App\Enums\LotesEstados;
use App\Models\Lote;
use Livewire\Component;

use function PHPUnit\Framework\isEmpty;

class LotesSearch extends Component
{

  public string $tes = '';
  public string $si;

  public string $search = '';
  public int $comitenteId;

  public $lotes = [];
  public $noLotes;

  public function loteSelected($loteId)
  {

    $this->search = "";
    $lote = Lote::find($loteId);
    if ($lote) {
      // $this->dispatch('loteSel', loteId: $loteId, nombre: $lote->titulo);
      $this->dispatch('loteSel', id: $loteId, titulo: $lote->titulo);
    }
  }

  public function zo()
  {

    $this->lotes = Lote::where('comitente_id', $this->comitenteId)
      ->where('estado', LotesEstados::DISPONIBLE)
      ->where('titulo', 'like', '%' . 'de' . '%')
      ->take(10)
      ->get();
  }


  public function updatedSearch($value)
  {
    if (strlen($value) > 1) {
      $this->lotes = Lote::where('comitente_id', 1)
        ->where('estado', LotesEstados::DISPONIBLE)
        ->where('titulo', 'like', '%' . $value . '%')
        ->take(10)
        ->get();

      if (count($this->lotes) > 0) {
        $this->si = true;
      }
    } else {
      $this->si = false;
      $this->lotes = [];
    }
    //   if (count($this->lotes) ==  0) {
    //     $this->noLotes = false;
    //     info("nooooooooooooooooo");
    //   } elseif (count($this->lotes) > 0) {
    //     info("siiiiiiiiiiiiii");
    //     $this->noLotes = true;
    // }

    // $this->noLotes = true;
    // info($this->noLotes);
  }


  public function render()
  {
    info("render lote search ");
    return view('livewire.admin.contratos.lotes-search');
  }
}
