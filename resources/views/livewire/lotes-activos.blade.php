<div class="flex flex-col justify-center items-center hvh w-full  pt-0  text-casa-black">
    <x-counter-header />

    <div class="mt-5">
        {{-- <x-buscador /> --}}
        <article class="bg-red-00 flex idden  w-full justify-center flex-col mt-10 mb-8">
            <h2 class="font-librecaslon font-normal text-[64px] leading-[1] tracking-normal text-center">
                {{ $subasta->titulo }}</h2>
            <h3 class="font-helvetica font-semibold text-3xl leading-[1] tracking-normal text-center mt-4 mb-2 ">Otros
                lotes
            </h3>
            <p class="text-center text-3xl">Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna.</p>

            <div
                class=" g-blue-200 flex border rounded-full  w-6/6  mx-auto justify-between pl-3 pr-1 py-1 items-center mt-5 border-casa-black">

                <div class="flex items-center">
                    <svg fill="#fff" class="size-8 ">
                        <use xlink:href="#lupa"></use>
                    </svg>
                    <span class="text-nowrap">¿Que buscas?</span>
                </div>


                <input class="w-full mx-3 focus:outline-0 " />

                <button
                    class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between  py-1 w-67">
                    Buscar
                    <svg class="size-8 ">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </button>

            </div>

        </article>

    </div>



    {{-- @role('adquirente') --}}
    @if (auth()->user())
        @if (auth()->user()?->adquirente?->estado_id == 1 ||
                auth()->user()?->adquirente?->garantia($subasta->id) ||
                !auth()->user()?->hasRole('adquirente'))



            <div class="grid grid-cols-3 px-20 mt-10 gap-12">

                @if (isset($lotes) && count($lotes))
                    @foreach ($lotes as $lote)
                        <div class="w-full bg-casa-base-2 bas flex flex-col p-6 gap-y-1 border border-casa-black ">

                            <div class="flex justify-between items-center">
                                <p class="font-bold text-3xl w-full  ">{{ $lote['titulo'] }}</p>
                                <x-hammer />
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
                                class="text-casa-black hover:bg-casa-black hover:text-gray-50  border border-black rounded-full px-4 flex items-center justify-between  py-2  w-full  text-xl font-bold mb-2 ">
                                Ver detalle
                                <svg class="size-8 ">
                                    <use xlink:href="#arrow-right"></use>
                                </svg>
                            </a>



                            @role('adquirente')
                                <button
                                    class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-2  w-full  text-xl font-bold">
                                    Agregar al carrito
                                    <svg class="size-8 ">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg>
                                </button>
                            @endrole


                        </div>
                    @endforeach
                @else
                    <div
                        class="flex bg-casa-black justify-center items-center text-4xl font-bold text-casa-base-2  py-18 px-40 col-span-3">
                        <p>¡Sin lotes en esta subasta!</p>
                    </div>
                @endif

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
