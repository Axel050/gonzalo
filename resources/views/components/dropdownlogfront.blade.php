<div class="    relative rounded-lg px-0  h-8  z-50" x-data="{ open: false }" @click="open = ! open"
    @click.outside="open = false" x :class="{ ' block idden lock transition-all duration-1000': !openSide }">


    <div class="flex   justify-start items-center py-0.5 pl-2 borde rounded-sm   hover:bg-casa-fondo-h"
        :class="{ 'bg-casa-fondo-h rounded-b-none border border-gray-600 border-b-0': open }">

        <span class="ml-2 mr-2    truncate text-sm lg:text-base text-gray-800 ">
            {{ Auth::user()->name }}
        </span>

        <svg fill="#fff" class="size-9 ">
            <use xlink:href="#user"></use>
        </svg>

    </div>


    <div class="flex flex-col  absolute botton-1.5 right-0     text-gray-500 px-4 gap-y-1  rounded-sm rounded-tr-none border border-gray-500 bg-casa-fondo-h transition-all duration-1000 ease-in-out "
        x-show="open" {{-- transition:enter.duration.500ms x-transition:leave.duration.400ms --}}>

        <div class=" my-2 px-1 border-gray-400 w-full flex flex-col ">
            <p class="font-medium text-sm text-gray-600 p-1  truncte mb-2 ">{{ Auth::user()->email }}</p>


            @role(['adquirente'])
                <a href="{{ route('adquirentes.perfil') }}"
                    class="ilex items-center   hover:text-gray-200 hover:font-bold  hover:bg-casa-black  mb-2 text-gray-800 mt-1 rounded-full px-4 py-1 border border-casa-black">
                    Perfil
                </a>
            @endrole

            @role(['admin', 'super-admin'])
                <a href="{{ url('/dashboard') }}"
                    class="ilex items-center   hover:text-gray-200 hover:font-bold  hover:bg-casa-black  mb-2 text-gray-800 mt-1 rounded-full px-4 py-1 border border-casa-black">
                    Dashboard
                </a>
            @endrole


            {{-- <a href=""
                class="font-medium  text-gray-200 p-1 pl-3 hover:text-gray-200 hover:font-bold  hover:bg-cyan-900 rounded-lg ">Perfil</a> --}}

            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf

                <a href="{{ route('logout') }}"
                    class="flex items-center p-1   hover:bg-casa-base-2  mb-2 text-casa-base hover:text-casa-black border border-casa-black px-4 py-1 rounded-full bg-casa-black text-nowrap"
                    @click.prevent="$root.submit();">

                    <svg fill="currentColor" class="size-7 ">
                        <use xlink:href="#exit"></use>
                    </svg>
                    Cerrar sesión
                </a>
            </form>
        </div>

    </div>
</div>
