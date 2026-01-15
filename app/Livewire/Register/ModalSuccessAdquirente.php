<?php

namespace App\Livewire\Register;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalSuccessAdquirente extends Component
{
  public $pas, $mail;

  public function mount()
  {

    if (Auth::check()) {
      Auth::logout();
      session()->regenerateToken();
    }

    Auth::attempt(['email' => $this->mail, 'password' => $this->pas], true);
  }

  public function home()
  {
    return $this->redirect('/', navigate: true);
  }

  public function render()
  {
    return view('livewire.register.modal-success-adquirente');
  }
}
