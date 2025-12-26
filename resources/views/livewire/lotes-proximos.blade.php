<div class="flex flex-col justify-center items-center  w-full    text-casa-black md:gap-y-24 gap-y-16 pt-12">


    <div class="  w-full  [&>article]:max-w-5xl flex flex-col gap-y-4">
        {{-- @livewire('buscador', ['subasta_id' => $subasta->id, 'search' => $search]) --}}
        <livewire:buscador :subasta="$subasta" :subasta_id="$subasta->id" :search="$search" />

        <x-search-message :search="$search" />

    </div>



    {{-- MODAL  --}}
    <div class="fixed  inset-0 flex  justify-center items-center  z-50 animate-fade-in-scale" wire:show="modal">
        <div class="absolute inset-0  bg-gray-600/70 backdrop-blur-xs transition-opacity duration-300"
            wire:click="continuar">
        </div>
        <article
            class=" flex idden  md:w-auto w-[90%]  md:justify-center justify-start flex-col md:mt-10 mt-6 mb-8 mx-auto md:px-30 md:py-12 px-6 py-10  bg-casa-fondo-h border border-casa-black z-50 h-fit">
            <h2 class=" font-bold lgtext-5xl  text-2xl text-center  mb-8">¡¡¡Comenzó la subasta!!!</h2>
            <div
                class="flex md:flex-row flex-col md:gap-20 gap-3 md:w-fit w-full md:justify-center mx-auto items-center md:mt-5 mt-3">
                <button
                    class="bg-casa-black hover:bg-casa-base-2 hover:text-casa-black border hover:border-casa-black text-casa-base  rounded-full px-4 flex items-center justify-between  md:py-0.5 py-1 col-span-3 mx-auto  md:text-xl font-semibold text-sm md:w-fit lg w-full h-fit"
                    wire:click="continuar">
                    Continuar
                    <svg class="md:size-8 size-5 ml-15">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </button>
            </div>
        </article>
    </div>

    {{--  --}}

    {{-- @role('adquirente') --}}
    @if (auth()->user())
        {{-- @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia($subasta->id) || !auth()->user()?->hasRole('adquirente')) --}}





        <div
            class="flex flex-wrap   md:gap-12 gap-2 place-content-center justify-center max-w-[1440px]  w-full px-2 md:px-0">


            {{-- @if ($lotes) --}}


            @forelse ($lotes as $lote)
                <div
                    class=" bg-casa-base-2 bas flex flex-col md:p-6  p-2 gap-y-1 md:border border-casa-black md:w-[394px]  md:min-w-[300px] min-w-[44%] relative max-w-[48%] w-full">

                    <x-clamp :text="$lote['titulo']" bclass=" ml-1  z-20" mas="absolute -bottom-2 -right-3 md:right-0 "
                        menos="absolute right-2 md:top-1/2 top-full " />


                    <div class="flex gap-x-4 justify-center my-2 md:order-2 order-1">

                        <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote['foto']) }}"
                            class="md:size-49 size-20 " />
                    </div>


                    <p class="text-xl mb-2 md:block hidden md:order-3">{{ $lote['descripcion'] }}. </p>


                    <p class="md:text-xl text-sm  mt-auto md:order-4 order-3">Base:
                        {{ $this->getMonedaSigno($lote['moneda_id']) }}{{ $lote['precio_base'] }}</p>




                    <a href="{{ route('lotes.show', $lote['id']) }}" class="absolute inset-0 md:hidden z-10"></a>

                    <a href="{{ route('lotes.show', $lote['id']) }}"
                        class="hover:text-casa-black bg-casa-black text-casa-base  hover:bg-casa-base  border border-black rounded-full px-4 md:flex items-center justify-between  py-2  w-full  text-xl font-bold mb-2  hidden  order-6">
                        <span class="md:inline-block hidden">Ver detalle</span>
                        <svg class="size-[26px] ">
                            <use xlink:href="#arrow-right1"></use>
                        </svg>
                    </a>





                </div>
            @empty


                <div
                    class="flex bg-casa-black justify-center items-center md:text-4xl text-2xl font-bold text-casa-base-2  py-18 md:px-40 px-6 col-span-3">
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
    @endif
    {{-- @endrole --}}




</div>
