<div class="fixed  inset-0 flex items-center justify-center  z-50 animate-fade-in-scale">


    <div class="absolute inset-0  bg-gray-600/70 backdrop-blur-xs transition-opacity duration-300"
        wire:click="$parent.$set('method',false)">
    </div>

    <div
        class = "border border-gray-500 md:max-w-[90%] lg:w-auto w-[90%]
      x-auto z-50 shadow-gray-400 shadow-md max-h-[95%] transition delay-150 duration-300 ease-in-out rounded-2xl ">

        <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
            <div class="flex  flex-col justify-center items-center  ">
                <h2
                    class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg bg-purple-900">
                    Acceso a puja
                </h2>
                {{-- @dump($subasta) --}}
                {{-- @dump($adquirente) --}}
                <div class="w-full   flex flex-col  items-center  p-8 text-gray-500  ">

                    <p class="text-xl text-gray-700">Para poder participar de la puja debe tener depositada una garantia
                        .
                    </p>

                </div>



                <div
                    class="flex
                        !flex-row justify-between text-center lg:text-base text-sm text-white ">
                    <div class="flex justify-center  w-full space-x-6">

                        <button type="button" wire:click="$parent.$set('method',false)"
                            class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 ">
                            Salir
                        </button>

                        <button type="button" wire:click="mp"
                            class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 ">
                            Pagar
                        </button>




                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
</div>
