<div class="fixed  inset-0 flex  justify-center items-center  z-50 animate-fade-in-scale">


    <div class="absolute inset-0  bg-gray-600/70 backdrop-blur-xs transition-opacity duration-300"
        wire:click="$parent.$set('method',false)">
    </div>

    {{-- <div
        class = "border border-gray-500 md:max-w-[90%] lg:w-auto w-[90%]
      x-auto z-50 shadow-gray-400 shadow-md max-h-[95%] transition delay-150 duration-300 ease-in-out rounded-2xl "> --}}

    <article
        class=" flex idden  lg:w-5/6 w-[90%]  lg:justify-center justify-start flex-col lg:mt-10 mt-6 mb-8 mx-auto lg:px-12 lg:py-12 px-6 py-10  bg-casa-fondo-h border border-casa-black z-50 h-fit">


        <h2 class=" font-bold lgtext-3xl  text-xl lg:text-center text-start">¿Como puedo ofertar?</h2>

        <div
            class="     lg:grid lg:grid-cols-3 grid-cols-1     w-6/6  mx-auto justify-between lg:pl-3 lg:pr-1 py-1 items-start lg:mt-5 mt-4 border-casa-black lg:text-xl text-sm gap-8 ">

            <div class="flex flex-col   lg:px-4 mb-3">
                <h3 class="font-bold lg:text-center text-start lg:mb-1 mb-0.5">Ingresá.</h3>
                <p class="text-pretty lg:text-center text-start">Para poder ofertar necesitás abonar un seguro
                    reembolsable.
                    Si no comprás,
                    te lo
                    devolvemos.</p>
            </div>
            <div class="flex flex-col   lg:px-4 mb-3">
                <h3 class="font-bold lg:text-center text-start lg:mb-1 mb-0.5">Ofertá.</h3>
                <p class="text-pretty lg:text-center text-start">Si al terminar la subasta nadie más ofrece, el
                    producto es
                    tuyo.
                    Si alguien más ofertó al final de la subasta, tenés 2 min más para pujar.</p>
            </div>
            <div class="flex flex-col   lg:px-4">
                <h3 class="font-bold lg:text-center text-start lg:mb-1 mb-0.5">No te muevas de tu casa.</h3>
                <p class="text-pretty lg:text-center text-start">Todo es online: mirás, ofertás y pagás desde donde
                    estés.
                    Si ganás, coordinamos la entrega con vos.</p>
            </div>




        </div>


        <div
            class="flex lg:flex-row flex-col lg:gap-20 gap-3 lg:w-fit w-full lg:justify-center mx-auto items-center lg:mt-5 mt-3">

            <button
                class="bg-casa-black hover:bg-transparent hover:text-casa-black border border-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-1  col-span-3 mx-auto  lg:text-xl font-semibold text-sm lg:w-fit  w-full lg:order-2"
                wire:click="mp">
                Quiero entrar
                <svg class="size-7 ml-5">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </button>

            <button
                class="bg-casa-fondo-h hover:bg-casa-black hover:text-casa-base border border-casa-black text-casa-black  rounded-full px-4 flex items-center justify-between  lg:py-0.5 py-1 col-span-3 mx-auto  lg:text-xl font-semibold text-sm lg:w-fit lg w-full h-fit"
                wire:click="$parent.$set('method',false)">
                Salir
                <span class=" ml-3 lg:h-8 h-6 mt-0.5">X</span>
            </button>
        </div>

    </article>




    {{-- <div class="flex justify-center  w-full space-x-6">

                        <button type="button" wire:click="$parent.$set('method',false)"
                            class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 ">
                            Salir
                        </button>

                        <button type="button" wire:click="mp"
                            class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 ">
                            Pagar
                        </button>

                    </div> --}}



    {{-- </div> --}}
</div>
