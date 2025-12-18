<div class="flex flex-col justify-center items-center  w-full    text-casa-black md:gap-y-24 gap-y-16 pt-12">




    <div class="  w-full  [&>article]:max-w-5xl">
        @livewire('buscador', ['subasta_id' => $subasta->id, 'search' => $search])
    </div>



    {{-- @role('adquirente') --}}
    @if (auth()->user())
        {{-- @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia($subasta->id) || !auth()->user()?->hasRole('adquirente')) --}}


        <div class=" bg-casa-black flex  border rounded-full    mx-auto justify-between pl-3 pr-1 py-0.5 items-center  border-casa-black col-span-3"
            wire:show="filtered">

            <p class="text-nowrap text-casa-base-2 ml-2">Resultados: <span class="ml-1">{{ $filtered }}</span>
            </p>


            <button wire:click="todos"
                class="bg-casa-base-2 hover:bg-casa-black-h hover:text-casa-base border border-casa-base  text-casa-black rounded-full px-4 flex items-center justify-between  py-0.5 w-fit md:ml-20 ml-4">
                Ver todos los lotes
                <span class="text-xl leading-0 ml-8">X</span>
            </button>
        </div>


        {{-- <div class="flex bg-casa-black justify-center items-center text-4xl font-bold text-casa-base-2  py-8 px-40 col-span-3 "
                wire:show="noSearch"> --}}
        <div class=" bg-casa-black flex  border rounded-full  w-fit  mx-auto justify-between  py-2 items-center  border-casa-black col-span-3 text-casa-base-2    px-4 md:text-xl text-md"
            wire:show="noSearch">
            <button wire:click="$set('noSearch',false)">¡Sin resultados para <b>"{{ $search }}"</b>!

                <svg class="lg:size-8 size-7 lg:ml-20 ml-7 inline hover:scale-105">
                    <use xlink:href="#x"></use>
                </svg>
            </button>
            </button>


        </div>







        <div class="flex flex-wrap   md:gap-12 gap-2 place-content-center justify-center max-w-[1440px]  w-full">


            @forelse ($lotes as $lote)
                <div
                    class=" bg-casa-base-2 bas flex flex-col md:p-6 p-2 gap-y-1 md:border border-casa-black md:w-[394px]  md:min-w-[300px] min-w-[44%] relative max-w-[48%]">

                    {{-- <div class="flex justify-between items-center md:order-1 order-2"> --}}
                    {{-- <p class="font-bold md:text-3xl text-sm w-full  mr-3">{{ $lote['titulo'] }}</p> --}}
                    {{-- </div> --}}

                    <x-clamp :text="$lote['titulo']" bclass="z-20" exp="-bottom-2 -right-2 md:right-0" />

                    <div class="flex gap-x-4 justify-center my-2 md:order-2 order-1">
                        <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote['foto']) }}"
                            class="md:size-49 size-20 " />
                    </div>


                    <p class="text-xl mb-2 md:block hidden md:order-3">{{ $lote['descripcion'] }}. </p>


                    <p class="md:text-xl text-sm  mt-auto md:order-4 order-3">Base:
                        {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['precio_base'] }}</p>



                    {{-- <a href="{{ route('lotes.show', $lote['id']) }}" class="absolute inset-0 md:hidden z-10"></a> --}}




                    @if ($lote['estado_lote'] == 'vendido')
                        <p
                            class=" bg-red-800 text-casa-base  border border-black rounded-full px-4 flex  justify-center  md:py-2 pt-0.5  w-full  md:text-xl text-sm font-bold mb-2 order-6">
                            VENDIDO
                        </p>
                    @else
                        {{-- <a href="{{ route('lotes.show', $lote['id']) }}"
                                class="hover:text-casa-black bg-casa-black text-gray-50  hover:bg-casa-base  border border-black rounded-full px-4 flex items-center justify-between  py-2  w-full  text-xl font-bold mb-2 ">
                                Ver detalle
                                <svg class="size-8 ">
                                    <use xlink:href="#arrow-right"></use>
                                </svg>
                            </a> --}}

                        <a href="{{ route('lotes.show', $lote['id']) }}" class="absolute inset-0 md:hidden z-10"></a>

                        <a href="{{ route('lotes.show', $lote['id']) }}"
                            class="hover:text-casa-black bg-casa-black text-casa-base  hover:bg-casa-base  border border-black rounded-full px-4 md:flex items-center justify-between  py-2  w-full  text-xl font-bold mb-2  hidden  order-6">
                            <span class="md:inline-block hidden">Ver detalle</span>
                            <svg class="size-[26px] ">
                                <use xlink:href="#arrow-right1"></use>
                            </svg>
                        </a>
                    @endif





                </div>
            @empty


                <div
                    class="flex bg-casa-black justify-center items-center text-4xl font-bold text-casa-base-2  py-18 px-40 col-span-3">
                    <p>¡Sin lotes en esta subasta!</p>
                </div>
            @endforelse

        </div>
        {{-- @else
            <div class="mt-5">
                <x-registrate />
            </div>
        @endif --}}
    @endif
    {{-- @endrole --}}



    {{-- <button class="bg-blue-600 text-white px-2 my-2 ml-60 rounded-2xl  text-center" wire:click="mp">MP</button>
    <button class="bg-red-600 text-white px-2 my-2 ml-60 rounded-2xl  text-center" wire:click="crearDevolucion(21)">MP -
        REFOUND</button> --}}


    {{-- <button class="bg-white rounded text-red-700 px-5 py-0 ml-40 mr-30 " wire:click="activar">Cheack Activar</button>
    <button class="bg-white rounded text-red-700 px-5 py-0 mx-auto " wire:click="job">Cheack Desactivar</button>
    <hr><br> --}}





</div>
