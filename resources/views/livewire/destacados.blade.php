<div class="   md:px-16 xl:px-24  px-4 overflow-x-hidden  w-full g-blue-300 max-w-8x p-1 " wire:show="contador">

    <div class="swiper-destacados   overflow-x-hidden w-full   d:px-24 max-w-8xl mx-auto  pr-0.5" wire:ignore>

        {{-- <div class="flex flex-col   w-full   items-center lg:pb-24 lg:px-24 lg:mt-0  mt-10 "> --}}



        @if ($titulo)
            @if ($from == 'home')
                <x-fancy-heading text="l{o}te{s} d{e}st{a}ca{d}os" variant="italic mx-[0.5px] font-normal"
                    class=" md:text-[40px] text-[26px]  md:text-center text-start ml-4 md:ml-0 text-wrap font-normal mb-4" />

                {{-- Lotes destacados --}}
            @else
                <h2 class="lg:text-[40px] text-[26px] font-librecaslon w-full  lg:text-center text-start mb-2">
                    <span class="bg-red-400">
                        {{ $subasta->titulo }}
                    </span>
                </h2>
            @endif
        @endif





        <div class="swiper-wrapper">


            @foreach ($destacados as $des)
                {{-- @for ($i = 0; $i < 1; $i++) --}}
                <div
                    class=" bg-casa-base-2 flex flex-col lg:px-4   lg:py-8 px-2 py-2 gap-y-4 lg:border border-casa-black swiper-slide text-casa-black ">

                    <a href="{{ route('lotes.show', $des['id']) }}" class="absolute inset-0 l:hidden z-10"></a>

                    <div class="flex xl:flex-row flex-col gap-x-4 ">

                        {{-- <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $des['foto']) }}" class="size-36 obje " /> --}}
                        <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $des['foto']) }}"
                            class="md:h-34 xl:h-36 h-25 w-full mx-auto object-contain  xl:max-w-36 " />

                        {{-- <p class="font-semibold lg:text-xl text-sm  w-full  block lg:hidden ">{{ $des['titulo'] }} </p> --}}

                        {{-- <img src="{{ Storage::url('imagenes/lotes/thumbnail/28282') }}" class="size-36 obje " /> --}}


                        <div class="flex flex-col bg-purple grow">

                            <div class="flex lg:items-center  items-end  mb-3  justify-between ">
                                {{-- <p class="font-semibold lg:text-xl text-sm  w-full  lg:mt-0 mt-2  ">{{ $des['titulo'] }}
                            </p> --}}
                                <x-clamp :text="$des['titulo']" bclass=" mr-1 "
                                    mas="absolute -bottom-2.5 -right-2 md:right-0 "
                                    class="md:text-xl text-sm font-bold  " />
                                {{-- <p class="font-semibold text-xl w-full  ">8888 -{{ $i }}</p> --}}

                                {{-- <x-hammer /> --}}
                                @if ($des['estado_lote'] == 'en_subasta')
                                    @if ($des['tienePujas'])
                                        <x-hammer />
                                    @else
                                        <x-hammer-fix />
                                    @endif
                                @endif
                            </div>

                            @php
                                $moneda = $monedas->firstWhere('id', $des['moneda_id'])?->signo;
                            @endphp
                            <p class="lg:text-xl text-sm">Base: {{ $moneda }}{{ $des['precio_base'] }}</p>
                            <p class="lg:text-xl text-sm font-semibold lg:block hidden">Oferta actual:
                                {{ $moneda }}{{ $des['puja_actual'] ?? 0 }}</p>
                            <p class="lg:text-xl text-sm font-semibold lg:hidden block">Actual:
                                {{ $moneda }}{{ $des['puja_actual'] ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="lg:flex hidden  w-full  justify-center px-4 items-center mt-4">
                        {{-- <span
                        class="text-4xl border rounded-full size-8 flex items-center pt-0 leading-0 p-2 justify-center border-gray-900">
                        +
                    </span> --}}


                        <a href="{{ route('lotes.show', $des['id']) }}"
                            class="bg-casa-black hover:bg-casa-black-h text-casa-base rounded-full px-4 flex items-center justify-between gap-x-5 py-1  w-full  font-bold">
                            Ver detalle
                            <svg class="size-[26px] ">
                                <use xlink:href="#arrow-right1"></use>
                            </svg>
                        </a>

                    </div>

                </div>
            @endforeach
            {{-- @endfor --}}

        </div>

    </div>

</div>
