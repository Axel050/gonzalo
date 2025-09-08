<x-layouts.guest>


    <div class="flex flex-col justify-center items-center bg-gry-400 h-full ">



        <svg class="w-[701px] h-42  mt-20">
            <use xlink:href="#real"></use>
        </svg>

        <h2 class="text-3xl font-bold mt-15">Cada objeto tiene una historia.</h2>
        <h3 class="text-3xl font-bold">Encontra la tuya.</h3>

        @livewire('subastas-abiertas')

        <div class="mt-0 bg-red-00 w-4/5">
            @livewire('buscador', ['todas' => true, 'from' => 'home'])
        </div>



        @if ($last)
            @livewire('destacados', ['subasta_id' => $last->id, 'titulo' => true])
        @endif


        @if (count($subastasProx))
            <div class="flex flex-col   w-full items-center lg:p-24 brder-1 border-accent mt-  b-purple-500">
                <p class="text-3xl font-bold ">próximas subastas</p>

                <div class="swiper-home-subastas hiden  x-20  w-full g-red-300  bg-ed-300 overflow-x-hidden">

                    <div class="swiper-wrapper  bg-orange-00 ">
                        @foreach ($subastasProx as $item)
                            <a href="{{ route('subasta-proximas.lotes', $item->id) }}"
                                class="flex flex-col bg-casa-black text-casa-base-2 p-6 mt-8 swiper-slide">



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


                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        @endif


        @if (count($subastasFin))
            <div class="flex flex-col   w-full items-center lg:p-24 brder-1 border-accent mt-  g-purple-500">
                <p class="text-3xl font-bold ">subastas pasadas</p>

                <div class="swiper-home-subastas hiden  x-20  w-full g-red-300  bg-ed-300 overflow-x-hidden">

                    <div class="swiper-wrapper  bg-orange-00 ">
                        @foreach ($subastasFin as $item)
                            <a href="{{ route('subasta-pasadas.lotes', $item->id) }}"
                                class="flex flex-col bg-casa-black text-casa-base-2 p-6 mt-8 swiper-slide">



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


                            </a>
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

            <a href=""
                class=" bg-casa-black rounded-4xl flex  items-center px-4 py-1 mx-auto text-casa-base mt-8 text-xl font-bold ">
                Registrarme
                <svg fill="#fff" class="size-7  ml-6 shrink-0 self-start">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </a>
        </div>



    </div>

</x-layouts.guest>
