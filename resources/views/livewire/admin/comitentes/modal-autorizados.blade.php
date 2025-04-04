<div class="fixed inset-0 flex items-center justify-center  z-50 " >
   
      <div class="absolute  inset-0 bg-gray-600 opacity-70" wire:click="$parent.$set('method',false)"></div>              
                                    
        <div  class=" border  border-gray-500   md:max-w-[80%] md:w-fit    w-[90%] x-auto  z-50  shadow-gray-400 shadow-md max-h-[95%] 
              transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-105 rounded-2xl          
          " >
              
            <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">            
              <div class="flex  flex-col justify-center items-center  ">                             
                    <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg bg-yellow-800" >
                        Autorizados  de <b>{{$comitente->nombre}}, {{$comitente->apellido}}</b>
                    </h2>                                                                      
                    
                    <div class="bg-red-80  w-full  flex flex-col lg:grid lg:grid-cols-2 gap-2 lg:gap-x-8 llg:text-lg  text-base lg:px-10 px-2 text-gray-200  [&>div]:flex
                      [&>div]:flex-col  [&>div]:justify-center pt-4 max-h-[85vh] overflow-y-auto"  >
                                                                                                                            
                            <x-form-item label="Nombre" :method="$method" model="nombre" />
                            <x-form-item label="Apellido" :method="$method" model="apellido" />                            
                            <x-form-item label='Dni' :method="$method" model="dni" />                                                                            
                            <x-form-item label="Telefono" :method="$method" model="telefono" />                            
                            <x-form-item label="Mail" :method="$method" model="email" />

                            <div class="col-span-2">
                                <button wire:click="add" class="bg-yellow-600 hover:bg-yellow-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 w-3/4 mx-auto cursor-pointer">Agregar</button>
                            </div>

                            
                            <table class="table-auto min-w-full divide-y  divide-gray-600 shadow-lg  col-span-2 mt-2  rounded-3xl">  

                                  <caption class="caption-top text-gray-700">
                                        Listado de autorizados {{$comitente->autorizados->count()}}
                                  </caption>
                                  <thead>                                                      
                                    <tr class="bg-gray-400 relative font-bold divide-x-2 divide-gray-600  text-sm text-gray-900 text-center">
                                                  <th class="py-1">Nombre</th>
                                                  <th>DNI</th>
                                                  <th>Telefono</th>
                                                  <th>Mail</th>
                                                  <th>Accion</th>
                                        </tr>
                                      </thead>
                                      <tbody class="divide-y divide-gray-300 text-gray-600  text-sm rounded-full">
                                        
                                      @foreach ($tempAutorizados as $index => $item)
                                        <tr class="bg-gray-100 relative font-bold divide-x-2 divide-gray-300 text-center [&>td]:lg:px-8 [&>td]:px-2 ">
                                          <td class="py-1">{{ $item['nombre'] }} {{ $item['apellido'] }} </td>
                                          <td>{{ $item['dni'] }} </td>
                                          <td>{{ $item['telefono'] }} </td>
                                          <td>{{ $item['email'] }} </td>
                                          <td >
                                            <div class="flex justfy-end lg:gap-x-6 gap-x-3 text-white text-xs">
                                            
                                            <button  class=" hover:text-gray-200  hover:bg-red-700 flex items-center py-0.5 bg-red-600 rounded-lg px-1 cursor-pointer" wire:click="quitar({{ $index }})">
                                                    <svg width="20px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                          <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                                                           <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <g id="SVGRepo_iconCarrier"> <path d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                                      </svg>                                                        
                                                      <span class="hidden lg:block">Quitar</span>
                                                </button>
                                            
                                            <button class=" hover:text-gray-200 hover:bg-orange-700 flex items-center py-0.5 bg-orange-600 rounded-lg px-1 cursor-pointer" wire:click="editar({{ $index }})" >
                                                        <svg width="20px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                              <path fill-rule="evenodd" clip-rule="evenodd" d="M21.1213 2.70705C19.9497 1.53548 18.0503 1.53547 16.8787 2.70705L15.1989 4.38685L7.29289 12.2928C7.16473 12.421 7.07382 12.5816 7.02986 12.7574L6.02986 16.7574C5.94466 17.0982 6.04451 17.4587 6.29289 17.707C6.54127 17.9554 6.90176 18.0553 7.24254 17.9701L11.2425 16.9701C11.4184 16.9261 11.5789 16.8352 11.7071 16.707L19.5556 8.85857L21.2929 7.12126C22.4645 5.94969 22.4645 4.05019 21.2929 2.87862L21.1213 2.70705ZM18.2929 4.12126C18.6834 3.73074 19.3166 3.73074 19.7071 4.12126L19.8787 4.29283C20.2692 4.68336 20.2692 5.31653 19.8787 5.70705L18.8622 6.72357L17.3068 5.10738L18.2929 4.12126ZM15.8923 6.52185L17.4477 8.13804L10.4888 15.097L8.37437 15.6256L8.90296 13.5112L15.8923 6.52185ZM4 7.99994C4 7.44766 4.44772 6.99994 5 6.99994H10C10.5523 6.99994 11 6.55223 11 5.99994C11 5.44766 10.5523 4.99994 10 4.99994H5C3.34315 4.99994 2 6.34309 2 7.99994V18.9999C2 20.6568 3.34315 21.9999 5 21.9999H16C17.6569 21.9999 19 20.6568 19 18.9999V13.9999C19 13.4477 18.5523 12.9999 18 12.9999C17.4477 12.9999 17 13.4477 17 13.9999V18.9999C17 19.5522 16.5523 19.9999 16 19.9999H5C4.44772 19.9999 4 19.5522 4 18.9999V7.99994Z" fill="#ffffff"/>
                                                          </svg>
                                                        <span class="hidden lg:block">Editar</span>
                                                      </button>
                                            </div>
                                          </td>
                                        </tr>
                                        @endforeach
                                        
                                      </tbody>
                                </table>

                                                                                                                                                                                                  


                          <div class="flex !flex-row gap-6 justify-center lg:text-base text-sm lg:col-span-2">                                   
                            <button  type="button" class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                              wire:click="$parent.$set('method',false)">                                
                              Cancelar
                            </button >
                            
                            
                            <button class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "  wire:click="save">
                              Guardar                                       
                            </button >                        
                            

                            
                          </div>

                          {{-- </div> --}}
                        </div> 
                      
                </div>
          </div>
    </div>
                                                        
</div>