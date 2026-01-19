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
            class="relative w-full h-[70vh] sm:max-h-[70vh] max-h-[360px] flex idden  flex-col items-center justify-center  overflow-hidden ">
            <img src="{{ asset('img/desktop.png') }}" alt="Casa de subastas Casablanca"
                class="absolute inset-0 w-full h-full object-cover hidden sm:block" fetchpriority="high" />

            <img src="{{ asset('img/mobile.png') }}" alt="Casa de subastas Casablanca"
                class="absolute inset-0 w-full h-full object-cover sm:hidden" />

            <div class="bg-oange-500 w-fit order border-yellow-800 py-0 relative sm:-translate-y-4 -translate-y-6 ">

                <x-fancy-heading text="S{u}bast{a}s o{n}line " variant="italic mx-[0.5px] font-normal text-black "
                    class="text-[33px] sm:text-[57px] md:text-[59px] lg:text-[76px] xl:text-8xl  text-center text-wrap font-normal md:-mb-6 -mb-2 text-black md:!leading-[45px] !leading-[28px]  "
                    tag="h1" />
                <x-fancy-heading text="par{a} gent{e} re{a}l" variant="italic mx-[0.5px] font-normal text-black "
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



            <a href="{{ route('subastas') }}"
                class="border rounded-4xl sm:px-3 px-2 py-1 sm:py-1.5 border-casa-black sm:mt-4 mt-2  bg-casa-black hover:bg-casa-base-2 hover:text-casa-black text-casa-base flex items-center mx-auto w-fit font-bold sm:text-base text-sm  absolute sm:bottom-3 bottom-1  left-1/2 -translate-x-1/2 "
                title="Ir a subastas">
                Quiero participar
                <svg class="sm:size-[20px] size-[17px]  sm:ml-4 ml-3 ">
                    <use xlink:href="#arrow-right1"></use>
                </svg>
            </a>

        </section>



        <div class="w-full     [&>article]:max-w-8xl  md:px-16 xl:px-24 lg:mx-24 ">
            @livewire('subastas-abiertas')
            @livewire('buscador', ['todas' => true, 'from' => 'home'])
        </div>

        @if ($last)
            @livewire('destacados', ['subasta_id' => $last->id, 'titulo' => true, 'from' => 'home'])
        @endif



        @if ($subastasProx->isNotEmpty())
            <div class="flex flex-col   w-full   items-center   md:px-16 xl:px-24 lg:mx-24 ">

                <div class="flex flex-col   w-full   items-center   max-w-8xl ">

                    <a href="{{ route('subastas') }}#proximas">
                        <x-fancy-heading text="s{u}bast{a}s p{r}óxim{a}s" variant="italic mx-[0.5px] font-normal"
                            class=" md:text-[32px] text-[20px]  text-center self-start sm:self-center md:ml-0 ml-6  text-wrap font-normal  mb-4" />
                    </a>
                    <div class="swiper-home-subastas     w-full  md:overflow-x-hidden md:px-0 px-4">

                        <div class="swiper-wrapper  flex sm:flex-row flex-col">
                            @foreach ($subastasProx as $item)
                                <x-home.subasta-card :item="$item" :route="route('subasta-proximas.lotes', $item->id)" bg="bg-casa-black"
                                    text="text-casa-base" enlaceExtra="text-casa-base hover:text-casa-base-2" />
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        @endif




        @if ($subastasFin->isNotEmpty())
            <div class="flex flex-col   w-full   items-center md:px-16 xl:px-24 lg:mx-24 ">


                <div class="flex flex-col   w-full   items-center   max-w-8xl">

                    <a href="{{ route('subastas') }}#pasadas">
                        <x-fancy-heading text="s{u}bast{a}s p{a}sa{d}as" variant="italic mx-[0.5px] font-normal"
                            class=" md:text-[32px] text-[20px]  text-center self-start sm:self-center md:ml-0 ml-6  text-wrap font-normal  mb-4" />
                    </a>

                    <div class="swiper-home-subastas     w-full  md:overflow-x-hidden md:px-0 md:pl-[1px] px-4">

                        <div class="swiper-wrapper  flex sm:flex-row flex-col   ">

                            @foreach ($subastasFin as $item)
                                <x-home.subasta-card :item="$item" :route="route('subasta-pasadas.lotes', $item->id)" bg="bg-casa-base-2"
                                    text="text-casa-black" border="border border-casa-black/50" />
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        @endif



        @guest
            <x-home.primera-vez />
        @endguest



    </div>

</x-layouts.guest>
