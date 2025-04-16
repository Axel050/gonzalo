<?php

namespace App\Livewire\Admin\Auxiliares\CondicionIva;

use App\Models\CondicionIva;
use Livewire\Component;

class Modal extends Component
{

    public $title;
    public $id;
    public $bg;    
    public $method;
    public $btnText;    
        
    public $condicion;
    public $nombre;    

    protected function rules(){       
       $rules = [   
          'nombre' => 'required|unique:condicion_ivas,nombre',                                
        ];

        if($this->method=="update"){
          $rules["nombre"]= 'required|unique:condicion_ivas,nombre,'.$this->condicion->id;
        }
        else {      
          $rules["nombre"]= 'required|unique:condicion_ivas,nombre';
        }

        return $rules;        
     }

    protected function messages(){
       return [                      
            "nombre.required" => "Ingrese nombre.",
            "nombre.unique" => "Nombre existente.", 
          ];                 
      }
    
      
    public function mount()
    { 
                                    
      if($this->method == "save"){        
                
          $this->title= "Crear";
          $this->btnText= "Guardar";
          $this->bg=	"background-color: rgb(22 163 74)";                   
        }
        
        if($this->method == "delete"){
          $this->condicion = CondicionIva::find($this->id);
          $this->id = $this->condicion->id ;
          $this->title= "Eliminar";
          $this->btnText= "Eliminar";
          $this->bg=	"background-color: rgb(239 68 68)"; 
        }
        if($this->method == "update" || $this->method == "view" ){
              $this->condicion = CondicionIva::find($this->id);              
              $this->nombre =  $this->condicion->nombre ;                                          

              if($this->method == "update"){
                $this->title= "Editar";                    
                $this->bg="background-color: rgb(234 88 12)";
                $this->btnText= "Guardar";          
              }else {
                $this->title= "Ver";                    
                $this->bg=	"background-color: rgb(31, 83, 44)";                    
              } 

              
            }
                
    }
      

    public function save(){
                  
        $this->validate(  ); 
        
          CondicionIva::create([
            "nombre"=>$this->nombre,            
          ]);
          
          $this->dispatch('condicionCreated');   
    }


    public function update(){
                          
      if(!$this->condicion){
        $this->dispatch('condicionNotExits');   
      }            
        else
        {
         $this->validate();
                          
        $this->condicion->nombre= $this->nombre;                
       
        $this->condicion->save();
        $this->dispatch('condicionUpdated');   
      }
      
    }

    public function delete(){                      
        if(!$this->condicion){
              $this->dispatch('condicionNotExits');   
        }
        else{
          $this->condicion->delete();
          $this->dispatch('condicionDeleted');   
        }
    }

    public function render()
    {
        return view('livewire.admin.auxiliares.condicion-iva.modal');
    }
}
