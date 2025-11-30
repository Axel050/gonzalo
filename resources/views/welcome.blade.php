<x-layouts.guest>


    <div class="flex flex-col justify-center items-center bg-gry-400 h-full ">



        <svg class="w-[701px] h-42  mt-20 lg:block  hidden">
            <use xlink:href="#real"></use>
        </svg>

        <svg class="w-[273px] h-35  mt-20 lg:hidden block">
            <use xlink:href="#real-mb"></use>
        </svg>

        <h2 class="lg:text-3xl text-lg  font-bold mt-15">Cada objeto tiene una historia.</h2>
        <h3 class="lg:text-3xl text-lg  font-bold">Encontra la tuya.</h3>

        <div class="w-full mt-15 mb-0">
            @livewire('subastas-abiertas')
        </div>

        <div class="mt-0 lg:w-4/5 w-full ">
            @livewire('buscador', ['todas' => true, 'from' => 'home'])
        </div>



        @if ($last)
            <div class="pb-16 pt-20 lg:px-24 overflow-x-hidden  w-full">

                @livewire('destacados', ['subasta_id' => $last->id, 'titulo' => true, 'from' => 'home'])
            </div>
        @endif


        @if (count($subastasProx))
            <div class="flex flex-col   w-full   items-center lg:pb-24 lg:px-24 lg:mt-0  mt-10 ">
                <p class="lg:text-3xl  text-lg font-bold lg:text-center   text-start w-full px-4 mb-4 lg:mb-8">
                    subastas próximas
                </p>

                <div class="swiper-home-subastas     w-full  lg:overflow-x-hidden lg:px-0 px-4">

                    <div class="swiper-wrapper  flex lg:flex-row flex-col">
                        @foreach ($subastasProx as $item)
                            <a href="{{ route('subasta-proximas.lotes', $item->id) }}"
                                class="flex flex-col bg-casa-black text-casa-base-2 lg:p-6 p-4 mb-6 swiper-slide">


                                <div class="flex justify-between items-center lg:mb-4 mb-2">

                                    <p class="text-[26px]  lg:text-[40px] font-librecaslon leading-[40px] ">
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

                                <div class="flex justify-between lg:text-xl text-sm">

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

                                <p class="lg:text-xl text-sm line-clamp-3">{{ $item->descripcion }} </p>

                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        @endif


        @if (count($subastasFin))
            <div class="flex flex-col   w-full   items-center lg:pb-24 lg:px-24 lg:mt-0  mt-10 ">
                <p class="lg:text-3xl  text-lg font-bold lg:text-center   text-start w-full px-4 mb-4 lg:mb-8">subastas
                    pasadas</p>

                <div class="swiper-home-subastas     w-full  lg:overflow-x-hidden lg:px-0 px-4 ">

                    <div class="swiper-wrapper  flex lg:flex-row flex-col  ">

                        @foreach ($subastasFin as $item)
                            <a href="{{ route('subasta-pasadas.lotes', $item->id) }}"
                                class="flex flex-col bg-casa-base-2 text-casa-black p-6 mb-6 swiper-slide border border-casa-black/50 ">



                                <div class="flex justify-between items-center lg:mb-4 mb-2">

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



                                <p class="text-xl line-clamp-3oxu">{{ $item->descripcion }}</p>


                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        @endif




        <div
            class="flex flex-col bg-casa-base-2 w-full lg:items-center lg:px-24 lg:py-24 px-4 py-11   border-y-1 border-accent mt-8 ">

            <svg class="w-120 h-30 lg:block hidden ">
                <use xlink:href="#primera-vez"></use>
            </svg>

            <h3 class="lg:hidden block text-[37px]  leading-[39px] font-sans ">
                ¿Primera vez en una subasta?
            </h3>

            <p class="lg:text-3xl text-lg font-bold lg:mt-7 mt-5">Así funciona: </p>

            <p class="lg:text-xl text-sm font-bold lg:mt-7 mt-6">Ingresá:</p>
            <p class="lg:text-xl text-sm  mt-1">Para poder ofertar necesitás abonar un seguro reembolsable.</p>
            <p class="lg:text-xl text-sm  ">Si no comprás, te lo devolvemos.</p>

            <p class="lg:text-xl text-sm font-bold lg:mt-7 mt-6">Ofertá: </p>
            <p class="lg:text-xl text-smtext-xl  mt-1">Si al terminar la subasta nadie más ofrece, el producto es tuyo.
            </p>
            <p class="lg:text-xl text-smtext-xl  ">Si alguien más ofertó al final de la subasta, ténes 2 minutos más
                para pujar.
            </p>

            <p class="lg:text-xl text-sm font-bold lg:mt-7 mt-6">No te muevas de tu casa: </p>
            <p class="lg:text-xl text-sm  mt-1">Todo es online: mirás, ofertás y pagás desde donde estés.</p>
            <p class="lg:text-xl text-sm  ">Si ganás, coordinamos la entrega con vos</p>

            <a href="{{ route('adquirentes.create') }}"
                class=" bg-casa-black rounded-4xl flex  items-center px-4 py-1 mx-auto text-casa-base mt-8 lg:text-xl text-sm font-bold  lg:w-fit w-full lg:justify-center justify-between">
                Registrarme
                <svg fill="#fff" class="size-7  ml-6 shrink-0 self-start">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </a>
        </div>



    </div>

</x-layouts.guest>
