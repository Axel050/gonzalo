<div class="fixed  inset-0 flex items-center justify-center  z-50 animate-fade-in-scale">

    <div class="absolute inset-0  bg-gray-600/70 backdrop-blur-xs transition-opacity duration-300"
        wire:click="$parent.$set('method',false)">
    </div>

    <div
        class = ' border  border-gray-500   md:max-w-xl  lg:w-[40%] w-[90%] x-auto  z-50  shadow-gray-400 shadow-md max-h-[95%] 
   transition delay-150 duration-300 ease-in-out  rounded-2xl '>

        {{-- <x-modal> --}}


        <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
            <div class="flex  flex-col justify-center items-center  ">
                <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"
                    style="{{ $bg }}">
                    {{ $title }} contrato
                </h2>


                <div
                    class="bg-red-80  w-full  flex flex-col gap-2 lg:text-lg  text-base lg:px-4 px-2 text-gray-200  [&>div]:flex
                            [&>div]:flex-col  [&>div]:justify-center pt-4 max-h-[85vh] overflow-y-auto">

                    @if ($method == 'delete')
                        <p class="text-center text-gray-600 lg:px-10 px-6"> Esta seguro de eliminar el contrato</p>
                        <p class="text-center text-gray-600"><strong>"{{ $contrato->comitente?->nombre }}
                                {{ $contrato->comitente?->apellido }}" </strong>?</p>
                    @else
                        <div class="lg:w-60 w-[85%] mx-auto ">
                            <div id="wrapper-select-tom2" wire:ignore>
                                <label
                                    class="w-full text-start text-gray-500 leading-[16px] text-base">Comitente</label>
                                <select id="select-tom-contratos" placeholder="Elija comitente">
                                    <option value="">Elija comitente</option>
                                    @foreach ($comitentes as $com)
                                        <option value="{{ $com->id }}">
                                            @if ($com->alias)
                                                {{ $com->alias->nombre }} -
                                            @endif
                                            {{ $com->nombre }} {{ $com->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error for="comitente_id"
                                class="absotule top-full py-0 leading-[12px] text-red-500" />
                        </div>








                        <x-form-item-sel label="Subasta" :method="$method" model="subasta_id">
                            <option>Elija subasta </option>
                            @foreach ($subastas as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->id }} - {{ $sub->titulo }}</option>
                            @endforeach
                        </x-form-item-sel>

                        <x-form-item-area label="Descripcion contrato" :method="$method" model="descripcion" />

                        <x-form-item label="Fecha" :method="$method" model="fecha_firma" type="date" />





                        @if ($method == 'save')
                            <label
                                class="flex items-center justify-center text-gray-500 leading-[16px] text-base  lg:m-2 bg-ed-100 mx-auto col-span-2 mt-2">
                                <input type="checkbox" wire:model="lotes" class="mr-2 size-4" />Agregar
                                lotes
                            </label>
                        @endif






                    @endif

                    <div class="flex !flex-row gap-6 justify-center lg:text-base text-sm">
                        <button type="button"
                            class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                            wire:click="$parent.$set('method',false)">
                            Cancelar
                        </button>

                        @if ($method != 'view')
                            <button
                                class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "
                                wire:click="{{ $method }}">
                                {{ $btnText }}
                            </button>
                        @endif


                    </div>

                </div>




            </div>
        </div>



        {{-- </x-modal> --}}
    </div>

</div>
