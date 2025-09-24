<?php

namespace App\Livewire\Register;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ModalSuccess extends Component
{
  public $pas, $mail, $from;


  public function close()
  {

    if ($this->mail && $this->pas) {
      Session::flash('prefill', [
        'mail' => $this->mail,
        'pas'  => $this->pas,
      ]);
    }

    if (Auth::check()) {

      Auth::logout();
      session()->regenerateToken();
    }

    return $this->redirect('/login', navigate: true);
  }

  public function home()
  {
    return $this->redirect('/', navigate: true);
  }

  public function render()
  {
    return view('livewire.register.modal-success');
  }
}
