<?php

namespace App\Livewire\Register;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ModalSuccess extends Component
{
  public $pas, $mail, $from;

  public function mount()
  {


    // public function close()
    // {

    // if ($this->mail && $this->pas) {
    //   Session::flash('prefill', [
    //     'mail' => $this->mail,
    //     'pas'  => $this->pas,
    //   ]);
    // }

    if ($this->from == "adquirentes") {
      # code...

      if (Auth::check()) {

        Auth::logout();
        session()->regenerateToken();
      }


      // Auth::login(["user"=>"test@example.com","password"=>12345678]):
      Auth::attempt(['email' => $this->mail, 'password' => $this->pas], true);
      // Auth::attempt(['email' => "test@example.com", 'password' => "12345678"], true);
    }

    // return $this->redirect('/login', navigate: true);
    // return $this->redirect('/login', navigate: true);
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
