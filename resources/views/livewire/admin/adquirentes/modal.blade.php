<div class="fixed inset-0 flex items-center justify-center  z-50 " >
   
      <div class="absolute  inset-0 bg-gray-600 opacity-70" wire:click="$parent.$set('method',false)"></div>              
                                    
        <div  class=" border  border-gray-500   md:max-w-[80%] md:w-fit    w-[90%] x-auto  z-50  shadow-gray-400 shadow-md max-h-[90%] 
              transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-105 rounded-2xl          
          " >
              
            <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">            
              <div class="flex  flex-col justify-center items-center  ">                             
                    <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"  style="{{$bg}}">
                        {{$title}} adquirente 
                    </h2>                                                                      
                    
                    <form class="bg-red-80  w-full  flex flex-col lg:grid lg:grid-cols-2 gap-2 lg:gap-x-12 llg:text-lg  text-base lg:px-10 px-2 text-gray-200  [&>div]:flex
                      [&>div]:flex-col  [&>div]:justify-center pt-4 max-h-[85vh] overflow-y-auto"  wire:submit={{$method}} >
                      
                      @if ($method =="delete")
                          <p class="text-center text-gray-600 lg:px-10 px-6 col-span-2"> Esta seguro de eliminar el adquirente 
                          <strong >"{{$nombre}} , {{$apellido}}" </strong>?
                        </p>
                        @else
                        
                                                                                                      
                        <x-form-item label="Nombre" :method="$method" model="nombre" />

                        <x-form-item label="Apellido" :method="$method" model="apellido" />

                        <x-form-item label="Alias" :method="$method" model="alias" />

                        <x-form-item label="Mail  (user)"  :method="$method" model="mail" />

                        <x-form-item label="Telefono" :method="$method" model="telefono" />

                        <x-form-item label="CUIT" :method="$method" model="CUIT" />
                        
                        <x-form-item label="Domicilio" :method="$method" model="domicilio" />

                        <x-form-item label="Comision" :method="$method" model="comision" type="number" step="0.1" min=0 />
                                                                                                                                                                       
                        <div class=" items-start  lg:w-auto w-[85%] mx-auto ">
                          <label  class="w-full text-start text-gray-500  leading-[16px] text-base">Estado</label>
                          <div class="relative w-full">
                            <select   wire:model="estado_id"  class =" h-6 py-0 rounded-md border border-gray-400 lg:w-60 w-full text-gray-500 bg-gray-100 pl-2 text-sm"    @disabled($method === 'view') >
                              <option>Elija estado </option>
                              @foreach ($estados as $estado)
                                <option value="{{$estado->id}}"> {{$estado->nombre}}</option>    
                              @endforeach

                            </select>
                            <x-input-error for="estado_id"   class="absotule top-full py-0 leading-[12px] text-red-500" />
                          </div>
                        </div>


                        <div class=" items-start  lg:w-auto w-[85%] mx-auto ">
                          <label  class="w-full text-start text-gray-500  leading-[16px] text-base">Condicion IVA</label>
                          <div class="relative w-full">
                            <select   wire:model="condicion_iva_id"  class =" h-6 py-0 rounded-md border border-gray-400 lg:w-60 w-full text-gray-500 bg-gray-100 pl-2 text-sm"    @disabled($method === 'view') >
                              <option>Elija estado </option>
                              @foreach ($condiciones as $cond)
                              <option value={{$cond->id}}>{{$cond->nombre}}</option>    
                              @endforeach

                            </select>
                            <x-input-error for="condicion_iva_id"   class="absotule top-full py-0 leading-[12px] text-red-500" />
                          </div>
                        </div>

                        @if ($method != "view")
                            
                        
                        
                        <div class="items-start  lg:w-auto w-[85%] mx-auto">                          
                          <div class="flex justify-between w-full">
                            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Password </label>                            
                            <button type="button" wire:click="$toggle('ver')" class="cursor-pointer pr-1">
                                @if ($ver)
                                  <svg width="20px" height="20px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" clip-rule="evenodd" d="M0 8L3.07945 4.30466C4.29638 2.84434 6.09909 2 8 2C9.90091 2 11.7036 2.84434 12.9206 4.30466L16 8L12.9206 11.6953C11.7036 13.1557 9.90091 14 8 14C6.09909 14 4.29638 13.1557 3.07945 11.6953L0 8ZM8 11C9.65685 11 11 9.65685 11 8C11 6.34315 9.65685 5 8 5C6.34315 5 5 6.34315 5 8C5 9.65685 6.34315 11 8 11Z" fill="#6a7282"/>
                                  </svg>                                    
                                @else
                                  <svg width="20px" height="20px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <path fill-rule="evenodd" clip-rule="evenodd" d="M16 16H13L10.8368 13.3376C9.96488 13.7682 8.99592 14 8 14C6.09909 14 4.29638 13.1557 3.07945 11.6953L0 8L3.07945 4.30466C3.14989 4.22013 3.22229 4.13767 3.29656 4.05731L0 0H3L16 16ZM5.35254 6.58774C5.12755 7.00862 5 7.48941 5 8C5 9.65685 6.34315 11 8 11C8.29178 11 8.57383 10.9583 8.84053 10.8807L5.35254 6.58774Z" fill="#6a7282"/>
                                      <path d="M16 8L14.2278 10.1266L7.63351 2.01048C7.75518 2.00351 7.87739 2 8 2C9.90091 2 11.7036 2.84434 12.9206 4.30466L16 8Z" fill="#6a7282"/>
                                  </svg>
                                @endif
                                  
                                </button>                                                      
                          </div>

                            <div class="relative w-full">
                                  <input type={{$typePass}} wire:model="password" class="lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 bg-gray-100 pl-2 text-sm" @disabled($method === "view") />
                                  <x-input-error for="password" class="absotule top-full py-0 leading-[12px] text-red-500" />
                              </div>
                         </div>

                        <x-form-item label="Repita contraseña" :method="$method" model="password_confirmation" type="password" />

                        @endif
                        
                      {{-- }}}}}}}}}}}}}}}}}}}}} --}}
                        
                            <div class="items-start  lg:w-auto w-[85%] mx-auto !hiddn">                          
                                
                                  <div class="pl-2"> 
                                    <label  class="w-full text-start text-gray-500 mt-2 leading-[16px] text-base">Foto</label>
                                    <div class="mt-0.5" >

                                        @php
                                              $url = $foto && method_exists($foto, 'temporaryUrl') ? $foto->temporaryUrl() : ($foto ? Storage::url('imagenes/adquirentes/'.$foto) : asset('004b.jpg'));
                                        @endphp
                                                                
                                      <img src="{{ $url }}" alt="Previsualización"   style="max-width: 100px; max-height: 100px; object-fit: cover; display: block;"       class="mx-auto border">
                                                                
                                    </div>

                    
                                    <div 
                                            x-data="{ uploading: false, progress: 0 }"
                                            x-on:livewire-upload-start="uploading = true"
                                            x-on:livewire-upload-finish="uploading = false"
                                            x-on:livewire-upload-cancel="uploading = false"
                                            x-on:livewire-upload-error="uploading = false"
                                            x-on:livewire-upload-progress="progress = $event.detail.progress"                                            
                                        >
                                        
                                        <input    class=" mt-2  mr-2 text-gray-700 text-xs flex flex-col border border-cyan-800 rounded-xl pr-1 lg:w-60
                                                                  file:bg-gradient-to-r file:from-cyan-800 file:to-cyan-950 file:rounded-l-xl file:px-2 file:text-gray-100 file:text-xs
                                                                  hover:file:bg-gradient-to-l hover:file:from-cyan-900 hover:file:to-cyan-950 hover:file:text-white 
                                                                  cursor-pointer file:cursor-pointer disabled:cursor-not-allowed disabled:file:cursor-not-allowed"                               
                                                        id="file_input" type="file" wire:model="foto"  accept=".jpg, .jpeg, .png"   @disabled($method === 'view') />
                                            

                                            <div class="mb-1" style="height: 7px;"> 
                                                <x-input-error for="foto" style="font-size: 13px"  />                                            
                                            </div>            

                                              <!-- Progress Bar -->
                                          <div x-show="uploading" class="text-center">
                                              <progress max="100" x-bind:value="progress" ></progress>
                                          </div>
                                          
                                    </div>            


                                    {{--  --}}

                                    {{--  --}}
                                    
                                    
                                  </div>                                                                  
                                  
                                </div> 
                                
                                @if ($method == "save")                                
                                <label class="w-fit text-start text-gray-500 leading-[16px] text-base  lg:m-2">
                                  <input type="checkbox" wire:model="autorizados"  class="mr-2"  />Agregar autorizados
                                </label> 
                                @endif
                                    
                                
                          
                          @endif

                          <div class="flex !flex-row gap-6 justify-center lg:text-base text-sm lg:col-span-2">

                            <button  type="button" class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                                           wire:click="$parent.$set('method',false)"
                              >
                                Cancelar
                            </button >
                            
                            @if ($method != "view")                                      
                            <button class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "  >
                              {{$btnText}}                                        
                            </button >                        
                            @endif
                                                        
                            
                          </div>

                          {{-- </div> --}}
                      </form> 
                      
                </div>
          </div>
    </div>
                                                        
</div>