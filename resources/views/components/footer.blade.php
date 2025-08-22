<footer class=" text-white  mt-20 g-red-300 flex flex-col">




    <div
        class="relative flex flex-col bg-casa-fondo w-5/6 mx-auto justify-center px-20  pb-8 pt-2  h-58  text-casa-black border border-casa-black  z-10">
        <h2 class="text-[64px] font-librecaslon">¿Tenés algo para vender?</h2>

        <div class="flex  justify-between ">

            <div class="flex flex-col text-xl">
                <p>Completá el formulario, contanos qué querés rematar y lo evaluamos sin compromiso.</p>
                <p>Podés vender objetos únicos, antiguos, en desuso o con valor histórico o práctico.</p>
            </div>

            <button
                class="bg-casa-black hover:bg-transparent hover:text-black text-gray-50 rounded-full px-4 flex items-center justify-between gap-x-5 py-1  border border-gray-800 text-nowrap text-xl font-bold h-fit self-start ">
                Quiero tasar
                <svg fill="#fff" class="size-8  ml-8">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </button>

        </div>
    </div>



    <div class="relative flex flex-col bg-casa-black -mt-29 ">





        <div
            class="flex flex-col bg-casa-black w-5/6 mx-auto justify-center px-20 pb-8 pt-2  h-58 mt-50 border border-x-casa-fondo-h">
            <h2 class="text-[64px] font-librecaslon">¿Tenés alguna duda?</h2>

            <div class="flex  justify-between ">

                <div class="flex flex-col text-xl">
                    <p>Lorem ipsum dolor sit amet consectetur. Arcu sagittis ornare aliquet morbi justo. </p>
                    <p>Fringilla egestas nunc nulla eros sed nulla tristique.</p>
                </div>

                <button
                    class="bg-casa-fondo hover:bg-transparent hover:text-white text-casa-black rounded-full px-4 flex items-center justify-between gap-x-5 py-1  border border-casa-fondo-h text-nowrap text-xl font-bold h-fit self-start ">
                    Contactanos
                    <svg fill="#fff" class="size-8  ml-8">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </button>

            </div>
        </div>




        <div class="flex flex-col ">

            <div class=" my-20 py-12 grid grid-cols-5   px-20 ">

                <a href="{{ route('home') }}" class=" hover:scale-105  mx-auto">
                    <svg fill="#fff" class="w-59 h-7 ">
                        <use xlink:href="#casa-icon"></use>
                    </svg>
                </a>


                <ul class=" mx-auto space-y-4">
                    <li><a href=""
                            class="border border-casa-fondo-h rounded-full px-3 py-1 hover:bg-casa-black hover:text-casa-fondo-h">Comitentes</a>
                    </li>
                    <li><a href=""
                            class="border border-casa-fondo-h rounded-full px-3 py-1 hover:bg-casa-black hover:text-casa-fondo-h">Adquirentes</a>
                    </li>
                    <li><a href=""
                            class="border border-casa-fondo-h rounded-full px-3 py-1 hover:bg-casa-black hover:text-casa-fondo-h">Subastas</a>
                    </li>

                </ul>

                <ul class="space-y-3">
                    <li>Próximas subastas</li>
                    <li>Objetos </li>
                    <li>Vinilos </li>
                    <li>Arte </li>
                </ul>

                <ul class="space-y-3">
                    <li>¿Primera vez en un subasta? </li>
                    <li>¿Qué opinan de casablanca.ar? </li>
                    <li>¿Tenés algo para vender? </li>
                    <li>¿Tenés alguna duda?</li>
                </ul>

                <ul class="flex  gap-3">
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
    {{-- </div> --}}

    <div class="flex  w-full justify-between text-casa-fondo-h py-6 px-20 border-t-2 border-casa-base-2  bg-casa-black">
        <p>&copy; 2025 Creado por casablanca.ar</p>
        <p>&copy; Diseñado por <a href="https://www.crabbystudio.com/" target="_blank" class="underline"> Crabby
                Studio</a></p>

    </div>


    </div>
</footer>
