<footer class=" text-white  mt-20 g-red-300 flex flex-col ">


    <div
        class="relative flex flex-col bg-casa-fondo lg:w-5/6 w-full mx-auto justify-center lg:px-20 px-4  lg:pb-8 lg:pt-2  lg:h-58  text-casa-black border border-casa-black  z-10 py-8  ">
        {{-- 
        <h2 class="lg:text-[64px] text-[37px] lg:leading-26 leading-9 font-librecaslon text-center">¿Tenés algo para
            vender?</h2> --}}
        {{--  --}}
        {{-- <h2 class="text-6xl font-helvetica text-casa-black">
  ¿Tenés <span class="font-librecaslon italic">algo</span> para vender?
</h2> --}}

        <x-fancy-heading text="¿Te{n}és al{g}o p{a}ra v{e}n{d}er?"
            class=" md:text-[64px] text-[37px] leading-9 text-start  md:mb-1 text-wrap" />



        {{--  --}}
        <div class="flex  justify-between lg:flex-row flex-col lg:mt-0 mt-5 ">
            <div class="flex flex-col lg:text-xl text-sm">
                <p>Completá el formulario, contanos qué querés rematar y lo evaluamos sin compromiso.</p>
                <p>Podés vender objetos únicos, antiguos, en desuso o con valor histórico o práctico.</p>
            </div>

            <a href="{{ route('comitentes.create') }}"
                class="bg-casa-black hover:bg-transparent hover:text-black text-gray-50 rounded-full px-4 flex items-center justify-between gap-x-5 py-1  border border-gray-800 text-nowrap lg:text-xl text-sm font-bold h-fit self-start  lg:w-fit w-full lg:mt-0 mt-5">
                Quiero tasar
                <svg fill="#fff" class="size-8  ml-8">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </a>

        </div>
    </div>

    <div class="relative flex flex-col bg-casa-black lg:-mt-29 ">

        <div
            class="flex flex-col bg-casa-black lg:w-5/6 w-full mx-auto justify-center  lg:px-20 px-4  lg:pb-8 lg:pt-2  lg:h-58 lg:mt-50 lg:border border-b-1 border-x-casa-fondo-h py-8">
            {{-- <h2 class="lg:text-[64px] text-[37px] lg:leading-26 leading-9 font-librecaslon text-center">¿Tenés alguna
                duda?</h2> --}}

            <x-fancy-heading text="¿Te{n}és al{g}un{a} du{d}a?"
                class=" md:text-[64px] text-[37px] leading-9 text-start  md:mb-1 text-wrap text-casa-base" />


            <div class="flex  justify-between lg:flex-row flex-col lg:mt-0 mt-5 ">

                <div class="flex flex-col lg:text-xl text-sm">
                    <p>Lorem ipsum dolor sit amet consectetur. Arcu sagittis ornare aliquet morbi justo. </p>
                    <p>Fringilla egestas nunc nulla eros sed nulla tristique.</p>
                </div>

                <a href="mailto:info@casablanca.ar"
                    class="bg-casa-fondo hover:bg-transparent hover:text-white text-casa-black rounded-full px-4 flex items-center justify-between gap-x-5 py-1  border border-casa-fondo-h text-nowrap text-xl font-bold h-fit self-start lg:w-fit w-full lg:mt-0 mt-5">
                    Contactanos
                    <svg fill="#fff" class="size-8  ml-8">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </a>

            </div>
        </div>


        <div class="grid lg:grid-cols-4 grid-cols-2   lg:py-15  py-8 lg:pb-10 lg:pt-20  lg:px-24 px-4 items-center">

            <div class="col-span-1 order-1">

                <a href="{{ route('home') }}" class=" over:scale-105">
                    <svg fill="#fff" class="w-59  h-7  lg:flex hidden">
                        <use xlink:href="#casa-icon"></use>
                    </svg>

                    <svg fill="#ffffff" class="w-28  h-5  lg:hidden flex  text-white">
                        <use xlink:href="#casa-icon-mb"></use>
                    </svg>
                </a>
            </div>

            <ul
                class=" lg:mx-auto space-x-4 flex lg:flex-row  flex-col  lg:order-2  order-3 gap-y-2 space-y-2  text-sm col-span-2 items-start lg:mt-0 mt-3">
                <li><a href="{{ route('subastas') }}"
                        class="border border-casa-fondo-h rounded-full px-3 py-1 hover:bg-casa-black hover:text-casa-fondo-h">Subastas</a>
                </li>
                @guest

                    <li>
                        <a href="{{ route('adquirentes.create') }}"
                            class="border border-casa-fondo-h rounded-full px-3 py-1 hover:bg-casa-black hover:text-casa-fondo-h">¿Primera
                            vez?</a>
                    </li>
                @endguest
                <li><a href="{{ route('comitentes.create') }}"
                        class="border border-casa-fondo-h rounded-full px-3 py-1 hover:bg-casa-black hover:text-casa-fondo-h">¿Tenés
                        algo para vender?</a>
                </li>
            </ul>


            <ul class="flex  gap-3 col-span-1   justify-end lg:order-3  order-2">
                <li>
                    <a href="">
                        <svg class="size-8  ">
                            <use xlink:href="#instagram-foo"></use>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="">
                        <svg class="size-8  ">
                            <use xlink:href="#whtz-foo"></use>
                        </svg>
                    </a>
                </li>
                <li>
                    <a href="">
                        <svg class="size-8  ">
                            <use xlink:href="#mail-foo"></use>
                        </svg>
                    </a>
                </li>
            </ul>

        </div>
    </div>


    <div
        class="flex  lg:flex-row flex-col w-full lg:justify-between   text-casa-fondo-h py-6 lg:px-24 px-4 border-t-2 border-casa-base-2  bg-casa-black  pb-10 text-start">
        <p>&copy; 2025 Creado por casablanca.ar</p>
        <p>&copy; Diseñado por
            <a href="https://www.crabbystudio.com/" target="_blank" class="underline"> CrabbyStudio</a>
        </p>
    </div>


    </div>
</footer>
