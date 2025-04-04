<?php

namespace App\Livewire\Admin\Comitentes;

use App\Models\Comitente;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Intervention\Image\ImageManager;

class Modal extends Component
{

    use WithFileUploads;

    public $title;
    public $id;
    public $bg;    
    public $method;
    public $btnText;    
          
    public $comitente;    
    public $nombre,$apellido,$alias,$CUIT,$domicilio,$telefono,$mail,$banco,$numero_cuenta,$CBU,$alias_bancario,$foto;    
    public $comision=20.0;
    public $observaciones;
    public $autorizados;






    protected function rules(){
       
       $rules = [   
          'nombre' => 'required',  
          'apellido' => 'required', 
          'telefono' => 'required',          
          'mail' => 'required|email',          
          // 'domicilio' => 'required',        
           'comision' => 'required|numeric|min:0',          
          // 'banco' => 'required',
          'numero_cuenta' => 'required',
          'CBU' => 'required',
          // 'alias_bancario' => 'required',
          // 'foto' => 'required',                              
    ];
    if($this->method=="update"){
      $rules["alias"]= 'required|unique:comitentes,alias,'.$this->comitente->id;
      $rules["CUIT"]= 'required|unique:comitentes,CUIT,'.$this->comitente->id;              
    }
    else {      
      $rules["CUIT"]= 'required|unique:comitentes,CUIT' ;
      $rules["alias"]= 'required|unique:comitentes,alias' ;
    }

    return $rules;
        
     }

    protected function messages(){
       return [                      
            "nombre.required" => "Ingrese nombre.",                                    
            "apellido.required" => "Ingrese  apellido.",   
            "mail.required" => "Ingrese  mail.",   
            "mail.email" => "Mail invalido.",   
            "telefono.required" => "Ingrese  telefono.",   
            "CUIT.required" => "Ingrese  CUIT.",   
            "CUIT.unique" => "CUIT existente." ,
            "alias.required" => "Ingrese alias ." ,
            "alias.unique" => "Alias existente." ,
            "comision.required" => "Ingrese comision." ,
            "comision.numeric" => "Comision invalida." ,
            "comision.min" => "Comision invalida." ,            
            "CBU.required" => "Ingrese CBU." ,
            "numero_cuenta.required" => "Ingrese numero de cuenta." ,
            
            
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
          $this->comitente = Comitente::find($this->id);
          $this->nombre = $this->comitente->nombre ;
          $this->apellido = $this->comitente->apellido;
          $this->title= "Eliminar";
          $this->btnText= "Eliminar";
          $this->bg=	"background-color: rgb(239 68 68)"; 
        }
        if($this->method == "update" || $this->method == "view" ){
              $this->comitente = Comitente::find($this->id);
              
              $this->nombre =  $this->comitente->nombre;  
              $this->apellido =  $this->comitente->apellido;  
              $this->alias =  $this->comitente->alias;  
              $this->mail =  $this->comitente->mail;  
              $this->telefono =  $this->comitente->telefono;  
              $this->CUIT =  $this->comitente->CUIT;  
              $this->domicilio =  $this->comitente->domicilio;  
              $this->banco =  $this->comitente->banco;  
              $this->numero_cuenta =  $this->comitente->numero_cuenta;  
              $this->CBU =  $this->comitente->CBU;  
              $this->alias_bancario =  $this->comitente->alias_bancario;  
              $this->observaciones =  $this->comitente->observaciones;  
              $this->foto =  $this->comitente->foto;  
                if ($this->comitente->comision !== null) {                  
                  $comision = floatval($this->comitente->comision);
                  $comision = ($comision == floor($comision)) ? (int)$comision : $comision;
                  $this->comision =  $comision;                   
                }
                      
              
              
              

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
    
      $this->validate( ); 

          $filename='';
      
          if ($this->foto instanceof UploadedFile) {             
              $manager = new ImageManager(new Driver());          
              $image =$manager->read($this->foto);
              $filename =  time() . '.' . $this->foto->getClientOriginalExtension();          
              $destino = public_path("storage/imagenes/comitentes/");            
              $image->scale(width:400);            
              $image->save($destino.$filename);                      
              }

            
          $cmt= Comitente::create([
            "nombre" => $this->nombre,
            "apellido" => $this->apellido,
            "alias" => $this->alias,
            "mail" => $this->mail,            
            "telefono" => $this->telefono,            
            "CUIT" => $this->CUIT,
            "domicilio" => $this->domicilio,
            "comision" => $this->comision,
            "banco" => $this->banco,
            "numero_cuenta" => $this->numero_cuenta,
            "CBU" => $this->CBU,
            "alias_bancario" => $this->alias_bancario,
            "observaciones" => $this->observaciones,
            // "foto" => $nombreArchivo ?? "",
            "foto" => $filename ?? "",
          ]);

          if($this->autorizados){                                    
                return $this->dispatch("autorizado",$cmt->id);
            }
          
          $this->dispatch('comitenteCreated');   
    }


    public function update(){
                          
      if(!$this->comitente){
        $this->dispatch('comitenteNotExits');   
      }            
        else
        {
          $this->validate(  $this->rules(), $this->messages());              
                $filename='';
      
          if ($this->foto instanceof UploadedFile) {                       
              $manager = new ImageManager(new Driver());          
              $image =$manager->read($this->foto);
              $filename =  time() . '.' . $this->foto->getClientOriginalExtension();          
              $destino = public_path("storage/imagenes/comitentes/");            
              $image->scale(width:400);            
              $image->save($destino.$filename);                      
              }
        

        $this->comitente->nombre= $this->nombre;
        $this->comitente->apellido= $this->apellido;
        $this->comitente->alias= $this->alias;
        $this->comitente->mail= $this->mail;
        $this->comitente->telefono= $this->telefono;
        $this->comitente->CUIT= $this->CUIT;
        $this->comitente->domicilio= $this->domicilio;
        $this->comitente->comision= $this->comision;
        $this->comitente->banco= $this->banco;
        $this->comitente->numero_cuenta= $this->numero_cuenta;
        $this->comitente->CBU= $this->CBU;
        $this->comitente->alias_bancario= $this->alias_bancario;        
        $this->comitente->observaciones= $this->observaciones;

        if($filename){                    
            $this->comitente->foto= $filename;
         }
        
        
       
        $this->comitente->save();
        $this->dispatch('comitenteUpdated');   
      }
      
    }

    public function delete(){                      

        if(!$this->comitente){
              $this->dispatch('comitenteNotExits');   
        }
        else{

          $this->comitente->autorizados()->delete();
          $this->comitente->delete();
          $this->dispatch('comitenteDeleted');   
        }
    }



    public function render()
    {
        return view('livewire.admin.comitentes.modal');
    }
}
