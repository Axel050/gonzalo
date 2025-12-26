<div class="flex flex-col justify-center items-center hvh w-full    text-casa-black md:gap-y-24 gap-y-16 pt-12">



    <div class="  w-full  [&>article]:max-w-5xl flex flex-col gap-y-4">

        @livewire('buscador', ['subasta_id' => 1, 'search' => $search, 'view' => true])
        {{-- <x-search-message :search="$search" /> --}}



        <div class=" bg-casa-black flex  border rounded-full   w-fit  mx-auto pl-3 pr-1 py-0.5 items-center  border-casa-black  {{ $existFrom ? 'justify-between' : 'justify-center' }} "
            wire:show="filtered">
            {{-- @dump($existFrom) --}}
            <p class="text-nowrap text-casa-base-2 ml-2">Resultados para <b>"{{ $search }}"</b></span>
            </p>


            @if ($existFrom)
                <a href="{{ route($from) }}"
                    class="bg-casa-base-2 hover:bg-casa-black-h hover:text-casa-base border border-casa-base  text-casa-black rounded-full px-4 flex items-center justify-between  py-0.5 w-fit lg:ml-20 ml-7  font-semibold">
                    Volver a {{ $from }}

                    <svg class="size-[26px] md:ml-8 ml-5 ">
                        <use xlink:href="#arrow-right1"></use>
                    </svg>
                </a>
            @endif

        </div>



    </div>



    {{-- @dump($te) --}}


    {{-- @role('adquirente') --}}
    @if (auth()->user())
        {{-- @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia($subasta->id) || !auth()->user()?->hasRole('adquirente')) --}}





        <div class="flex flex-wrap   md:gap-12 gap-2 place-content-center justify-center max-w-[1440px] px-2 md:px-0">



            <div class="contents">
                @foreach ($lotes as $lote)
                    <div class=" bg-casa-base-2 bas flex flex-col md:p-6 p-2 gap-y-1 md:border border-casa-black md:w-[394px]  md:min-w-[300px] min-w-[44%] max-w-[48%]  relative w-full"
                        wire:key="lote-{{ $lote['id'] }}">

                        <div class="flex justify-between items-center ">

                            <p class="font-bold md:text-3xl text-sm w-full  mr-3">{{ $lote['titulo'] }}</p>

                            @if ($lote['tipo'] == 'activo')
                                {{-- @if ($lote['puja_actual'] > 0) --}}
                                @if ($lote['tienePujas'])
                                    <x-hammer />
                                @else
                                    <x-hammer-fix />
                                @endif
                            @endif

                        </div>

                        <div class="flex gap-x-4 justify-center my-2">
                            <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote['foto']) }}"
                                class="md:size-49 size-20  " />
                        </div>


                        <p class="text-xl mb-2 md:block hidden md:order-3">{{ $lote['descripcion'] }}. </p>


                        {{-- @dump($lote['base']) --}}

                        @php
                            $signo;
                        @endphp
                        <p class="md:text-xl text-sm  mt-auto md:order-4 order-3">Base:
                            {{ $lote['precio_base'] }}
                            {{-- {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['base'] }} --}}
                        </p>

                        @if ($lote['tipo'] == 'activo')
                            <p class="md:text-xl text-sm font-semibold md:mb-3 md:order-5 order-4">
                                <span class="md:inline-block hidden ">Oferta actual: </span>
                                <span class="md:hidden ">Actual: </span>
                                {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['puja_actual'] ?? 0 }}
                            </p>
                        @else
                            <p class="text-xl font-semibold h-3"></p>
                        @endif



                        {{-- <a href="{{ route('lotes.show', $lote['lote_id']) }}" --}}
                        <a href="{{ route('lotes.show', $lote['id']) }}"
                            class="hover:text-casa-black bg-casa-black text-gray-50  hover:bg-casa-base  border border-black rounded-full px-4 md:flex items-center justify-between  py-2  w-full  text-xl font-bold mb-2  hidden  order-6">
                            Ver detalle
                            <svg class="size-[26px] ">
                                <use xlink:href="#arrow-right1"></use>
                            </svg>
                        </a>






                    </div>
                @endforeach
            </div>

            @if (empty($lotes) && strlen($search) >= 3)
                <div class="flex flex-col bg-casa-black justify-center items-center md:text-4xl text-xl font-bold text-casa-base-2  md:py-16 py-10 md:px-40 px-10 col-span-3 md:gap-y-8 gap-y-6"
                    wire:key="no-results">
                    <p>¡Sin lotes encontrados!</p>


                    <a href="{{ route($from) }}"
                        class="bg-casa-base-2 hover:bg-casa-black-h hover:text-casa-base border border-casa-base  text-casa-black rounded-full px-4 flex items-center justify-between  py-0.5 w-fit  text-lg ">
                        Volver a subastas

                        <svg class="size-[26px] md:ml-8 ml-5">
                            <use xlink:href="#arrow-right1"></use>
                        </svg>
                    </a>




                </div>
            @endif


            @if ($hasMore)
                <div class="text-center mt-8 w-full px-4">
                    <button wire:click="loadMore" wire:loading.attr="disabled"
                        class="bg-casa-base-2 text-casa-black rounded-3xl md:px-30 py-2 font-bold w-full md:w-fit border border-casa-black md:text-lg text-sm hover:bg-casa-base">
                        <span wire:loading.remove>Cargar más</span>
                        <span wire:loading>Cargando...</span>
                    </button>
                </div>
            @endif
        </div>
        {{-- @else
            <div class="mt-5">
                <x-registrate />
            </div>
        @endif --}}
    @endif
    {{-- @endrole --}}








</div>
