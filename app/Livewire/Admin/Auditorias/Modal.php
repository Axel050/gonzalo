<?php

namespace App\Livewire\Admin\Auditorias;

use Livewire\Component;
use OwenIt\Auditing\Models\Audit;

class Modal extends Component
{

  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;

  public $auditoria;



  public function mount()
  {


    if ($this->method == "view") {
      $this->auditoria = Audit::find($this->id);

      $this->title = "Ver";
      $this->bg =  "background-color: rgb(22 163 74)";
    }

    if ($this->method == "delete") {
      $this->auditoria = Audit::find($this->id);
      $this->id = $this->auditoria->id;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
  }


  public function delete()
  {

    if (!$this->auditoria) {
      $this->dispatch('auditoriaNotExits');
    } else {
      $this->auditoria->delete();
      $this->dispatch('auditoriaDeleted');
    }
  }



  public function render()
  {
    return view('livewire.admin.auditorias.modal');
  }
}
