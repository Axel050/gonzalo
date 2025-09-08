<div class="flex flex-col justify-center items-center hvh w-full  pt-0  text-casa-black">


    <div class="mt-5">

        @livewire('buscador', ['subasta_id' => $subasta->id, 'search' => $search])

    </div>



    {{-- @role('adquirente') --}}
    @if (auth()->user())
        @if (auth()->user()?->adquirente?->estado_id == 1 ||
                auth()->user()?->adquirente?->garantia($subasta->id) ||
                !auth()->user()?->hasRole('adquirente'))

            <div class=" bg-casa-black flex  border rounded-full  w-2xl  mx-auto justify-between pl-3 pr-1 py-0.5 items-center mt-5 border-casa-black col-span-3"
                wire:show="filtered">

                <p class="text-nowrap text-casa-base-2 ml-2">Resultados: <span class="ml-1">{{ $filtered }}</span>
                </p>


                <button wire:click="todos"
                    class="bg-casa-base-2 hover:bg-casa-black-h hover:text-casa-base border border-casa-base  text-casa-black rounded-full px-4 flex items-center justify-between  py-0.5 w-fit">
                    Ver todos los lotes
                    <span class="text-xl leading-0 ml-8">X</span>
                </button>
            </div>


            {{-- <div class="flex bg-casa-black justify-center items-center text-4xl font-bold text-casa-base-2  py-8 px-40 col-span-3 "
                wire:show="noSearch"> --}}
            <div class=" bg-casa-black flex  border rounded-full  w-fit  mx-auto justify-center  py-1 items-center mt-5 border-casa-black col-span-3 text-casa-base-2  px-14 text-lg"
                wire:show="noSearch">
                <button wire:click="$set('noSearch',false)">¡Sin resultados para <b>"{{ $search }}"</b>! <span
                        class="text-xl leading-0 ml-8 cursor-pointer">X</span></button>

            </div>



            <div class="flex flex-wrap x-20 mt-10 gap-12 place-content-center justify-center max-w-[1440px]">

                @forelse ($lotes as $lote)
                    <div
                        class=" bg-casa-base-2 bas flex flex-col p-6 gap-y-1 border border-casa-black w-[394px]  min-w-[300px]">

                        <div class="flex justify-between items-center">
                            <p class="font-bold text-3xl w-full   mr-3">{{ $lote['titulo'] }}</p>
                            {{-- <x-hammer /> --}}
                        </div>

                        <div class="flex gap-x-4 justify-center my-2">

                            {{-- <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1) }}" class="size-36 obje " /> --}}
                            <img src="{{ Storage::url('imagenes/lotes/normal/' . $lote['foto']) }}"
                                class="size-49  obje " />

                        </div>


                        <p class="text-xl mb-2">{{ $lote['descripcion'] }}. </p>

                        @php
                            $signo;
                        @endphp
                        <p class="text-xl  mt-auto">Base:
                            {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['precio_base'] }}</p>
                        <p class="text-xl font-semibold mb-3">Oferta
                            actual:
                            {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['puja_actual'] ?? 0 }}</p>





                        <a href="{{ route('lotes.show', $lote['id']) }}"
                            class="hover:text-casa-black bg-casa-black text-gray-50  hover:bg-casa-base  border border-black rounded-full px-4 flex items-center justify-between  py-2  w-full  text-xl font-bold mb-2 ">
                            Ver detalle
                            <svg class="size-8 ">
                                <use xlink:href="#arrow-right"></use>
                            </svg>
                        </a>






                    </div>
                @empty


                    <div
                        class="flex bg-casa-black justify-center items-center text-4xl font-bold text-casa-base-2  py-18 px-40 col-span-3">
                        <p>¡Sin lotes en esta subasta!</p>
                    </div>
                @endforelse

            </div>
        @else
            <div class="mt-5">
                <x-registrate />
            </div>
        @endif
    @endif
    {{-- @endrole --}}



    {{-- <button class="bg-blue-600 text-white px-2 my-2 ml-60 rounded-2xl  text-center" wire:click="mp">MP</button>
    <button class="bg-red-600 text-white px-2 my-2 ml-60 rounded-2xl  text-center" wire:click="crearDevolucion(21)">MP -
        REFOUND</button> --}}


    {{-- <button class="bg-white rounded text-red-700 px-5 py-0 ml-40 mr-30 " wire:click="activar">Cheack Activar</button>
    <button class="bg-white rounded text-red-700 px-5 py-0 mx-auto " wire:click="job">Cheack Desactivar</button>
    <hr><br> --}}





</div>
