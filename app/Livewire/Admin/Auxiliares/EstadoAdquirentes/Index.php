<?php

namespace App\Livewire\Admin\Auxiliares\EstadoAdquirentes;

use App\Models\EstadosAdquirente;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{ 
    use WithPagination;  

    public $query,$nombre,$id;
    public $method="";    
    public $searchType="todos";    
    public $inputType="search";    
 
    public function option($method, $id=false){
      if($method == "delete" || $method == "update" || $method == "view"){
        $estado = EstadosAdquirente::find($id);
                if(!$estado){                  
                  $this->dispatch('estadoNotExits');   
                }
                else{                  
                  $this->method =$method ;
                  $this->id=$id;  
                }                
          }

          if($method == "save"){
            $this->method =$method ;
          }

      }


    #[On(['estadoCreated' ,'estadoUpdated' ,'estadoDeleted'] )]
      public function mount(){
        $this->method="";
        $this->resetPage(); 
      }

    public function render()
    {
      
          
         if($this->query){
            switch($this->searchType){
                case 'id':
                    $estados = EstadosAdquirente::where("id", "like", '%'.$this->query . '%');
                    break;
                case 'nombre':
                    $estados = EstadosAdquirente::where("nombre", "like", '%'.$this->query . '%');
                    break;                
                case 'descripcion':
                    $estados = EstadosAdquirente::where("descripcion", "like", '%'.$this->query . '%');
                    break;                
                case 'todos':
                    $estados = EstadosAdquirente::where("id", "like", '%' . $this->query . '%')
                                                  ->orWhere(".nombre", "like", '%' . $this->query . '%')
                                                  ->orWhere(".descripcion", "like", '%' . $this->query . '%');
                    break;
                }
                    $estados = $estados->orderBy("id","desc")->paginate(10);
              } else {
                $estados = EstadosAdquirente::orderBy("id", "desc")->paginate(10);
             }

                                 
        
        return view('livewire.admin.auxiliares.estado-adquirentes.index',compact('estados'));
    }
}
