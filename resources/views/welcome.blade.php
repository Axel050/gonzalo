<x-layouts.guest>


    <div class="flex flex-col justify-center items-center bg-gry-400 h-full  relative md:gap-y-24 gap-y-16 ">




        <!-- Modal de verificación exitosa -->
        @if ($showVerifiedModal)
            <div x-data="{ open: true }" x-show="open" x-transition
                class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600/70 backdrop-blur-xs transition-opacity duration-300">


                <div class="bg-casa-base  rounded-lg shadow-xl max-w-md w-full p-6 mx-4">

                    <div class="flex items-center justify-center mb-4">
                        <svg class="w-16 h-16 text-casa-green " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>

                    <h2 class="text-2xl font-bold text-center mb-2">¡Email verificado con éxito!</h2>

                    <div class="text-center mt-10 pt-4">
                        <a href="/"
                            class="px-8 py-3 bg-casa-black text-white font-medium rounded-lg hover:bg-casa-black-h  transition">
                            Continuar
                        </a>
                    </div>


                </div>

            </div>
        @endif







        <section
            class="
    relative
    w-full
    h-[70vh]
    sm:max-h-[70vh]
    max-h-[360px]
    flex  flex-col items-center justify-center
    bg-[url('/public/mobile.png')]
    sm:bg-[url('/public/desktop.png')]
    bg-center
    bg-no-repeat
    bg-cover
    overflow-hidden
    
  ">
            <div class="bg-oange-500 w-fit order border-yellow-800 py-0 relative sm:-translate-y-4 -translate-y-6 ">


                <x-fancy-heading text="S{u}bast{a}s o{n}line " variant="italic mx-[0.5px] font-normal text-black"
                    class="text-[33px] sm:text-[57px] md:text-[59px] lg:text-[76px] xl:text-8xl  text-center text-wrap font-normal md:-mb-6 -mb-2 text-black md:!leading-[45px] !leading-[28px]  smext-green-400 mdext-red-500 lgext-blue-500 xlext-purple-700  " />
                <x-fancy-heading text="par{a} gent{e} re{a}l." variant="italic mx-[0.5px] font-normal text-black "
                    class="text-[33px] sm:text-[57px] md:text-[59px] lg:text-[76px] xl:text-8xl   text-center text-wrap font-normal text-black bg-red200 " />




                <div
                    class="md:h-32 w-full md:mx-auto bg-ed-400 pt-4 sm:pt-6 md:pt-8  lg:pt-10  order border-orange-700 text-  absolute top-full  left-1/2 -translate-x-1/2 ">

                    <h2
                        class="text-[18px] sm:text-[24px] text-xl font-bold  bg-red300 w-fi  md:mb-0 sm:text-nowrap hidden sm:flex mx-auto w-full bg-re100 text-center justify-center">
                        Cada objeto tiene una historia.
                    </h2>

                    <h2
                        class="text-[17px]  font-bold   sm:hidden flex mx-auto w-full bg-rd-100 text-center justify-center">
                        Cada objeto tiene
                    </h2>

                    <h2
                        class="text-[17px]   font-bold  sm:hidden flex mx-auto w-full bg-ed-100 text-center justify-center leading-3.5">
                        una historia.
                    </h2>

                    <h2 class="text-[17px] sm:text-[24px] font-bold bg-yellow-00 w-fit mx-auto">
                        Encontrá la tuya.
                    </h2>


                </div>


            </div>





            {{-- </div> --}}

            <a href="{{ route('subastas') }}"
                class="border rounded-4xl sm:px-3 px-2 py-1 sm:py-1.5 border-casa-black sm:mt-4 mt-2  bg-casa-black hover:bg-casa-base-2 hover:text-casa-black text-casa-base flex items-center mx-auto w-fit font-bold sm:text-base text-sm  absolute sm:bottom-3 bottom-1  left-1/2 -translate-x-1/2 "
                title="Ir a subastas">
                Quiero participar
                <svg class="sm:size-[20px] size-[17px]  sm:ml-4 ml-3 ">
                    <use xlink:href="#arrow-right1"></use>
                </svg>


            </a>
        </section>







        {{-- <section class="relative w-full overflow-hidden md:pt-10 pt-6 g-[#fbfbfb] bg-bue-300 md:pb-24 pb-1  hidden">


            <div
                class="hidden md:block absolute inset-0 z-0 h-40 w-[98%] swiper-home-pc translate-y-20 pointer-events-none bg-gren-300 mx-auto overflow-hidden">
                <div class="swiper-wrapper flex items-center h-full ease-linear ">
                    @for ($x = 0; $x < 3; $x++)
                        @foreach (range(1, 8) as $i)
                            <div class="swiper-slide flex justify-center items-center h-full w-fit bgcyan-950">
                                <img src="{{ asset("home/home$i.png") }}"
                                    class="md:h-40 object-contain mx-auto opacity-80 bg-ink-400" alt="Objeto vintage" />
                            </div>
                        @endforeach
                    @endfor
                </div>
            </div>

         
            <div class="relative -10 flex flex-col items-center justify-center w-full px-4 bg-rd-500 md:mt-8">

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

                <div class="md:hidden w-full mb-8 swiper-home-mb">
                    <div class="swiper-wrapper">
                        @foreach (range(1, 8) as $i)
                            <div class="swiper-slide">
                                <img src="{{ asset("home/home$i.png") }}" class="h-24 mx-auto object-contain" />
                            </div>
                        @endforeach
                    </div>
                </div>




                <div class="text-center md:mt-10 relative w-full">

                    <div
                        class="hidden md:block  inset-0 z-0 h-32 w-[90%] swiper-home-pc-2 translate-y- pointer-events-none bg-geen-300 mx-auto overflow-hidden bgyellow-500 ">
                        <div class="swiper-wrapper flex items-center h-full ease-linear  bg-green600">
                            @php
                                $ordenAlternativo = array_merge(range(4, 8), range(1, 3));
                            @endphp

                            @for ($x = 0; $x < 3; $x++)

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
                        class="bg-reen-600 w-full  mx-auto  z-40 md:h-32 md:-translate-y-6 md:absolute md:top-6  plae-self-center ">


                        <div class="md:h-32 w-fit md:mx-auto bg-ed-400 md:pt-5  md:px-2   bg-casa-base ">

                            <h2 class="md:text-3xl text-xl font-bold  bg-red300 w-fit md:mx-auto md:mb-2">
                                Cada objeto tiene una historia.
                            </h2>
                            <h2 class="md:text-3xl text-xl font-bold bg-yellow-00 w-fit md:mx-auto">
                                Encontrá la tuya.
                            </h2>

                
                        </div>
                    </div>


                </div>
            </div>

        </section> --}}

        <div class="w-full     [&>article]:max-w-8xl  md:px-16 xl:px-24 lg:mx-24 ">
            @livewire('subastas-abiertas')


            @livewire('buscador', ['todas' => true, 'from' => 'home'])


        </div>



        @if ($last)
            @livewire('destacados', ['subasta_id' => $last->id, 'titulo' => true, 'from' => 'home'])
        @endif



        @if (count($subastasProx))
            <div class="flex flex-col   w-full   items-center   md:px-16 xl:px-24 lg:mx-24 ">

                <div class="flex flex-col   w-full   items-center   max-w-8xl ">

                    <a href="{{ route('subastas') }}#proximas">
                        <x-fancy-heading text="s{u}bast{a}s p{r}óxim{a}s" variant="italic mx-[0.5px] font-normal"
                            class=" md:text-[32px] text-[20px]  text-center self-start sm:self-center md:ml-0 ml-6  text-wrap font-normal  mb-4" />
                    </a>
                    <div class="swiper-home-subastas     w-full  md:overflow-x-hidden md:px-0 px-4">

                        <div class="swiper-wrapper  flex sm:flex-row flex-col">
                            @foreach ($subastasProx as $item)
                                <a href="{{ route('subasta-proximas.lotes', $item->id) }}"
                                    class="flex flex-col bg-casa-black text-casa-base md:p-6 p-4  swiper-slide  md:mb-0 mb-4">


                                    <div class="flex justify-between items-center md:mb-4 mb-2">

                                        <p
                                            class="text-[26px]  md:text-[30px] lg:text-[36px] xl:text-[40px] font-caslon leading-[40px]">

                                            {{ $item->titulo }}
                                        </p>

                                        <svg class="size-[26px] ml-5 lg:ml-8 self-start flex-shrink-0">
                                            <use xlink:href="#arrow-right1"></use>
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

                                    <div class="flex justify-between md:text-[17px] lg:text-lg xl:text-xl text-sm">

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
                                        <x-modal-desc-extra-home :titulo="$item->titulo" :desc="$item->desc_extra" :route="route('subasta-proximas.lotes', $item->id)"
                                            enlace="text-casa-base hover:text-casa-base-2" />
                                    @endif



                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        @endif




        @if (count($subastasFin))
            <div class="flex flex-col   w-full   items-center md:px-16 xl:px-24 lg:mx-24 ">


                <div class="flex flex-col   w-full   items-center   max-w-8xl">

                    <a href="{{ route('subastas') }}#pasadas">
                        <x-fancy-heading text="s{u}bast{a}s p{a}sa{d}as" variant="italic mx-[0.5px] font-normal"
                            class=" md:text-[32px] text-[20px]  text-center self-start sm:self-center md:ml-0 ml-6  text-wrap font-normal  mb-4" />
                    </a>

                    <div class="swiper-home-subastas     w-full  md:overflow-x-hidden md:px-0 md:pl-[1px] px-4">

                        <div class="swiper-wrapper  flex sm:flex-row flex-col   ">

                            @foreach ($subastasFin as $item)
                                <a href="{{ route('subasta-pasadas.lotes', $item->id) }}"
                                    class="flex flex-col bg-casa-base-2 text-casa-black p-6  swiper-slide border border-casa-black/50 md:mb-0 mb-4">



                                    <div class="flex justify-between items-center md:mb-4 mb-2">

                                        <p
                                            class="text-[26px]  md:text-[30px] lg:text-[36px] xl:text-[40px] font-caslon leading-[40px]">

                                            {{ $item->titulo }}
                                        </p>

                                        <svg class="size-[26px] ml-5 lg:ml-8 self-start flex-shrink-0">
                                            <use xlink:href="#arrow-right1"></use>
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


                                    <div class="flex justify-between md:text-[17px] lg:text-lg xl:text-xl text-sm">
                                        <div class="flex
                                        flex-col mb-1.5">
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
                                        <x-modal-desc-extra-home :titulo="$item->titulo" :desc="$item->desc_extra"
                                            :route="route('subasta-pasadas.lotes', $item->id)" />
                                    @endif



                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        @endif


        {{-- 
        @guest
            <x-primera-vez />
        @endguest --}}



    </div>

</x-layouts.guest>
