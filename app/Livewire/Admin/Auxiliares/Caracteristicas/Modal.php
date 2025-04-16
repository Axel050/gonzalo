<?php

namespace App\Livewire\Admin\Auxiliares\Caracteristicas;

use App\Models\Caracteristica;
use Livewire\Component;

class Modal extends Component
{

    public $title;
    public $id;
    public $bg;    
    public $method;
    public $btnText;    
        
    public $caracteristica;
    public $nombre;    
    public $tipo="text";    

    protected function rules(){       
       $rules = [   
          'nombre' => 'required|unique:caracteristicas,nombre',                                
        ];

        if($this->method=="update"){
          $rules["nombre"]= 'required|unique:caracteristicas,nombre,'.$this->caracteristica->id;
        }
        else {      
          $rules["nombre"]= 'required|unique:caracteristicas,nombre';
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
          $this->caracteristica = Caracteristica::find($this->id);
          $this->id = $this->caracteristica->id ;
          $this->title= "Eliminar";
          $this->btnText= "Eliminar";
          $this->bg=	"background-color: rgb(239 68 68)"; 
        }
        if($this->method == "update" || $this->method == "view" ){
              $this->caracteristica = Caracteristica::find($this->id);              
              $this->nombre =  $this->caracteristica->nombre ;                                          

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
                        
        $this->validate( ); 
        
          Caracteristica::create([
            "nombre"=>$this->nombre,            
            "tipo"=>$this->tipo,            
          ]);
          
          $this->dispatch('caracteristicaCreated');   
    }


    public function update(){
                          
      if(!$this->caracteristica){
        $this->dispatch('caracteristicaNotExits');   
      }            
        else
        {
         $this->validate();
                          
        $this->caracteristica->nombre= $this->nombre;                
        $this->caracteristica->tipo= $this->tipo;                
       
        $this->caracteristica->save();
        $this->dispatch('caracteristicaUpdated');   
      }
      
    }

    public function delete(){                      
        if(!$this->caracteristica){
              $this->dispatch('caracteristicaNotExits');   
        }
        else{
          $this->caracteristica->delete();
          $this->dispatch('caracteristicaDeleted');   
        }
    }

    public function render()
    {
        return view('livewire.admin.auxiliares.caracteristicas.modal');
    }
}
