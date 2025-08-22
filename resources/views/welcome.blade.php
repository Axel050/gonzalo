<x-layouts.guest>

    <div class="flex flex-col justify-center items-center bg-gry-400 h-full ">

        <x-counter-header />

        <svg class="w-[701px] h-42  mt-20">
            <use xlink:href="#real"></use>
        </svg>

        <h2 class="text-3xl font-bold mt-15">Cada objeto tiene una historia.</h2>
        <h3 class="text-3xl font-bold">Encontra la tuya.</h3>


        @if (count($subastasAct))

            {{-- class="swiper-home-subastas hiden    w-full g-red-300  bg-red-300 overflowx-hidden flex justify-center pl-[50px]"> --}}
            <div class="flex flex-col   w-full items-center p-24 rder-1 border-accent mt-8   g-blue-500 ">
                <p class="text-3xl font-bold  ">subastas abiertas</p>

                <div
                    class="swiper-home-subastas hiden    w-full g-red-300  g-red-300 overflow-x-hidden flex justify-center ">

                    <div class="swiper-wrapper      g-blue-300  ">
                        @foreach ($subastasAct as $subA)
                            <a href="{{ route('subasta.lotes', $subA->id) }}"
                                class="flex flex-col  -h p-6 mt-8 swiper-slide border-1 border-casa-black">

                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-[40px] font-librecaslon leading-[40px]">{{ $subA->titulo }} </p>
                                    <svg fill="#fff" class="size-8  ml-8 shrink-0 self-start">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg>
                                </div>

                                <div class="flex flex-col">
                                    <p>Hasta el</p>
                                    <p class="font-bold"> 25 AGO | 21hs</p>
                                </div>

                                <p class="text-xl">Lorem ipsum dolor sit amet consectetur. Vehicula adipiscing
                                    pellentesque volutpat dui rhoncus neque urna. Sem et praesent gravida tortor proin
                                    massa iaculis. </p>
                            </a>
                        @endforeach

                    </div>
                </div>

            </div>
        @endif

        {{--  --}}

        <div class="flex flex-col   w-full items-center px-24 pt-0 brder-1 border-accent mt-   g-red-500 ">

            <h2 class="text-[40px] font-librecaslon text-center mb-4 ">objetos</h2>
            <div class="swiper-home-subastas hiden w-full  mt- overflow-x-hidden flex  justify-center ">
                <div class="swiper-wrapper">

                    @for ($i = 0; $i < 5; $i++)
                        <div
                            class=" bg-casa-base-2 flex flex-col px-4 py-8 gap-y-4 border border-casa-black swiper-slide">

                            <div class="flex gap-x-4">

                                <img src="{{ Storage::url('imagenes/lotes/thumbnail/img_1_68a37512b7bfa.png') }}"
                                    class="size-36 obje " />


                                <div class="flex flex-col bg-purple grow">

                                    <div class="flex items-center  mb-3">
                                        <p class="font-semibold text-xl w-full  ">Nombre de lote {{ $i }}</p>
                                        <x-hammer />
                                    </div>

                                    <p class="text-xl">Base: $1000</p>
                                    <p class="text-xl font-semibold">Oferta actual: $12.000</p>
                                </div>
                            </div>

                            <div class="flex w-full g-green-300 justify-center px-8 items-center mt-4">
                                <span
                                    class="text-4xl border rounded-full size-8 flex items-center pt-0 leading-0 p-2 justify-center border-gray-900">
                                    +
                                </span>
                                <button
                                    class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between gap-x-5 py-1  w-full ml-4">
                                    Agregar al carrito
                                    <svg class="size-8 ">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg>
                                </button>
                            </div>

                        </div>
                    @endfor



                </div>
            </div>
        </div>
        {{--  --}}




        @if (count($subastasProx))
            <div class="flex flex-col   w-full items-center lg:p-24 brder-1 border-accent mt-  g-purple-500">
                <p class="text-3xl font-bold ">próximas subastas</p>

                <div class="swiper-home-subastas hiden  x-20  w-full g-red-300  bg-ed-300 overflow-x-hidden">

                    <div class="swiper-wrapper  bg-orange-00 ">
                        @foreach ($subastasProx as $item)
                            <div class="flex flex-col bg-casa-black text-casa-base-2 p-6 mt-8 swiper-slide">



                                <div class="flex justify-between items-center mb-4">

                                    <p class="text-2xl  lg:text-[40px] font-librecaslon leading-[40px]">
                                        {{ $item->titulo }}
                                    </p>

                                    <svg fill="#fff" class="size-8  ml-8 self-start flex-shrink-0">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg>

                                </div>


                                @php
                                    $fechaIni = \Carbon\Carbon::parse($item->fecha_inicio);
                                    $diaIni = $fechaIni->translatedFormat('d'); // 06
                                    $mesIni = Str::upper($fechaIni->translatedFormat('M')); // AGO
                                    $horaIni = $fechaIni->format('H'); // 11

                                    $fechaFin = \Carbon\Carbon::parse($item->fecha_fin);
                                    $diaFin = $fechaFin->translatedFormat('d'); // 06
                                    $mesFin = Str::upper($fechaFin->translatedFormat('M')); // AGO
                                    $horaFin = $fechaFin->format('H'); // 11

                                @endphp

                                {{-- <p class="mb-2 text-xl ">Abierta hasta el
                                    <b></b>
                                </p> --}}

                                <div class="flex justify-between">

                                    <div class="flex flex-col mb-1.5">
                                        <p>Desde el</p>
                                        <p class="font-bold"> {{ $diaIni }} de {{ $mesIni }} |
                                            {{ $horaIni }}hs</p>

                                    </div>

                                    <div class="flex flex-col">
                                        <p>Hasta el</p>
                                        <p class="font-bold">{{ $diaFin }} de {{ $mesFin }} |
                                            {{ $horaFin }}hs</p>

                                    </div>

                                </div>



                                <p class="text-xl">Lorem ipsum dolor sit amet consectetur. Vehicula adipiscing
                                    pellentesque
                                    volutpat dui
                                    rhoncus neque
                                    urna. Sem et praesent gravida tortor proin massa iaculis. </p>


                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        @endif




        <div class="flex flex-col bg-casa-base-2 w-full items-center p-24 border-y-1 border-accent mt-8 ">
            <svg class="w-120 h-30 ">
                <use xlink:href="#primera-vez"></use>
            </svg>

            <p class="text-3xl font-bold mt-7">Así funciona: </p>

            <p class="text-xl font-bold mt-7">Ingresá:</p>
            <p class="text-xl  mt-1">Para poder ofertar necesitás abonar un seguro reembolsable.</p>
            <p class="text-xl  ">Si no comprás, te lo devolvemos.</p>

            <p class="text-xl font-bold mt-7">Ofertá: </p>
            <p class="text-xl  mt-1">Si al terminar la subasta nadie más ofrece, el producto es tuyo.</p>
            <p class="text-xl  ">Si alguien más ofertó al final de la subasta, ténes 2 minutos más para pujar.
            </p>

            <p class="text-xl font-bold mt-7">No te muevas de tu casa: </p>
            <p class="text-xl  mt-1">Todo es online: mirás, ofertás y pagás desde donde estés.</p>
            <p class="text-xl  ">Si ganás, coordinamos la entrega con vos</p>
        </div>



    </div>

</x-layouts.guest>
