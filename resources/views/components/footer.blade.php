<footer class=" text-white  mt-20 g-red-300 flex flex-col w-full">


    <div
        class="relative flex flex-col bg-casa-ondo  w-full justify-center md:px-24 px-    md:h-58  text-casa-black   z-10  ">

        <div
            class="max-w-8xl border border-casa-black md:px-20 px-4 md:py-12 py-8 relative bg-casa-base-2 self-center w-full">

            {{-- 
          <h2 class="md:text-[64px] text-[37px] md:leading-26 leading-9 font-librecaslon text-center">¿Tenés amdo para
            vender?</h2> --}}
            {{--  --}}
            {{-- <h2 class="text-6xl font-helvetica text-casa-black">
          ¿Tenés <span class="font-librecaslon italic">amdo</span> para vender?
</h2> --}}

            <x-fancy-heading text="¿Te{n}és al{g}o p{a}ra v{e}n{d}er?"
                class=" md:text-[64px] text-[37px] leading-9 text-start  md:mb-1 text-wrap" />



            {{--  --}}
            <div class="flex  justify-between md:flex-row flex-col md:mt-0 mt-5 ">
                <div class="flex flex-col md:text-xl text-sm">
                    <p>Completá el formulario, contanos qué querés rematar y lo evaluamos sin compromiso.</p>
                    <p>Podés vender objetos únicos, antiguos, en desuso o con valor histórico o práctico.</p>
                </div>

                <a href="{{ route('comitentes.create') }}"
                    class="bg-casa-black hover:bg-transparent hover:text-casa-black text-casa-base rounded-full px-4 flex items-center justify-between gap-x-5 py-2  border border-gray-800 text-nowrap md:text-xl text-sm font-bold   h-fit self-start  md:w-fit w-full md:mt-0 mt-5">
                    Quiero tasar
                    <svg fill="#fff" class="size-[26px]    ml-8 ">
                        <use xlink:href="#arrow-right1"></use>
                    </svg>
                </a>

            </div>
        </div>
    </div>

    <div class="relative flex flex-col bg-casa-black md:-mt-29 md:px-24">

        <div
            class="flex flex-col bg-casa-black  w-full mx-auto justify-center  md:px-20 px-4  md:py-12  md:h-58 md:mt-50 md:border border-b-1 border-x-casa-fondo-h py-8 max-w-8xl">
            {{-- <h2 class="md:text-[64px] text-[37px] md:leading-26 leading-9 font-librecaslon text-center">¿Tenés amduna
                duda?</h2> --}}

            <x-fancy-heading text="¿Te{n}és al{g}un{a} du{d}a?"
                class=" md:text-[64px] text-[37px] leading-9 text-start  md:mb-1 text-wrap text-casa-base" />


            <div class="flex  justify-between md:flex-row flex-col md:mt-0 mt-5 ">

                <div class="flex flex-col md:text-xl text-sm">
                    <p>Lorem ipsum dolor sit amet consectetur. Arcu sagittis ornare aliquet morbi justo. </p>
                    <p>Fringilla egestas nunc nulla eros sed nulla tristique.</p>
                </div>

                <a href="mailto:info@casablanca.ar"
                    class="bg-casa-fondo hover:bg-transparent hover:text-casa-base text-casa-black rounded-full px-4 flex items-center justify-between gap-x-5 py-2  border border-casa-fondo-h text-nowrap text-xl font-bold h-fit self-start md:w-fit w-full md:mt-0 mt-5">
                    Contactanos
                    <svg fill="#fff" class="size-[26px]    ml-8 ">
                        <use xlink:href="#arrow-right1"></use>
                    </svg>
                </a>

            </div>
        </div>


        <div class="  md:px-0 px-4  w-full text-center ">

            <div
                class="grid md:grid-cols-4 grid-cols-2   md:py-15  py-8 md:pb-10 md:pt-20  d:px-24 px4 items-center max-w-8xl  mx-auto">

                <div class="col-span-1 order-1">

                    <a href="{{ route('home') }}" class=" over:scale-105">
                        <svg fill="#fff" class="w-59  h-7  md:flex hidden">
                            <use xlink:href="#casa-icon"></use>
                        </svg>

                        <svg fill="#ffffff" class="w-28  h-5  md:hidden flex  text-white">
                            <use xlink:href="#casa-icon-mb"></use>
                        </svg>
                    </a>

                </div>

                <ul
                    class=" md:mx-auto space-x-4 flex md:flex-row  flex-col  md:order-2  order-3 gap-y-2 space-y-2  text-sm col-span-2 items-start md:mt-0 mt-3">
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
                            amdo para vender?</a>
                    </li>
                </ul>


                <ul class="flex  gap-3 col-span-1   justify-end md:order-3  order-2">
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
    </div>


    <div
        class="flex  md:flex-row flex-col w-full  text-casa-fondo-h py-6 md:px-24 px-4 border-t-2 border-casa-base-2  bg-casa-black  pb-18 ">
        <div class="max-w-8xl flex  md:flex-row flex-col md:justify-between w-full  mx-auto">
            <p>&copy; 2025 Creado por <a href="https://www.aisolucionesweb.com/"
                    class="hover:text-casa-base font-semibold hover:font-bold">aisolucionesweb</a></p>
            <p>&copy; Diseñado por
                <a href="https://www.crabbystudio.com/" target="_blank" class="underline"> CrabbyStudio</a>
            </p>
        </div>
    </div>


    </div>
</footer>
