<x-layouts.guest>


    <div class="flex flex-col justify-center items-center bg-gry-400 h-full  relative">


        {{-- 
        <svg class="w-[701px] h-42  mt-20 lg:block  hidden">
            <use xlink:href="#real"></use>
        </svg> --}}
        {{-- 
        <svg class="w-[273px] h-35  mt-20 lg:hidden block">
            <use xlink:href="#real-mb"></use>
        </svg> --}}



        {{-- Poner un div para el carrutsel aqui y otra en "cada objero tiene una hjostio " --}}
        {{-- <div class="flex flex-col bg-red-500 p-2 w-full justify-center swiper-home-pc  ">
            <div class="swiper-wrapper  items-center  bg-yellow-200 md:absolute bottom-4">

                @foreach (range(1, 8) as $i)
                    <div class="swiper-slide h-18 g-blue-500">
                        <img src="{{ asset("home/home$i.png") }}" class="h-18 bg-rd-300 mx-auto" />
                    </div>
                @endforeach
            </div>

            <x-fancy-heading text="S{u}bast{a}s o{n}line " variant="italic mx-[0.5px] font-normal text-black"
                class=" md:text-8xl text-4xl    text-center text-wrap font-normal md:-mb-10 -mb-4 text-black md:mt-20  mt-8" />
            <x-fancy-heading text="par{a} gent{e} re{a}l." variant="italic mx-[0.5px] font-normal text-black"
                class=" md:text-8xl  text-4xl  text-center text-wrap font-normal mb-4 text-black" />

        </div>

        <div class="swiper-home-mb     w-full  overflow-x-hidden lg:px-0 px-4 md:hidden">

            <div class="swiper-wrapper  flex  items-center">

                @foreach (range(1, 8) as $i)
                    <div class="swiper-slide h-18 g-blue-500">
                        <img src="{{ asset("home/home$i.png") }}" class="h-18 bg-rd-300 mx-auto" />
                    </div>
                @endforeach
            </div>
        </div>





        <h2 class="lg:text-3xl text-xl  font-bold md:mt-15 mt-12 self-start  md:self-auto ml-6 md:ml-0">Cada objeto
            tiene una
            historia.</h2>
        <h2 class="lg:text-3xl text-xl  font-bold  self-start  md:self-auto  ml-6 md:ml-0">Encontra la tuya.</h2> --}}


        <section class="relative w-full overflow-hidden md:pt-10 pt-6 g-[#fbfbfb] bg-bue-300 lg:pb-24 pb-10">

            <!-- ========================================== -->
            <!--  1. CAROUSEL PC (Detrás del texto)         -->
            <!--  Hidden en mobile, Block en MD, Absolute   -->
            <!-- ========================================== -->
            <div
                class="hidden md:block absolute inset-0 z-0 h-40 w-[98%] swiper-home-pc translate-y-20 pointer-events-none bg-gren-300 mx-auto overflow-hidden">
                <div class="swiper-wrapper flex items-center h-full ease-linear ">
                    {{-- Hacemos el loop 3 veces para tener 24 slides y evitar huecos --}}
                    @for ($x = 0; $x < 3; $x++)
                        @foreach (range(1, 8) as $i)
                            <div class="swiper-slide flex justify-center items-center h-full w-fit bgcyan-950">
                                {{-- Ajusta la opacidad (opacity-50) si quieres que el texto resalte más --}}
                                <img src="{{ asset("home/home$i.png") }}"
                                    class="md:h-40 object-contain mx-auto opacity-80 bg-ink-400" alt="Objeto vintage" />
                            </div>
                        @endforeach
                    @endfor
                </div>
            </div>

            <!-- ========================================== -->
            <!--  2. CONTENIDO TEXTO (Encima del Carousel)  -->
            <!--  Relative y z-10 para flotar sobre imgs    -->
            <!-- ========================================== -->
            <div class="relative -10 flex flex-col items-center justify-center w-full px-4 bg-rd-500 md:mt-8">

                <!-- Título Principal -->
                <div class="text-center mb-8 md:mb-12 relative w-fll bg-yelow-200 px-0 overflow-hidden">

                    <div class="bg-oange-500 w-fit mx-auto bg-casa-base md:px-4">


                        <x-fancy-heading text="S{u}bast{a}s o{n}line "
                            variant="italic mx-[0.5px] font-normal text-black"
                            class="md:text-8xl text-4xl text-center text-wrap font-normal md:-mb-6 -mb-2 text-black md:!leading-[65px] !leading-[28px]" />
                        <x-fancy-heading text="par{a} gent{e} re{a}l."
                            variant="italic mx-[0.5px] font-normal text-black "
                            class="md:text-8xl text-4xl text-center text-wrap font-normal text-black bg-red200 " />
                    </div>

                </div>

                <!-- ========================================== -->
                <!--  3. CAROUSEL MÓVIL (Entre los textos)      -->
                <!--  Visible solo en mobile (md:hidden)        -->
                <!-- ========================================== -->
                <div class="md:hidden w-full mb-8 swiper-home-mb">
                    <div class="swiper-wrapper">
                        @foreach (range(1, 8) as $i)
                            <div class="swiper-slide">
                                <img src="{{ asset("home/home$i.png") }}" class="h-24 mx-auto object-contain" />
                            </div>
                        @endforeach
                    </div>
                </div>




                <!-- Subtítulo -->
                <div class="text-center md:mt-10 relative w-full">

                    <div
                        class="hidden md:block  inset-0 z-0 h-32 w-[90%] swiper-home-pc-2 translate-y- pointer-events-none bg-geen-300 mx-auto overflow-hidden bgyellow-500 ">
                        <div class="swiper-wrapper flex items-center h-full ease-linear  bg-green600">
                            @php
                                $ordenAlternativo = array_merge(range(4, 8), range(1, 3));
                                // Esto genera: [4, 5, 6, 7, 8, 1, 2, 3]
                            @endphp

                            {{-- 2. Mantenemos el bucle externo para la repetición infinita --}}
                            @for ($x = 0; $x < 3; $x++)

                                {{-- 3. Iteramos sobre el array desordenado --}}
                                @foreach ($ordenAlternativo as $i)
                                    <div class="swiper-slide flex justify-center items-center h-full  bg-red-40 ax-40">
                                        <img src="{{ asset("home/home$i.png") }}"
                                            class="md:h-32 object-contain mx-auto opacity-80" alt="Objeto vintage" />
                                    </div>
                                @endforeach

                            @endfor
                        </div>
                    </div>

                    <div
                        class="bg-reen-600 w-full  mx-auto  z-50 md:h-32 md:-translate-y-6 md:absolute md:top-6  plae-self-center">
                        {{-- 
                    <div
                        class="bg-reen-600 w-fit mx-auto  z-50 md:h-32 md:-translate-y-6 md:absolute md:top-6  border border-green-500  place-self-center px-20 bg-[linear-gradient(to_right,transparent_0%,rgba(246,242,238,0.5)_10%,rgb(246,242,238)_50%,rgba(246,242,238,0.5)_90%,transparent_100%)]
                        "> --}}




                        <div class="md:h-32 w-fit md:mx-auto bg-ed-400 md:pt-5  md:px-2   bg-casa-base">

                            <h2 class="lg:text-3xl text-xl font-bold z-50 bg-red300 w-fit md:mx-auto md:mb-2">
                                Cada objeto tiene una historia.
                            </h2>
                            <h2 class="lg:text-3xl text-xl font-bold bg-yellow-00 w-fit md:mx-auto">
                                Encontrá la tuya.
                            </h2>

                        </div>
                    </div>


                </div>
            </div>

        </section>

        <div class="w-full   bg-cyan-95">
            @livewire('subastas-abiertas')
        </div>

        <div class=" lg:w-4/5 w-full  b-yellow-500 lg:pb-24 pb-10">
            @livewire('buscador', ['todas' => true, 'from' => 'home'])
        </div>



        @if ($last)
            <div class="lg:pb-24 pb-10  lg:px-24 px-4 overflow-x-hidden  w-full b-blue-300">

                @livewire('destacados', ['subasta_id' => $last->id, 'titulo' => true, 'from' => 'home'])
            </div>
        @endif


        @if (count($subastasProx))
            <div class="flex flex-col   w-full   items-center lg:pb-24   pb-10 lg:px-24 b-green-400  ">
                {{-- <p class="lg:text-3xl  text-lg font-bold lg:text-center   text-start w-full px-4 mb-4 lg:mb-8">
                    subastas próximas
                </p> --}}
                <x-fancy-heading text="s{u}bast{a}s p{r}óxim{a}s" variant="italic mx-[0.5px] font-normal"
                    class=" md:text-[32px] text-[20px]  text-center self-start md:self-center md:ml-0 ml-6  text-wrap font-normal  mb-4" />

                <div class="swiper-home-subastas     w-full  lg:overflow-x-hidden lg:px-0 px-4">

                    <div class="swiper-wrapper  flex lg:flex-row flex-col">
                        @foreach ($subastasProx as $item)
                            <a href="{{ route('subasta-proximas.lotes', $item->id) }}"
                                class="flex flex-col bg-casa-black text-casa-base-2 lg:p-6 p-4 mb-6 swiper-slide ">


                                <div class="flex justify-between items-center lg:mb-4 mb-2">

                                    <p class="text-[26px]  lg:text-[40px] font-caslon leading-[40px] ">
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




                                <p class="text-xl line-clamp-3">{{ $item->descripcion }}</p>



                                @if ($item->desc_extra)
                                    <x-modal-desc-extra-home :titulo="$item->titulo" :desc="$item->desc_extra" :route="route('subasta-proximas.lotes', $item->id)" />
                                @endif



                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        @endif


        @if (count($subastasFin))
            <div class="flex flex-col   w-full   items-center lg:pb-24 pb-10 lg:px-24   bg-rd-100">
                {{-- <p class="lg:text-3xl  text-lg font-bold lg:text-center   text-start w-full px-4 mb-4 lg:mb-8">subastas
                    pasadas</p> --}}

                <x-fancy-heading text="s{u}bast{a}s p{a}sa{d}as" variant="italic mx-[0.5px] font-normal"
                    class=" md:text-[32px] text-[20px]  text-center self-start md:self-center md:ml-0 ml-6  text-wrap font-normal  mb-4" />

                <div class="swiper-home-subastas     w-full  lg:overflow-x-hidden lg:px-0 px-4 ">

                    <div class="swiper-wrapper  flex lg:flex-row flex-col  ">

                        @foreach ($subastasFin as $item)
                            <a href="{{ route('subasta-pasadas.lotes', $item->id) }}"
                                class="flex flex-col bg-casa-base-2 text-casa-black p-6 mb-6 swiper-slide border border-casa-black/50 ">



                                <div class="flex justify-between items-center lg:mb-4 mb-2">

                                    <p class="text-2xl  lg:text-[40px] font-caslon leading-[40px]">
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



                                <p class="text-xl line-clamp-3">{{ $item->descripcion }}</p>


                                @if ($item->desc_extra)
                                    <x-modal-desc-extra-home :titulo="$item->titulo" :desc="$item->desc_extra" :route="route('subasta-pasadas.lotes', $item->id)" />
                                @endif



                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        @endif



        @guest
            <x-primera-vez />
        @endguest



    </div>

</x-layouts.guest>
