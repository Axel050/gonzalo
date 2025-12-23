<div class="flex flex-col justify-center items-center hvh w-full  pt-12  text-casa-black md:gap-y-24 gap-y-16 md:px-24">

    <div class="  w-full  [&>article]:max-w-5xl flex flex-col gap-y-4">

        @livewire('buscador', ['subasta_id' => $subasta->id, 'search' => $search])
        <x-search-message :search="$search" />

    </div>



    {{-- @dump('check hammer move'd) --}}
    {{-- @role('adquirente') --}}
    @if (auth()->user())
        {{-- @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia($subasta->id) || !auth()->user()?->hasRole('adquirente')) --}}

        {{-- 
        <div class=" bg-casa-black flex  border rounded-full    mx-auto justify-between pl-3 pr-1 py-0.5 items-center  border-casa-black col-span-3 bg-red"
            wire:show="filtered">

            <p class="text-nowrap text-casa-base-2 ml-2">Resultados: <span class="ml-1">{{ $filtered }}</span>
            </p>


            <button wire:click="todos"
                class="bg-casa-base-2 hover:bg-casa-black-h hover:text-casa-base border border-casa-base  text-casa-black rounded-full px-4 flex items-center justify-between  py-0.5 w-fit sm:ml-20 ml-4">
                Ver todos los lotes
                <span class="text-xl leading-0 ml-8">X</span>
            </button>
        </div>


        <div class=" bg-casa-black flex  border rounded-full  w-fit  mx-auto justify-between  py-2 items-center  border-casa-black col-span-3 text-casa-base-2  px-4 sm:text-xl text-lg"
            wire:show="noSearch">
            <button wire:click="$set('noSearch',false)">¡Sin resultados para <b>"{{ $search }}"</b>!


                <svg class="lg:size-8 size-7 lg:ml-20 ml-7 inline hover:scale-105">
                    <use xlink:href="#x"></use>
                </svg>
            </button>

        </div> --}}

        @if (
            !(auth()->user()?->adquirente?->estado_id == 1 ||
                auth()->user()?->adquirente?->garantia($subasta->id) ||
                !auth()->user()?->hasRole('adquirente')
            ))

            {{-- <x-registrate monto="{{ $subasta->garantia }}" subasta={{}} /> --}}

            <article
                class="g-red-500 flex idden   w-full  lg:justify-center justify-start flex-col  mx-auto lg:px-12 lg:py-12 px-6 py-10  bg-casa-fondo-h border border-casa-black  max-w-8xl">
                {{-- <h2 class=" font-bold lgtext-3xl  text-xl lg:text-center text-start">¿Como puedo ofertar?</h2> --}}
                <button
                    class="bg-casa-black hover:bg-transparent hover:text-casa-black border border-casa-black text-casa-base rounded-full px-4 flex items-center justify-between  py-1  col-span-3 mx-auto lg:text-2xl font-semibold text-sm lg:w-fit lg w-full  "
                    wire:click="$set('modalPago',true)">
                    <span class="pb-0.5">
                        Quiero ofertar
                    </span>
                    <svg class="lg:size-8 size-7 lg:ml-15 ml-7">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </button>

                <div
                    class="lg:grid lg:grid-cols-3 grid-cols-1     w-6/6  mx-auto justify-between lg:pl-3 lg:pr-1 py-1 items-start lg:mt-5 mt-4 border-casa-black lg:text-xl text-sm gap-8 ">

                    <div class="flex flex-col   lg:px-4 mb-3">
                        <h3 class="font-bold lg:text-center text-start lg:mb-1 mb-0.5">Ingresá.</h3>
                        <p class="text-pretty lg:text-center text-start">Para poder ofertar necesitás abonar un seguro
                            reembolsable
                            de <b class="lg:text-[22px] text-base ">${{ $subasta->garantia }}</b>.
                            Si no comprás,
                            te lo
                            devolvemos.</p>
                    </div>
                    <div class="flex flex-col   lg:px-4 mb-3">
                        <h3 class="font-bold lg:text-center text-start lg:mb-1 mb-0.5">Ofertá.</h3>
                        <p class="text-pretty lg:text-center text-start">Si al terminar la subasta nadie más ofrece, el
                            producto es
                            tuyo.
                            Si alguien más ofertó al final de la subasta, tenés 2 min más para pujar.</p>
                    </div>
                    <div class="flex flex-col   lg:px-4">
                        <h3 class="font-bold lg:text-center text-start lg:mb-1 mb-0.5">No te muevas de tu casa.</h3>
                        <p class="text-pretty lg:text-center text-start">Todo es online: mirás, ofertás y pagás desde
                            donde estés.
                            Si ganás, coordinamos la entrega con vos.</p>
                    </div>




                </div>




                @if ($modalPago)
                    @livewire('modal-option-pago', ['subasta' => $subasta, 'adquirente' => $adquirente, 'from' => 'lotes'])
                @endif

            </article>

        @endif


        <div class="flex flex-wrap   lg:gap-12 gap-2 place-content-center justify-center max-w-8xl w-full ">


            @forelse ($lotes as $lote)
                <div
                    class=" bg-casa-base-2 bas flex flex-col lg:p-6 p-2 gap-y-1 lg:border border-casa-black lg:w-[394px]  lg:min-w-[300px] min-w-[44%] relative max-w-[48%]">

                    <div class="flex justify-between items-center sm:order-1 order-2">

                        {{-- <p class="font-bold sm:text-3xl text-sm w-full  mr-3 line-clamp-1">{{ $lote['titulo'] }}</p> --}}

                        <x-clamp :text="$lote['titulo']" bclass="z-2 mr-1" mas="absolute -bottom-2 -right-2 md:right-0 " />

                        @if ($lote['tienePujas'])
                            <x-hammer />
                        @else
                            <x-hammer-fix />
                        @endif

                    </div>

                    <div class="flex gap-x-4 justify-center my-2 sm:order-2 order-1">

                        <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote['foto']) }}"
                            class="md:size-49 size-20  " />

                    </div>


                    <p class="text-xl mb-2 sm:block hidden sm:order-3">{{ $lote['descripcion'] }}. </p>

                    @php
                        $signo;
                    @endphp
                    <p class="sm:text-xl text-sm  mt-auto sm:order-4 order-3">Base:
                        {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['precio_base'] }}</p>

                    <p class="sm:text-xl text-sm font-semibold sm:mb-3 sm:order-5 order-4">
                        <span class="sm:inline-block hidden ">Oferta actual: </span>
                        <span class="sm:hidden ">Actual: </span>
                        {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['puja_actual'] ?? 0 }}
                    </p>



                    <a href="{{ route('lotes.show', $lote['id']) }}" class="absolute inset-0 sm:hidden z-10"></a>

                    <a href="{{ route('lotes.show', $lote['id']) }}"
                        class="hover:text-casa-black bg-casa-black text-casa-base  hover:bg-casa-base  border border-black rounded-full px-4 sm:flex items-center justify-between  py-2  w-full  text-xl font-bold mb-2  hidden  order-6">
                        <span class="sm:inline-block hidden">Ver detalle</span>
                        <svg class="size-[26px] ">
                            <use xlink:href="#arrow-right1"></use>
                        </svg>
                    </a>






                </div>
            @empty


                <div
                    class="flex bg-casa-black justify-center items-center md:text-4xl text-2xl font-bold text-casa-base-2  py-18 md:px-40 px-10 col-span-3">
                    <p>¡Sin lotes en esta subasta!</p>
                </div>
            @endforelse

            @if ($hasMore)
                <div class="text-center mt-8 w-full  px-4">
                    <button wire:click="loadMore"
                        class="bg-casa-base-2 text-casa-black rounded-3xl md:px-30 py-2 font-bold w-full md:w-fit  border border-casa-black md:text-lg text-sm hover:bg-casa-base">
                        Cargar más
                    </button>
                </div>
            @endif




        </div>



        {{-- @else
            <div class="mt-5">
                <x-registrate />
            </div>

            
            @livewire('destacados', ['subasta_id' => 5])

        @endif --}}
    @endif




</div>
