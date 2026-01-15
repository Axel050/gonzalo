<?php

namespace App\Livewire\Register;


use Livewire\Component;

class ModalSuccessComitente extends Component
{


  public function home()
  {
    return $this->redirect('/', navigate: true);
  }

  public function render()
  {
    return view('livewire.register.modal-success-comitente');
  }
}
