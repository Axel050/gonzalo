<div class="swiper-destacados  g-green-200 w-ful w-[90vw] overflow-hidden pr-1">

    @if ($titulo)
        <h2 class="text-[40px] font-librecaslon text-center mb-2">{{ $subasta->titulo }}</h2>
    @endif

    <div class="swiper-wrapper g-red-200  p-1 pr-0 ">


        @foreach ($destacados as $des)
            {{-- @for ($i = 0; $i < 1; $i++) --}}
            <div class=" bg-casa-base-2 flex flex-col px-4 py-8 gap-y-4 border border-casa-black swiper-slide">

                <div class="flex gap-x-4">

                    {{-- <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $des['foto']) }}" class="size-36 obje " /> --}}
                    <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $des['foto']) }}" class="size-36 obje " />
                    {{-- <img src="{{ Storage::url('imagenes/lotes/thumbnail/28282') }}" class="size-36 obje " /> --}}


                    <div class="flex flex-col bg-purple grow">

                        <div class="flex items-center  mb-3">
                            <p class="font-semibold text-xl w-full  ">{{ $des['titulo'] }} </p>
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
                            $moneda = $monedas->firstWhere('id', $des['moneda_id'])->signo;
                        @endphp
                        <p class="text-xl">Base: {{ $moneda }}{{ $des['precio_base'] }}</p>
                        {{-- <p class="text-xl">Base:111</p> --}}
                        {{-- <p class="text-xl font-semibold">Oferta actual:
                            2222</p> --}}
                        <p class="text-xl font-semibold">Oferta actual:
                            {{ $moneda }}{{ $des['puja_actual'] ?? 0 }}</p>
                    </div>
                </div>

                <div class="flex w-full g-green-300 justify-center px-8 items-center mt-4">
                    <span
                        class="text-4xl border rounded-full size-8 flex items-center pt-0 leading-0 p-2 justify-center border-gray-900">
                        +
                    </span>
                    {{-- <a href="" --}}
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
