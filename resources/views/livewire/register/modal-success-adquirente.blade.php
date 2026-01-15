<div class="fixed  inset-0 flex items-center justify-center  z-50 animate-fade-in-scale cursor-pointer">

    <div class="absolute inset-0  bg-gray-600/40 backdrop-blur-xs transition-opacity duration-300"></div>

    <div
        class = 'border  border-gray-500   md:max-w-5xl   w-auto  x-auto  z-50  shadow-gray-400 shadow-md max-h-[95%] 
                                                    transition delay-150 duration-300 ease-in-out  rounded-2xl  hover:lg:scale-110 hover:scale-105'>

        <div
            class=" lg:py-9 py-6 text-gray-700  text-start rounded-xl ml-0 flex flex-col bg-casa-base-2 justify-center items-center px-4 ">

            <h2 class="text-casa-black lg:text-3xl text-2xl text-center font-bold">¡Registro exitoso!</h2>

            <div class="flex flex-col itms-center  justify-center md:text-xl text-base mt-6 md:px-6 px-4 text-start">
                <p>¡Bienvenido! Solo nos falta asegurarnos de que sos vos. </p>
                <p>Te mandamos un correo, verificá tu e-mail para activar la cuenta. </p>
                <p>Si no lo ves, fijate en “correo no deseado”, movelo a la bandeja de entrada y ya está..</p>
            </div>

            <div class="flex text-casa-black justify-center lg:mt-12 mt-8 gap-10">


                <a href="{{ route('home') }}"
                    class="bg-casa-black  rounded-full text-2xl font-semibold px-6 py-1 hover:bg-casa-base hover:text-casa-black border border-casa-black text-casa-base flex items-center">
                    <span class=" pb-1"> Comencemos</span>
                    <svg fill="#fff" class="size-7  lg:ml-14 ml-8 ">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </a>

            </div>
        </div>

    </div>
</div>
