<?php

namespace App\Livewire\Admin\Auxiliares\CondicionIva;

use App\Models\CondicionIva;
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
        $cond = CondicionIva::find($id);
                if(!$cond){                  
                  $this->dispatch('condicionNotExits');   
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


    #[On(['condicionCreated' ,'condicionUpdated' ,'condicionDeleted'] )]
      public function mount(){
        $this->method="";
        $this->resetPage(); 
      }

    public function render()
    {
      
          
         if($this->query){
            switch($this->searchType){
                case 'id':
                    $condiciones = CondicionIva::where("id", "like", '%'.$this->query . '%');
                    break;
                case 'nombre':
                    $condiciones = CondicionIva::where("nombre", "like", '%'.$this->query . '%');
                    break;                
                case 'todos':
                    $condiciones = CondicionIva::where("id", "like", '%' . $this->query . '%')
                                                  ->orWhere(".nombre", "like", '%' . $this->query . '%');
                    break;
                }
                    $condiciones = $condiciones->orderBy("id","desc")->paginate(10);
              } else {
                $condiciones = CondicionIva::orderBy("id", "desc")->paginate(10);
             }

                                 
        return view('livewire.admin.auxiliares.condicion-iva.index',compact('condiciones'));
    }
}
