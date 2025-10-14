<div class="fixed  inset-0 flex items-center justify-center  z-50 animate-fade-in-scale cursor-pointer">

    <div class="absolute inset-0  bg-gray-600/40 backdrop-blur-xs transition-opacity duration-300"></div>

    <div
        class = ' border  border-gray-500   md:max-w-xl  lg:w-[40%] w-[90%] x-auto  z-50  shadow-gray-400 shadow-md max-h-[95%] 
                                                    transition delay-150 duration-300 ease-in-out  rounded-2xl  hover:lg:scale-110 hover:scale-105'>

        <div
            class=" py-9 text-gray-700  text-start rounded-xl ml-0 flex flex-col bg-casa-base-2 justify-center items-center">
            <h2 class="text-casa-black lg:text-3xl text-2xl text-center font-bold">¡Registro exitoso!</h2>

            <div class="flex text-casa-black justify-center mt-12 gap-10">
                {{-- @if ($from)
                    <button
                        class="bg-casa-base  rounded-2xl px-6 py-1 hover:bg-casa-black border border-casa-black hover:text-casa-base"
                        wire:click="close">Login</button>
                @endif --}}
                {{-- <button
                    class="bg-casa-black  rounded-2xl px-6 py-1 hover:bg-casa-base hover:text-casa-black border border-casa-black text-casa-base"
                    wire:click="home">Ir a inicio</button> --}}
                <a href="{{ route('home') }}"
                    class="bg-casa-black  rounded-full text-2xl font-semibold px-6 py-1 hover:bg-casa-base hover:text-casa-black border border-casa-black text-casa-base flex items-center">
                    <span class=" pb-1"> Comencemos</span>
                    <svg fill="#fff" class="size-7  lg:ml-14 ml-10 ">
                        <use xlink:href="#arrow-right"></use>
                    </svg>


                </a>

            </div>
        </div>

    </div>
</div>
