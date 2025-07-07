<div class="fixed  inset-0 flex items-center justify-center  z-50 animate-fade-in-scale cursor-pointer">

    <div class="absolute inset-0  bg-gray-600/40 backdrop-blur-xs transition-opacity duration-300"></div>

    <div
        class = ' border  border-gray-500   md:max-w-xl  lg:w-[40%] w-[90%] x-auto  z-50  shadow-gray-400 shadow-md max-h-[95%] 
                                                    transition delay-150 duration-300 ease-in-out  rounded-2xl  hover:scale-110'>

        <div
            class=" py-9 text-gray-700  text-start rounded-xl ml-0 flex flex-col bg-green-500 justify-center items-center">
            <h2 class="text-white text-2xl text-center font-bold">¡Registro exitoso!</h2>

            <div class="flex text-white justify-center mt-12 gap-10">
                <button class="bg-cyan-900  rounded-2xl px-3 py-1 hover:bg-cyan-950" wire:click="close">Login</button>
                <button class="bg-orange-900  rounded-2xl px-3 py-1 hover:bg-orange-950" wire:click="home">Home</button>

            </div>
        </div>

    </div>
</div>
