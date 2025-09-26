<div class="flex flex-col justify-center items-center hvh w-full  pt-0  text-casa-black">

    <div class="mt-10">
        @livewire('buscador', ['subasta_id' => $subasta->id, 'search' => $search])
    </div>


    {{-- @role('adquirente') --}}
    @if (auth()->user())
        @if (auth()->user()?->adquirente?->estado_id == 1 ||
                auth()->user()?->adquirente?->garantia($subasta->id) ||
                !auth()->user()?->hasRole('adquirente'))


            <div class=" bg-casa-black flex  border rounded-full    mx-auto justify-between pl-3 pr-1 py-0.5 items-center mt-5 border-casa-black col-span-3"
                wire:show="filtered">

                <p class="text-nowrap text-casa-base-2 ml-2">Resultados: <span class="ml-1">{{ $filtered }}</span>
                </p>


                <button wire:click="todos"
                    class="bg-casa-base-2 hover:bg-casa-black-h hover:text-casa-base border border-casa-base  text-casa-black rounded-full px-4 flex items-center justify-between  py-0.5 w-fit sm:ml-20 ml-4">
                    Ver todos los lotes
                    <span class="text-xl leading-0 ml-8">X</span>
                </button>
            </div>


            <div class=" bg-casa-black flex  border rounded-full  w-fit  mx-auto justify-center  py-2 items-center mt-5 border-casa-black col-span-3 text-casa-base-2  sm:px-20 px-5 sm:text-xl text-lg"
                wire:show="noSearch">
                <button wire:click="$set('noSearch',false)">¡Sin resultados para <b>"{{ $search }}"</b>! <span
                        class="text-xl leading-0 ml-8 cursor-pointer">X</span></button>

            </div>

            <div
                class="flex flex-wrap  mt-10 sm:gap-8 md:gap-10 lg:gap-12  gap-2 place-content-center justify-center max-w-[1440px]">




                @forelse ($lotes as $lote)
                    <div
                        class=" bg-casa-base-2 bas flex flex-col sm:p-6 p-2 gap-y-1 sm:border border-casa-black sm:w-[394px]  sm:min-w-[350px] md:min-w-[380px] min-w-[44%] relative">

                        <div class="flex justify-between items-center sm:order-1 order-2">
                            <p class="font-bold sm:text-3xl text-sm w-full  mr-3">{{ $lote['titulo'] }}</p>

                            @if ($lote['tienePujas'])
                                <x-hammer />
                            @else
                                <x-hammer-fix />
                            @endif

                        </div>

                        <div class="flex gap-x-4 justify-center my-2 sm:order-2 order-1">

                            <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote['foto']) }}"
                                class="sm:size-49 size-20  " />

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
                            class="hover:text-casa-black bg-casa-black text-gray-50  hover:bg-casa-base  border border-black rounded-full px-4 sm:flex items-center justify-between  py-2  w-full  text-xl font-bold mb-2  hidden  order-6">
                            <span class="sm:inline-block hidden">Ver detalle</span>
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

            {{-- @livewire('destacados', ['subasta_id' => $subasta->id, 'route' => $route]) --}}
            @livewire('destacados', ['subasta_id' => 5])

        @endif
    @endif




</div>
