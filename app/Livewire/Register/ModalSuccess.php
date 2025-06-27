<?php

namespace App\Livewire\Register;

use Livewire\Component;

class ModalSuccess extends Component
{

  public function close()
  {
    return $this->redirect('/', navigate: true);   // Livewire 3
  }

  public function render()
  {
    return view('livewire.register.modal-success');
  }
}
