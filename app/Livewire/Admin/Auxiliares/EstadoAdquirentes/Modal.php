<?php

namespace App\Livewire\Admin\Auxiliares\EstadoAdquirentes;

use App\Models\CondicionIva;
use App\Models\EstadosAdquirente;
use Livewire\Component;

class Modal extends Component
{

    public $title;
    public $id;
    public $bg;    
    public $method;
    public $btnText;    
        
    public $estado;
    public $nombre;    
    public $descripcion;    

    protected function rules(){       
       $rules = [   
          'nombre' => 'required|unique:estados_adquirentes,nombre',                                
        ];

        if($this->method=="update"){
          $rules["nombre"]= 'required|unique:estados_adquirentes,nombre,'.$this->estado->id;
        }
        else {      
          $rules["nombre"]= 'required|unique:estados_adquirentes,nombre';
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
          $this->estado = EstadosAdquirente::find($this->id);
          $this->id = $this->estado->id ;
          $this->title= "Eliminar";
          $this->btnText= "Eliminar";
          $this->bg=	"background-color: rgb(239 68 68)"; 
        }
        if($this->method == "update" || $this->method == "view" ){
              $this->estado = EstadosAdquirente::find($this->id);
              $this->nombre =  $this->estado->nombre ;
              $this->descripcion =  $this->estado->descripcion ;

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
        
          EstadosAdquirente::create([
            "nombre"=>$this->nombre,            
            "descripcion"=>$this->descripcion,            
          ]);
          
          $this->dispatch('estadoCreated');   
    }


    public function update(){
                          
      if(!$this->estado){
        $this->dispatch('estadoNotExits');   
      }            
        else
        {
         $this->validate();
                          
        $this->estado->nombre= $this->nombre;                
        $this->estado->descripcion= $this->descripcion;                
       
        $this->estado->save();
        $this->dispatch('estadoUpdated');   
      }
      
    }

    public function delete(){                      
        if(!$this->estado){
              $this->dispatch('estadoNotExits');   
        }
        else{
          $this->estado->delete();
          $this->dispatch('estadoDeleted');   
        }
    }

    public function render()
    {
        return view('livewire.admin.auxiliares.estado-adquirentes.modal');
    }
}
