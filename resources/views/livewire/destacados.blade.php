<div class="swiper-destacados   overflow-x-hidden w-full ">

    {{-- <div class="flex flex-col   w-full   items-center lg:pb-24 lg:px-24 lg:mt-0  mt-10 "> --}}


    @if ($titulo)
        <h2 class="lg:text-[40px] text-[26px] font-librecaslon w-full  lg:text-center text-start mb-2">
            @if ($from == 'home')
                Lotes destacados
            @else
                {{ $subasta->titulo }}
            @endif
        </h2>
    @endif




    <div class="swiper-wrapper ">


        @foreach ($destacados as $des)
            {{-- @for ($i = 0; $i < 1; $i++) --}}
            <div
                class=" bg-casa-base-2 flex flex-col lg:px-4 lg:py-8 px-2 py-2 gap-y-4 lg:border border-casa-black swiper-slide">

                <a href="{{ route('lotes.show', $des['id']) }}" class="absolute inset-0 lg:hidden z-10"></a>

                <div class="flex lg:flex-row flex-col gap-x-4 ">

                    {{-- <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $des['foto']) }}" class="size-36 obje " /> --}}
                    <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $des['foto']) }}" class="size-36 mx-auto" />

                    {{-- <p class="font-semibold lg:text-xl text-sm  w-full  block lg:hidden ">{{ $des['titulo'] }} </p> --}}

                    {{-- <img src="{{ Storage::url('imagenes/lotes/thumbnail/28282') }}" class="size-36 obje " /> --}}


                    <div class="flex flex-col bg-purple grow">

                        <div class="flex lg:items-center  items-end  mb-3 ">
                            <p class="font-semibold lg:text-xl text-sm  w-full  lg:mt-0 mt-2  ">{{ $des['titulo'] }}
                            </p>
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

                <div class="lg:flex hidden  w-full  justify-center px-8 items-center mt-4">
                    <span
                        class="text-4xl border rounded-full size-8 flex items-center pt-0 leading-0 p-2 justify-center border-gray-900">
                        +
                    </span>


                    <a href="{{ route('lotes.show', $des['id']) }}"
                        class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between gap-x-5 py-1  w-full ml-4">
                        Ver detalle
                        <svg class="size-8 ">
                            <use xlink:href="#arrow-right"></use>
                        </svg>
                    </a>

                </div>

            </div>
        @endforeach
        {{-- @endfor --}}

    </div>

</div>
