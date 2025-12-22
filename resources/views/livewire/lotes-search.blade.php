<div class="flex flex-col justify-center items-center hvh w-full    text-casa-black md:gap-y-24 gap-y-16 pt-12">


    <div>

        {{-- @livewire('buscador', ['subasta_id' => $subasta->id, 'search' => $search]) --}}
        @livewire('buscador', ['subasta_id' => 1, 'search' => $search, 'view' => true])

    </div>

    {{-- @dump($te) --}}


    {{-- @role('adquirente') --}}
    @if (auth()->user())
        {{-- @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia($subasta->id) || !auth()->user()?->hasRole('adquirente')) --}}



        {{-- <divfset
                class="grid [grid-template-columns:repeat(auto-fit,minmax(394px,1fr))] max-w-[1440px]  px-20 mt-10 gap-12 place-content-center justify-center"> --}}

        {{-- <div class="grid grid-cols-3 px-20 mt-10 gap-12 place-content-center justify-center"> --}}

        <div class=" bg-casa-black flex  border rounded-full  lg:w-2xl  w-[95%]  mx-auto pl-3 pr-1 py-0.5 items-center  border-casa-black  {{ $existFrom ? 'justify-between' : 'justify-center' }} "
            wire:show="filtered">
            {{-- @dump($existFrom) --}}
            <p class="text-nowrap text-casa-base-2 ml-2">Resultados: <span class="ml-1">{{ $filtered }}</span>
            </p>


            @if ($existFrom)
                <a href="{{ route($from) }}"
                    class="bg-casa-base-2 hover:bg-casa-black-h hover:text-casa-base border border-casa-base  text-casa-black rounded-full px-4 flex items-center justify-between  py-0.5 w-fit">
                    Volver a {{ $from }}
                    <span class="text-xl leading-0 lg:ml-8 ml-5">X</span>
                </a>
            @endif

        </div>


        {{-- <div class="flex bg-casa-black justify-center items-center text-4xl font-bold text-casa-base-2  py-8 px-40 col-span-3 "
                wire:show="noSearch"> --}}
        <div class=" bg-casa-black flex  border rounded-full  w-fit  mx-auto justify-center  py-1 items-center  border-casa-black col-span-3 text-casa-base-2  px-14 text-lg"
            wire:show="noSearch">
            <button wire:click="$set('noSearch',false)">¡Sin resultados para <b>"{{ $search }}"</b>! <span
                    class="text-xl leading-0 ml-8 cursor-pointer">X</span></button>

        </div>




        <div class="flex flex-wrap   lg:gap-12 gap-2 place-content-center justify-center max-w-[1440px]">


            {{-- @if (isset($lotes) && count($lotes)) --}}
            {{-- @if (isset($lotes) && count($lotes)) --}}
            {{-- @foreach ($lotes as $lote) --}}


            @forelse ($lotes as $lote)
                <div
                    class=" bg-casa-base-2 bas flex flex-col lg:p-6 p-2 gap-y-1 lg:border border-casa-black lg:w-[394px]  lg:min-w-[300px] min-w-[44%] relative">

                    <div class="flex justify-between items-center ">

                        <p class="font-bold lg:text-3xl text-sm w-full  mr-3">{{ $lote['titulo'] }}</p>

                        @if ($lote['tipo'] == 'activo')
                            @if ($lote['puja_actual'] > 0)
                                <x-hammer />
                            @else
                                <x-hammer-fix />
                            @endif
                        @endif

                    </div>

                    <div class="flex gap-x-4 justify-center my-2">

                        <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote['foto1']) }}"
                            class="lg:size-49 size-20  " />

                    </div>


                    <p class="text-xl mb-2 lg:block hidden lg:order-3">{{ $lote['descripcion'] }}. </p>


                    {{-- @dump($lote['base']) --}}

                    @php
                        $signo;
                    @endphp
                    <p class="lg:text-xl text-sm  mt-auto lg:order-4 order-3">Base:
                        {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['base'] }}</p>

                    @if ($lote['tipo'] == 'activo')
                        <p class="lg:text-xl text-sm font-semibold lg:mb-3 lg:order-5 order-4">
                            <span class="lg:inline-block hidden ">Oferta actual: </span>
                            <span class="lg:hidden ">Actual: </span>
                            {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['puja_actual'] ?? 0 }}
                        </p>
                    @else
                        <p class="text-xl font-semibold h-3"></p>
                    @endif



                    <a href="{{ route('lotes.show', $lote['lote_id']) }}"
                        class="hover:text-casa-black bg-casa-black text-gray-50  hover:bg-casa-base  border border-black rounded-full px-4 lg:flex items-center justify-between  py-2  w-full  text-xl font-bold mb-2  hidden  order-6">
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
            {{-- @else --}}
            {{-- @endif --}}

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
