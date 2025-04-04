<?php

namespace App\Livewire\Admin\Comitentes;

use App\Models\Autorizado;
use App\Models\Comitente;
use Livewire\Component;

class ModalAutorizados extends Component
{
      
    public $id;
              
    public $comitente;    
    public $nombre,$apellido,$telefono,$email,$dni;  
    public $autorizados=[];    
    public $tempAutorizados = [];    
    public $method;

    public function mount()
    {                                           
          $this->comitente = Comitente::find($this->id);
          $this->tempAutorizados = $this->comitente->autorizados->toArray();                                                          
    }


    protected function rules(){
       
       $rules = [   
          'nombre' => 'required',  
          'apellido' => 'required', 
          'telefono' => 'required',          
          'email' => 'required|email',
             "dni" => ['required','numeric',
              function ($attribute, $value, $fail) {
                    $exists = Autorizado::where('dni', $value)
                        ->where('comitente_id', '!=' ,"0")                        
                        ->where('comitente_id', '!=' ,$this->comitente->id)                        
                        ->exists();

                    if ($exists) {
                        $fail('DNI existente en otro comitente.');
                    }
                }
              ],
    ];

    return $rules;
        
     }


    protected function messages(){
       return [                      
            "nombre.required" => "Ingrese nombre.",                                    
            "apellido.required" => "Ingrese  apellido.",   
            "email.required" => "Ingrese  mail.",   
            "email.email" => "Mail invalido.",   
            "dni.required" => "Ingrese  dni.",   
            "dni.numeric" => "Ingrese  numero.",   
            "telefono.required" => "Ingrese  telefono.",                                        
          ];                 
      }
    
  
    

      

    public function add(){
      $this->validate(); 

      $dniExistsInTemp = array_search($this->dni, array_column($this->tempAutorizados, 'dni')) !== false;
        if ($dniExistsInTemp) {
            $this->addError('dni', 'El DNI ya está en la lista.');
            return;
        }

        $this->tempAutorizados[] = [
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'dni' => $this->dni,
            'telefono' => $this->telefono,
            'email' => $this->email,
        ];

        $this->reset(['nombre', 'apellido', 'dni', 'telefono', 'email']);
    }

     public function quitar($index)
    {
        if (isset($this->tempAutorizados[$index])) {
            unset($this->tempAutorizados[$index]);
            // Reindexar el array para evitar índices vacíos
            $this->tempAutorizados = array_values($this->tempAutorizados);
        }
    }

      public function editar($index)
    {
        if (isset($this->tempAutorizados[$index])) {            
            $this->nombre = $this->tempAutorizados[$index]['nombre'];
            $this->apellido = $this->tempAutorizados[$index]['apellido'];
            $this->dni = $this->tempAutorizados[$index]['dni'];
            $this->telefono = $this->tempAutorizados[$index]['telefono'];
            $this->email = $this->tempAutorizados[$index]['email'];

            // Eliminar el elemento de la lista temporal
            unset($this->tempAutorizados[$index]);
            $this->tempAutorizados = array_values($this->tempAutorizados);
        }
    }


public function save()
{
    
    // Obtener los DNI existentes en la base de datos para este comitente
    $existingDnis = $this->comitente->autorizados->pluck('dni')->toArray();
    $newDnis = array_column($this->tempAutorizados, 'dni');
    
    foreach ($existingDnis as $existingDni) {
        if (!in_array($existingDni, $newDnis)) {
            $this->comitente->autorizados()
                ->where('dni', $existingDni)
                ->delete();
        }
    }

    // Agregar o actualizar los autorizados de $tempAutorizados
    foreach ($this->tempAutorizados as $autorizado) {
        $this->comitente->autorizados()->updateOrCreate(
            ['dni' => $autorizado['dni']],
            $autorizado
        );
    }

      $this->dispatch('autorizadoCreated');   
    
}
    


    public function render()
    {
        return view('livewire.admin.comitentes.modal-autorizados');
    }
}
