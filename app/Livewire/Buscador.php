<?php

namespace App\Livewire;

use App\Models\Subasta;
use Livewire\Attributes\On;
use Livewire\Component;



class Buscador extends Component
{
  public $subasta_id;
  public $search;
  public $route;
  public $todas;
  public $abiertas;
  public $view;
  public $from;

  protected $rules = [
    'search' => 'required|min:3'
  ];

  protected $messages = [
    'search.min' => 'La búsqueda debe tener más de 2 caracteres.',
    'search.required' => 'El campo de búsqueda no puede estar vacío.',
  ];




  #[On(['clearSearch'])]
  public function clearSearch()
  {
    $this->search = null;
  }


  public function buscarLotes()
  {

    $this->validate();
    // Viene de Detalle Lote
    if ($this->route) {
      return redirect()->route($this->route,  [
        'subasta' => $this->subasta_id, // este es el parámetro {subasta} de la ruta
        'searchParam' => $this->search       // este irá como query string: ?search=valor
      ]);
    }

    // De subastas
    if ($this->todas) {
      return redirect()->route("subasta-buscador.lotes",  [
        'searchParam' => $this->search,      // este irá como query string: ?search=valor        
        'from' => $this->from,      // este irá como query string: ?search=valor        
      ]);
    }
    // @livewire('buscador', ['todas' => true, 'from' => 'home'])

    $this->dispatch('buscarLotes', $this->search);
  }





  public function render()
  {
    $subasta_bus = Subasta::find($this->subasta_id);

    return view('livewire.buscador', compact("subasta_bus"));
  }
}
