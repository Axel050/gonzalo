<div class="flex flex-col justify-center items-center  w-full    text-casa-black md:gap-y-24 gap-y-16 pt-12">





    <div class="  w-full  [&>article]:max-w-5xl flex flex-col gap-y-4">
        @livewire('buscador', ['subasta_id' => $subasta->id, 'search' => $search])
        <x-search-message :search="$search" />
    </div>


    {{-- @role('adquirente') --}}
    @if (auth()->user())
        {{-- @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia($subasta->id) || !auth()->user()?->hasRole('adquirente')) --}}






        <div
            class="flex flex-wrap   md:gap-12 gap-2 place-content-center justify-center max-w-[1440px]  w-full px-2 md:px-0">


            @forelse ($lotes as $lote)
                <div
                    class=" bg-casa-base-2 bas flex flex-col md:p-6 p-2 gap-y-1 md:border border-casa-black md:w-[394px]  md:min-w-[300px] min-w-[44%] w-full relative max-w-[48%]">

                    <x-clamp :text="$lote['titulo']" bclass="z-20" exp="-bottom-2 -right-2 md:right-0" />

                    <div class="flex gap-x-4 justify-center my-2 md:order-2 order-1">
                        <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote['foto']) }}"
                            class="md:size-49 size-20 " />
                    </div>


                    <p class="text-xl mb-2 md:block hidden md:order-3">{{ $lote['descripcion'] }}. </p>


                    <p class="md:text-xl text-sm  mt-auto md:order-4 order-3">Base:
                        {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['precio_base'] }}</p>



                    {{-- <a href="{{ route('lotes.show', $lote['id']) }}" class="absolute inset-0 md:hidden z-10"></a> --}}


                    @if ($lote['estado'] == 'vendido')
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
        @endif --}}
    @endif








</div>
