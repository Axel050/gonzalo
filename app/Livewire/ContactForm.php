<?php

namespace App\Livewire;

use App\Mail\ContactFormEmail;
use App\Rules\RecaptchaRule;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class ContactForm extends Component
{

  public string $message = '';
  public string $name = '';
  public string $email = '';
  public $g_recaptcha_response;


  public function messages()
  {
    return [
      'name.required' => 'Por favor, decinos tu nombre.',
      'email.required' => 'El email es obligatorio para poder responderte.',
      'email.email' => 'El formato del email no es válido.',
      'message.min' => 'El mensaje debe tener al menos 10 caracteres.',
      'message.max' => 'El mensaje debe tener  menos de 200 caracteres.',
      'message.required' => 'Ingrese mensaje.',
      "g_recaptcha_response" => "Corfirme que no es un robot.",

    ];
  }

  public function rules()
  {
    $rules =   [
      'name' => 'required|min:2',
      'email' => 'required|email',
      'message' => 'required|min:10|max:200'
    ];

    if (!$this->g_recaptcha_response) {
      $rules['g_recaptcha_response'] = ['required', new RecaptchaRule()];
    }
    return $rules;
  }




  public function submit()
  {
    $this->validate();

    $data = [
      'name'    => $this->name,
      'email'   => $this->email,
      'message' => $this->message,
    ];




    Mail::to("axeldavidpaz@gmail.com")->send(new ContactFormEmail($data));



    $this->reset();

    session()->flash('success', 'Mensaje enviado correctamente.');
  }


  public function render()
  {
    return view('livewire.contact-form');
  }
}
