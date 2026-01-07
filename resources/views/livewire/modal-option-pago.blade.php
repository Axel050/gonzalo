<div class="fixed  inset-0 flex  justify-center items-center  z-50 animate-fade-in-scale">


    <div class="absolute inset-0  bg-gray-600/70 backdrop-blur-xs transition-opacity duration-300"
        wire:click="$parent.$set('modalPago',false)">
    </div>

    {{-- <div
        class = "border border-gray-500 md:max-w-[90%] md:w-auto w-[90%]
      x-auto z-50 shadow-gray-400 shadow-md max-h-[95%] transition delay-150 duration-300 ease-in-out rounded-2xl "> --}}

    <article
        class=" flex idden  md:w-fit w-[90%]  md:justify-center justify-start flex-col md:mt-10 mt-6 mb-8 mx-auto md:px-20 md:py-12 px-6 py-10  bg-casa-fondo-h border border-casa-black z-50 h-fit">


        <h2 class=" font-bold md:text-3xl  text-xl text-center">¿Cómo puedo pagar?</h2>

        <div
            class="     grid md:grid-cols-2 grid-cols-1     w-6/6  mx-auto justify-between md:pl-3 md:pr-1 py-1 items-start md:mt-5 mt-4 border-casa-black md:text-xl text-sm gap-8 ">

            <div class="flex flex-col   md:px-4 mb-3 col-span-2  ">
                <h3 class="font-bold text-center  md:mb-1 mb-0.5">Transferencia bancaria.</h3>
                <p class="text-pretty text-center ">
                    Podés abonar transfiriendo a : </p>
                <p class="text-pretty text-center ">alias: <b class="font-semibold">casa-blanca.ar.mp</b>
                </p>
                <p class="text-pretty text-center ">CBU: <b class="font-semibold">1212212121</b></p>
                <p class="text-pretty text-center ">Monto: <b
                        class="font-semibold">${{ number_format($monto, 0, ',', '.') }}</b></p>

            </div>

            {{-- <div class="flex flex-col   md:px-4 mb-3">
                <h3 class="font-bold md:text-center text-start md:mb-1 mb-0.5">Mercado Pago.</h3>
                <p class="text-pretty md:text-center text-start">Podés pagar directamente desde tu cuenta de Mercado
                    Pago.</p>

                <button
                    class="bg-casa-black hover:bg-transparent hover:text-casa-black border border-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-1  col-span-3 mx-auto  md:text-xl font-semibold text-sm md:w-fit  w-full md:order-2 mt-2"
                    wire:click="mp">
                    Pagar <svg class="size-6 ml-5">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </button>

            </div> --}}



        </div>


        <div
            class="flex md:flex-row flex-col md:gap-20 gap-3 md:w-fit w-full md:justify-center mx-auto items-center md:mt-5 mt-3">


            <button
                class="bg-casa-fondo-h hover:bg-casa-black hover:text-casa-base border border-casa-black text-casa-black  rounded-full px-4 flex items-center justify-between  md:py-0.5 py-1 col-span-3 mx-auto  md:text-xl font-semibold text-sm md:w-fit lg w-full h-fit"
                wire:click="$parent.$set('modalPago',false)">
                Salir
                <span class=" ml-3 md:h-8 h-6 mt-0.5">X</span>
            </button>
        </div>

    </article>




    {{-- <div class="flex justify-center  w-full space-x-6">

                        <button type="button" wire:click="$parent.$set('method',false)"
                            class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 md:py-1 py-0.5 ">
                            Salir
                        </button>

                        <button type="button" wire:click="mp"
                            class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 md:py-1 py-0.5 ">
                            Pagar
                        </button>

                    </div> --}}



    {{-- </div> --}}
</div>
