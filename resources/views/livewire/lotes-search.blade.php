<div class="flex flex-col justify-center items-center hvh w-full  pt-0  text-casa-black">


    <div class="mt-5">

        {{-- @livewire('buscador', ['subasta_id' => $subasta->id, 'search' => $search]) --}}
        @livewire('buscador', ['subasta_id' => 1, 'search' => $search, 'view' => true])

    </div>

    {{-- @dump($te) --}}


    {{-- @role('adquirente') --}}
    @if (auth()->user())
        @if (auth()->user()?->adquirente?->estado_id == 1 ||
                auth()->user()?->adquirente?->garantia($subasta->id) ||
                !auth()->user()?->hasRole('adquirente'))



            {{-- <divfset
                class="grid [grid-template-columns:repeat(auto-fit,minmax(394px,1fr))] max-w-[1440px]  px-20 mt-10 gap-12 place-content-center justify-center"> --}}

            {{-- <div class="grid grid-cols-3 px-20 mt-10 gap-12 place-content-center justify-center"> --}}

            <div class=" bg-casa-black flex  border rounded-full  w-2xl  mx-auto  pl-3 pr-1 py-0.5 items-center mt-5 border-casa-black col-span-3 {{ $existFrom ? 'justify-between' : 'justify-center' }} "
                wire:show="filtered">
                {{-- @dump($existFrom) --}}
                <p class="text-nowrap text-casa-base-2 ml-2">Resultados: <span class="ml-1">{{ $filtered }}</span>
                </p>


                @if ($existFrom)
                    <a href="{{ route($from) }}"
                        class="bg-casa-base-2 hover:bg-casa-black-h hover:text-casa-base border border-casa-base  text-casa-black rounded-full px-4 flex items-center justify-between  py-0.5 w-fit">
                        Volver a {{ $from }}
                        <span class="text-xl leading-0 ml-8">X</span>
                    </a>
                @endif

            </div>


            {{-- <div class="flex bg-casa-black justify-center items-center text-4xl font-bold text-casa-base-2  py-8 px-40 col-span-3 "
                wire:show="noSearch"> --}}
            <div class=" bg-casa-black flex  border rounded-full  w-fit  mx-auto justify-center  py-1 items-center mt-5 border-casa-black col-span-3 text-casa-base-2  px-14 text-lg"
                wire:show="noSearch">
                <button wire:click="$set('noSearch',false)">¡Sin resultados para <b>"{{ $search }}"</b>! <span
                        class="text-xl leading-0 ml-8 cursor-pointer">X</span></button>

            </div>

            <div class="flex flex-wrap x-20 mt-10 gap-12 place-content-center justify-center max-w-[1440px]">






                {{-- @if (isset($lotes) && count($lotes)) --}}
                {{-- @if (isset($lotes) && count($lotes)) --}}
                {{-- @foreach ($lotes as $lote) --}}


                @forelse ($lotes as $lote)
                    <div
                        class=" bg-casa-base-2 bas flex flex-col p-6 gap-y-1 border border-casa-black w-[394px]  min-w-[300px]">

                        <div class="flex justify-between items-center">
                            <p class="font-bold text-3xl w-full  mr-3">{{ $lote['titulo'] }}</p>

                            @if ($lote['tipo'] == 'activo')
                                @if ($lote['puja_actual'] > 0)
                                    <x-hammer />
                                @else
                                    <x-hammer-fix />
                                @endif
                            @endif

                        </div>

                        <div class="flex gap-x-4 justify-center my-2">

                            {{-- <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1) }}" class="size-36 obje " /> --}}
                            <img src="{{ Storage::url('imagenes/lotes/normal/' . $lote['foto1']) }}"
                                class="size-49  obje " />

                        </div>


                        <p class="text-xl mb-2">{{ $lote['descripcion'] }}. </p>



                        @php
                            $signo;
                        @endphp
                        <p class="text-xl  mt-auto">Base:
                            {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['base'] }}</p>
                        <p class="text-xl font-semibold mb-3">Oferta
                            actual:
                            {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['puja_actual'] ?? 0 }}</p>



                        {{-- @dump($lote['id']) --}}
                        {{-- @dump($lote['lote_id']) --}}

                        {{-- <a href="{{ route('lotes.show', $lote['lote_id']) }}" --}}
                        <a href="{{ route('lotes.show', $lote['lote_id']) }}"
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
                {{-- @else --}}
                {{-- @endif --}}

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
