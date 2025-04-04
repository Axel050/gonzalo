<?php

namespace App\Livewire\Admin\Subastas;


use App\Models\Subasta;
use Carbon\Carbon;
use Livewire\Component;

class Modal extends Component
{

    public $title;
    public $id;
    public $bg;    
    public $method;
    public $btnText;    
        
    public $subasta;
    
    public $estado=1;
  
    public $tiempoPos="2";

    public $tiempoIni="00:00";
    public $tiempoFin="00:00";

    public $iniD;
    public $iniH="00:00";

    public $finD;
    public $finH="23:59";

    public $comision=20;

    public $titulo;
    public $descripcion;
    public $num;




    protected function rules(){
       
       $rules = [   
          'titulo' => 'required|unique:subastas,titulo',                      
          'iniD' => 'required',                      
          'iniH' => 'required',                      
          'finD' => 'required',                      
          'finH' => 'required',                      
          'comision' => 'required|numeric|min:0',       
          'tiempoPos' => 'required',                      
    ];
    if($this->method=="update"){
      $rules["titulo"]= 'required|unique:subastas,titulo,'.$this->subasta->id;
    }
    else {      
      $rules["titulo"]= 'required|unique:subastas,titulo';
    }

    return $rules;
        
     }

    protected function messages(){
       return [                      
            "titulo.required" => "Ingrese titulo.",                        
            "titulo.unique" => "Titulo existente.",                        
            "iniD.required" => "Ingrese  fecha inicio.",                        
            "iniH.required" => "Ingrese  hora inicio.",                        
            "finD.required" => "Ingrese  fecha fin.",                        
            "finH.required" => "Ingrese  hora fin.",                        
            "comision.required" => "Ingrese  comision.",                        
            "comision.numeric" => "Comision invalida." ,
            "comision.min" => "Comision invalida." ,            
            "tiempoPos.required" => "Ingrese  tiempo post subasta.",                        
          ];                 
      }
    
  
    public function ti(){
        dd([
          "inicFec" => $this->iniD,
          "inicHo" => $this->iniH
        ]);
    }

    public function mount()
    { 
                                    
      if($this->method == "save"){        
          $this->num = Subasta::max('id') + 1;
          
          $this->title= "Crear";
          $this->btnText= "Guardar";
          $this->bg=	"background-color: rgb(22 163 74)";                   
        }
        
        if($this->method == "delete"){
          $this->subasta = Subasta::find($this->id);
          $this->id = $this->subasta->id ;
          $this->title= "Eliminar";
          $this->btnText= "Eliminar";
          $this->bg=	"background-color: rgb(239 68 68)"; 
        }
        if($this->method == "update" || $this->method == "view" ){
              $this->subasta = Subasta::find($this->id);
              
              $this->num =  $this->subasta->id ;                            
              $this->titulo =  $this->subasta->titulo ;                            
              $this->descripcion =  $this->subasta->descripcion ;                            

              if ($this->subasta->comision !== null) {                  
                  $comision = floatval($this->subasta->comision);
                  $comision = ($comision == floor($comision)) ? (int)$comision : $comision;
                  $this->comision =  $comision;                   
                }

              $this->estado =  $this->subasta->estado ;
              $this->tiempoPos =  $this->subasta->tiempo_post_subasta ;
              
              $carbonIni = Carbon::parse($this->subasta->fecha_inicio);
              $this->iniD = $carbonIni->toDateString(); 
              $this->iniH = $carbonIni->format('H:i'); 

              $carbonFin = Carbon::parse($this->subasta->fecha_fin);
              $this->finD = $carbonFin->toDateString(); 
              $this->finH = $carbonFin->format('H:i'); 

                  if($this->method == "update"){
                    $this->title= "Editar";                    
                    $this->bg="background-color: rgb(234 88 12)";
                    $this->btnText= "Guardar";          
                  }else {
                    $this->title= "Ver";                    
                    $this->bg=	"background-color: rgb(31, 83, 44)";                    
                  }                  
              // $this->bg="background-color: rgb(234 88 12)";
            }
                
    }
      

    public function save(){
                  
        $this->validate(  $this->rules(), $this->messages()); 
        
          Subasta::create([
            "titulo"=>$this->titulo,
            "comision"=>$this->comision,
            "tiempo_post_subasta"=>$this->tiempoPos,            
            "descripcion"=>$this->descripcion,
            "estado"=>$this->estado,
            "fecha_inicio" => $this->iniD ." ".$this->iniH,
            "fecha_fin" => $this->finD ." ".$this->finH,
          ]);
          
          $this->dispatch('subastaCreated');   
    }


    public function update(){
                          
      if(!$this->subasta){
        $this->dispatch('subastaNotExits');   
      }            
        else
        {
          $this->validate(  $this->rules(), $this->messages());              
                  
        
        $this->subasta->titulo= $this->titulo;
        $this->subasta->descripcion= $this->descripcion;
        $this->subasta->comision= $this->comision;
        $this->subasta->tiempo_post_subasta= $this->tiempoPos;
        $this->subasta->estado= $this->estado;
        $this->subasta->fecha_inicio= $this->iniD ." ".$this->iniH;
        $this->subasta->fecha_fin= $this->finD ." ".$this->finH;
        
       
        $this->subasta->save();
        $this->dispatch('subastaUpdated');   
      }
      
    }

    public function delete(){                      

        if(!$this->subasta){
              $this->dispatch('subastaNotExits');   
        }
        else{
          $this->subasta->delete();
          $this->dispatch('subastaDeleted');   
        }
    }




    public function render()
    {
        return view('livewire.admin.subastas.modal');
    }
}
